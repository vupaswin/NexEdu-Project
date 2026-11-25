<?php
session_start();

// NEX-301 (Sub-task 1): Session guard — redirect unauthenticated visitors to login.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");
mysqli_set_charset($conn, "utf8mb4");

$success_msg = "";
$error_msg   = "";

// NEX-302: Handle POST mutations (Delete by Job Reference & Update EOI Status)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';

    // Query 4: Delete all EOIs for a specified Job Reference
    if ($action === 'delete_by_job_ref') {
        $del_job_ref = isset($_POST['delete_job_ref']) ? strtoupper(trim($_POST['delete_job_ref'])) : "";

        if ($del_job_ref === "" || !preg_match('/^[A-Z0-9]{1,5}$/', $del_job_ref)) {
            $error_msg = "Please enter a valid Job Reference (1 to 5 letters/digits, e.g. ED101).";
        } else {
            $del_stmt = mysqli_prepare($conn, "DELETE FROM eoi WHERE job_ref = ?");
            if ($del_stmt) {
                mysqli_stmt_bind_param($del_stmt, "s", $del_job_ref);
                if (mysqli_stmt_execute($del_stmt)) {
                    $deleted_count = mysqli_stmt_affected_rows($del_stmt);
                    if ($deleted_count > 0) {
                        $success_msg = "Deleted $deleted_count EOI record(s) for Job Reference $del_job_ref.";
                    } else {
                        $success_msg = "No EOI records found for Job Reference $del_job_ref (0 deleted).";
                    }
                } else {
                    $error_msg = "Failed to delete EOI records. Please try again.";
                }
                mysqli_stmt_close($del_stmt);
            } else {
                $error_msg = "Unable to prepare delete statement.";
            }
        }
    }

    // Query 5: Update EOI status ('New', 'Current', or 'Final')
    if ($action === 'update_status') {
        $eoi_number_raw = $_POST['eoi_number'] ?? '';
        $new_status     = isset($_POST['status']) ? trim($_POST['status']) : '';
        $eoi_number     = filter_var($eoi_number_raw, FILTER_VALIDATE_INT);

        $allowed_statuses = ['New', 'Current', 'Final'];

        if ($eoi_number === false || $eoi_number <= 0) {
            $error_msg = "Invalid EOI number provided for status update.";
        } elseif (!in_array($new_status, $allowed_statuses, true)) {
            $error_msg = "Invalid status value. Allowed values: New, Current, Final.";
        } else {
            $upd_stmt = mysqli_prepare($conn, "UPDATE eoi SET status = ? WHERE EOInumber = ?");
            if ($upd_stmt) {
                mysqli_stmt_bind_param($upd_stmt, "si", $new_status, $eoi_number);
                if (mysqli_stmt_execute($upd_stmt)) {
                    $success_msg = "Updated EOI #$eoi_number status to '$new_status'.";
                } else {
                    $error_msg = "Failed to update status for EOI #$eoi_number.";
                }
                mysqli_stmt_close($upd_stmt);
            } else {
                $error_msg = "Unable to prepare status update statement.";
            }
        }
    }
}

// Read and trim GET filter inputs
$filter_job_ref    = isset($_GET['job_ref']) ? strtoupper(trim($_GET['job_ref'])) : "";
$filter_first_name = isset($_GET['first_name']) ? trim($_GET['first_name']) : "";
$filter_last_name  = isset($_GET['last_name']) ? trim($_GET['last_name']) : "";

// NEX-303: Strict whitelist validation for dynamic column sorting
$allowed_sorts  = ['EOInumber', 'job_ref', 'first_name', 'last_name', 'status', 'eoi_date'];
$requested_sort = isset($_GET['sort']) ? $_GET['sort'] : 'EOInumber';
$sort_col       = in_array($requested_sort, $allowed_sorts, true) ? $requested_sort : 'EOInumber';

// Helper to build sort links while keeping active search filters
function build_sort_url(string $column, string $job_ref, string $first_name, string $last_name): string {
    $params = [];
    if ($job_ref !== "") {
        $params['job_ref'] = $job_ref;
    }
    if ($first_name !== "") {
        $params['first_name'] = $first_name;
    }
    if ($last_name !== "") {
        $params['last_name'] = $last_name;
    }
    $params['sort'] = $column;
    return "manage.php?" . http_build_query($params);
}

// Build WHERE conditions dynamically using prepared statement parameters
$where_clauses = [];
$param_types   = "";
$param_values  = [];

// NEX-301 (Query 2): Filter by exact Job Reference (e.g. ED101)
if ($filter_job_ref !== "") {
    $where_clauses[] = "job_ref = ?";
    $param_types    .= "s";
    $param_values[]  = $filter_job_ref;
}

// NEX-301 (Query 3): Filter by applicant first name and/or last name using LIKE
if ($filter_first_name !== "") {
    $where_clauses[] = "first_name LIKE ?";
    $param_types    .= "s";
    $param_values[]  = "%" . $filter_first_name . "%";
}

if ($filter_last_name !== "") {
    $where_clauses[] = "last_name LIKE ?";
    $param_types    .= "s";
    $param_values[]  = "%" . $filter_last_name . "%";
}

// NEX-301 (Query 1) + NEX-303 (Query 6): Select EOIs ordered by whitelisted column
$sql = "SELECT EOInumber, job_ref, first_name, last_name, dob, gender, address, suburb, state, postcode, email, phone, skills, other_skills, status, eoi_date FROM eoi";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY $sort_col ASC";

$eois = [];
$query_error = "";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    if ($param_types !== "") {
        mysqli_stmt_bind_param($stmt, $param_types, ...$param_values);
    }
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $eois[] = $row;
        }
        mysqli_free_result($result);
    } else {
        $query_error = "Unable to retrieve candidate applications right now.";
    }
    mysqli_stmt_close($stmt);
} else {
    $query_error = "Unable to prepare the application query.";
}

mysqli_close($conn);
?>
<?php include("modules/header.inc"); ?>
<?php include("modules/nav.inc"); ?>

  <main id="main-content" class="container">
    <div class="section-header">
      <span class="badge">Authenticated HR Portal</span>
      <h1>HR Management Dashboard</h1>
      <p>
        Signed in as <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?></strong>.
        Review, search, sort, and manage candidate Expressions of Interest (EOIs).
      </p>
      <div class="manage-toolbar">
        <a href="manage.php" class="btn btn-outline">Show All EOIs</a>
        <a href="logout.php" class="btn btn-outline">Log Out</a>
      </div>
    </div>

    <?php if ($success_msg !== ""): ?>
      <p class="alert-success" role="status"><?php echo htmlspecialchars($success_msg, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if ($error_msg !== ""): ?>
      <p class="alert-error" role="alert"><?php echo htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if ($query_error !== ""): ?>
      <p class="alert-error" role="alert"><?php echo htmlspecialchars($query_error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <!-- NEX-301 & NEX-303: Search, Filter & Sort Controls -->
    <section class="card" aria-labelledby="filter-heading">
      <h2 id="filter-heading">Search, Filter &amp; Sort Applications</h2>

      <div class="manage-grid">
        <!-- Query 2: Filter by Job Reference -->
        <form method="get" action="manage.php" class="manage-panel">
          <h3>Filter by Job Reference</h3>
          <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_col, ENT_QUOTES, 'UTF-8'); ?>">
          <div class="form-group">
            <label for="filter_job_ref">Job Reference (e.g. ED101, UX204)</label>
            <input
              type="text"
              id="filter_job_ref"
              name="job_ref"
              maxlength="5"
              placeholder="e.g. ED101"
              value="<?php echo htmlspecialchars($filter_job_ref, ENT_QUOTES, 'UTF-8'); ?>"
            >
          </div>
          <button type="submit" class="btn">Filter by Job Ref</button>
        </form>

        <!-- Query 3: Filter by Applicant Name -->
        <form method="get" action="manage.php" class="manage-panel">
          <h3>Filter by Applicant Name</h3>
          <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_col, ENT_QUOTES, 'UTF-8'); ?>">
          <div class="form-row">
            <div class="form-group">
              <label for="filter_first_name">First Name</label>
              <input
                type="text"
                id="filter_first_name"
                name="first_name"
                maxlength="20"
                placeholder="e.g. Alexander"
                value="<?php echo htmlspecialchars($filter_first_name, ENT_QUOTES, 'UTF-8'); ?>"
              >
            </div>
            <div class="form-group">
              <label for="filter_last_name">Last Name</label>
              <input
                type="text"
                id="filter_last_name"
                name="last_name"
                maxlength="20"
                placeholder="e.g. Mercer"
                value="<?php echo htmlspecialchars($filter_last_name, ENT_QUOTES, 'UTF-8'); ?>"
              >
            </div>
          </div>
          <button type="submit" class="btn">Search Applicant</button>
        </form>

        <!-- Query 6: Sort Dropdown -->
        <form method="get" action="manage.php" class="manage-panel">
          <h3>Sort Applications</h3>
          <?php if ($filter_job_ref !== ""): ?>
            <input type="hidden" name="job_ref" value="<?php echo htmlspecialchars($filter_job_ref, ENT_QUOTES, 'UTF-8'); ?>">
          <?php endif; ?>
          <?php if ($filter_first_name !== ""): ?>
            <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($filter_first_name, ENT_QUOTES, 'UTF-8'); ?>">
          <?php endif; ?>
          <?php if ($filter_last_name !== ""): ?>
            <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($filter_last_name, ENT_QUOTES, 'UTF-8'); ?>">
          <?php endif; ?>
          <div class="form-group">
            <label for="sort">Sort Column (Ascending)</label>
            <select id="sort" name="sort">
              <option value="EOInumber" <?php echo ($sort_col === 'EOInumber') ? 'selected' : ''; ?>>EOI Number (ID)</option>
              <option value="job_ref" <?php echo ($sort_col === 'job_ref') ? 'selected' : ''; ?>>Job Reference</option>
              <option value="first_name" <?php echo ($sort_col === 'first_name') ? 'selected' : ''; ?>>First Name</option>
              <option value="last_name" <?php echo ($sort_col === 'last_name') ? 'selected' : ''; ?>>Last Name</option>
              <option value="status" <?php echo ($sort_col === 'status') ? 'selected' : ''; ?>>Status</option>
              <option value="eoi_date" <?php echo ($sort_col === 'eoi_date') ? 'selected' : ''; ?>>Submission Date</option>
            </select>
          </div>
          <button type="submit" class="btn">Apply Sort</button>
        </form>
      </div>
    </section>

    <!-- NEX-302 (Query 4): Delete all EOIs by Job Reference -->
    <section class="card" aria-labelledby="delete-heading">
      <h2 id="delete-heading">Delete Applications by Job Reference</h2>
      <p>Remove all obsolete EOI records matching a specific Job Reference number.</p>
      <form method="post" action="manage.php" class="form-row">
        <input type="hidden" name="action" value="delete_by_job_ref">
        <div class="form-group">
          <label for="delete_job_ref">Job Reference to Delete *</label>
          <input
            type="text"
            id="delete_job_ref"
            name="delete_job_ref"
            maxlength="5"
            placeholder="e.g. ED101"
            required
          >
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-danger">Delete Matching EOIs</button>
        </div>
      </form>
    </section>

    <!-- NEX-301, NEX-302 & NEX-303: EOI Table with Whitelist Column Sort Links -->
    <section class="card" aria-labelledby="results-heading">
      <h2 id="results-heading">Candidate Expressions of Interest (EOIs)</h2>
      <p class="manage-summary">
        Showing <strong><?php echo count($eois); ?></strong> application(s) &bull;
        Sorted by <strong><?php echo htmlspecialchars($sort_col, ENT_QUOTES, 'UTF-8'); ?></strong> (ASC)
        <?php if ($filter_job_ref !== "" || $filter_first_name !== "" || $filter_last_name !== ""): ?>
          &mdash; Active filters:
          <?php if ($filter_job_ref !== ""): ?>
            <span class="badge">Job Ref: <?php echo htmlspecialchars($filter_job_ref, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
          <?php if ($filter_first_name !== ""): ?>
            <span class="badge">First Name: <?php echo htmlspecialchars($filter_first_name, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
          <?php if ($filter_last_name !== ""): ?>
            <span class="badge">Last Name: <?php echo htmlspecialchars($filter_last_name, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        <?php endif; ?>
      </p>

      <?php if (empty($eois)): ?>
        <p class="empty-state">No EOI records matched your current criteria. Try clearing the filters or click <strong>Show All EOIs</strong>.</p>
      <?php else: ?>
        <div class="table-wrap">
          <table>
            <caption>Table: Submitted Candidate Expressions of Interest (Click highlighted headers to sort)</caption>
            <thead>
              <tr>
                <th scope="col" <?php echo ($sort_col === 'EOInumber') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'EOInumber') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('EOInumber', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    EOI #<?php echo ($sort_col === 'EOInumber') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
                <th scope="col" <?php echo ($sort_col === 'job_ref') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'job_ref') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('job_ref', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    Job Ref<?php echo ($sort_col === 'job_ref') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
                <th scope="col" <?php echo ($sort_col === 'first_name') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'first_name') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('first_name', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    First Name<?php echo ($sort_col === 'first_name') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
                <th scope="col" <?php echo ($sort_col === 'last_name') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'last_name') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('last_name', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    Last Name<?php echo ($sort_col === 'last_name') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">State</th>
                <th scope="col">Skills</th>
                <th scope="col" <?php echo ($sort_col === 'status') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'status') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('status', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    Status<?php echo ($sort_col === 'status') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
                <th scope="col">Update Status</th>
                <th scope="col" <?php echo ($sort_col === 'eoi_date') ? 'aria-sort="ascending"' : ''; ?>>
                  <a class="sort-link<?php echo ($sort_col === 'eoi_date') ? ' active-sort' : ''; ?>" href="<?php echo htmlspecialchars(build_sort_url('eoi_date', $filter_job_ref, $filter_first_name, $filter_last_name), ENT_QUOTES, 'UTF-8'); ?>">
                    Submitted<?php echo ($sort_col === 'eoi_date') ? ' &#9650;' : ''; ?>
                  </a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($eois as $row): ?>
                <?php
                  $eoi_id       = (int) $row['EOInumber'];
                  $status_val   = $row['status'] ?? 'New';
                  $status_class = 'status-new';
                  if ($status_val === 'Current') {
                      $status_class = 'status-current';
                  } elseif ($status_val === 'Final') {
                      $status_class = 'status-final';
                  }
                ?>
                <tr>
                  <td><?php echo $eoi_id; ?></td>
                  <td><strong><?php echo htmlspecialchars($row['job_ref'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                  <td><?php echo htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['skills'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>
                    <span class="status-badge <?php echo $status_class; ?>">
                      <?php echo htmlspecialchars($status_val, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                  </td>
                  <td>
                    <!-- NEX-302 (Query 5): Update status dropdown -->
                    <form method="post" action="manage.php" class="status-form">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="eoi_number" value="<?php echo $eoi_id; ?>">
                      <label for="status_<?php echo $eoi_id; ?>" class="sr-only">Status for EOI <?php echo $eoi_id; ?></label>
                      <select id="status_<?php echo $eoi_id; ?>" name="status">
                        <option value="New" <?php echo ($status_val === 'New') ? 'selected' : ''; ?>>New</option>
                        <option value="Current" <?php echo ($status_val === 'Current') ? 'selected' : ''; ?>>Current</option>
                        <option value="Final" <?php echo ($status_val === 'Final') ? 'selected' : ''; ?>>Final</option>
                      </select>
                      <button type="submit" class="btn btn-sm">Save</button>
                    </form>
                  </td>
                  <td><?php echo htmlspecialchars($row['eoi_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
  </main>

<?php include("modules/footer.inc"); ?>

</body>

</html>
