<?php
session_start();

// NEX-301 (Sub-task 1): Session guard — redirect unauthenticated visitors to login.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");
mysqli_set_charset($conn, "utf8mb4");

// Read and trim GET filter inputs
$filter_job_ref    = isset($_GET['job_ref']) ? strtoupper(trim($_GET['job_ref'])) : "";
$filter_first_name = isset($_GET['first_name']) ? trim($_GET['first_name']) : "";
$filter_last_name  = isset($_GET['last_name']) ? trim($_GET['last_name']) : "";

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

// NEX-301 (Query 1): Base query to list all EOIs
$sql = "SELECT EOInumber, job_ref, first_name, last_name, dob, gender, address, suburb, state, postcode, email, phone, skills, other_skills, status, eoi_date FROM eoi";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY EOInumber ASC";

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
        Review, search, and manage candidate Expressions of Interest (EOIs).
      </p>
      <div class="manage-toolbar">
        <a href="manage.php" class="btn btn-outline">Show All EOIs</a>
        <a href="logout.php" class="btn btn-outline">Log Out</a>
      </div>
    </div>

    <?php if ($query_error !== ""): ?>
      <p class="alert-error" role="alert"><?php echo htmlspecialchars($query_error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <!-- NEX-301: Query 2 (Job Reference Filter) & Query 3 (Applicant Name Filter) -->
    <section class="card" aria-labelledby="filter-heading">
      <h2 id="filter-heading">Search &amp; Filter Applications</h2>

      <div class="manage-grid">
        <!-- Query 2: Filter by Job Reference -->
        <form method="get" action="manage.php" class="manage-panel">
          <h3>Filter by Job Reference</h3>
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
      </div>
    </section>

    <!-- NEX-301: Query 1 (List All / Filtered EOIs in Tabular View) -->
    <section class="card" aria-labelledby="results-heading">
      <h2 id="results-heading">Candidate Expressions of Interest (EOIs)</h2>
      <p class="manage-summary">
        Showing <strong><?php echo count($eois); ?></strong> application(s)
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
            <caption>Table: Submitted Candidate Expressions of Interest</caption>
            <thead>
              <tr>
                <th scope="col">EOI #</th>
                <th scope="col">Job Ref</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">State</th>
                <th scope="col">Skills</th>
                <th scope="col">Status</th>
                <th scope="col">Submitted</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($eois as $row): ?>
                <?php
                  $status_val = $row['status'] ?? 'New';
                  $status_class = 'status-new';
                  if ($status_val === 'Current') {
                      $status_class = 'status-current';
                  } elseif ($status_val === 'Final') {
                      $status_class = 'status-final';
                  }
                ?>
                <tr>
                  <td><?php echo (int) $row['EOInumber']; ?></td>
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
