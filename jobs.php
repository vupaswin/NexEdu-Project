<?php include ("modules/header.inc");?>
<?php include ("modules/nav.inc");?>

<?php
// NEX-113: Read and sanitize search/filter parameters from index.php or jobs.php
$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
} elseif (isset($_GET['search'])) {
    $keyword = trim($_GET['search']);
}

$category = isset($_GET['category']) ? trim($_GET['category']) : "";
$location = isset($_GET['location']) ? trim($_GET['location']) : "";

// Strict whitelist maps matching the <select> options in index.php
$category_map = [
    'engineering' => 'Engineering',
    'design'      => 'Design',
    'data'        => 'Data'
];

$location_map = [
    'cantho' => 'Can Tho',
    'hcmc'   => 'Ho Chi Minh',
    'remote' => 'Remote'
];

if (!array_key_exists($category, $category_map)) {
    $category = "";
}
if (!array_key_exists($location, $location_map)) {
    $location = "";
}
?>

  <!--MAIN CONTENT AREA (WITH FLOATED ASIDE ELEMENT)-->
  <main id="main-content" class="container">

    <!-- Careers Header Banner -->
    <div class="section-header">
    <section>
      <h1>Careers at NexEdu Technologies</h1>
      <p>
        Join our team of developers and designers building accessible educational platforms. We offer competitive salaries, flexible hybrid work, and continuous learning opportunities.
      </p>
    </section>
    </div>

    <!-- NEX-113: Functional Job Search & Filter Bar -->
    <section class="search-section" aria-label="Search open positions">
      <form method="get" action="jobs.php" class="card">
        <div class="form-row">
          <div class="form-group">
            <label for="keyword">Search Positions</label>
            <input
              type="search"
              id="keyword"
              name="keyword"
              placeholder="e.g. Platform Engineer, UX Designer, ED101..."
              value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
            >
          </div>
          <div class="form-group">
            <label for="category">Discipline</label>
            <select id="category" name="category">
              <option value="">All Disciplines</option>
              <option value="engineering" <?php echo ($category === 'engineering') ? 'selected' : ''; ?>>Platform &amp; Infrastructure</option>
              <option value="design" <?php echo ($category === 'design') ? 'selected' : ''; ?>>Accessibility &amp; UX Design</option>
              <option value="data" <?php echo ($category === 'data') ? 'selected' : ''; ?>>Data &amp; Systems Architecture</option>
            </select>
          </div>
          <div class="form-group">
            <label for="location">Location Model</label>
            <select id="location" name="location">
              <option value="">All Locations</option>
              <option value="cantho" <?php echo ($location === 'cantho') ? 'selected' : ''; ?>>Can Tho (HQ Campus)</option>
              <option value="hcmc" <?php echo ($location === 'hcmc') ? 'selected' : ''; ?>>Ho Chi Minh City (Hybrid)</option>
              <option value="remote" <?php echo ($location === 'remote') ? 'selected' : ''; ?>>Remote (Vietnam Wide)</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn">Search Jobs</button>
            <a href="jobs.php" class="btn btn-outline">Show All</a>
          </div>
        </div>
      </form>
    </section>

    <!-- Layout Container with Floated Aside & Clearfix -->
    <div class="clearfix">

      <!-- RUBRIC REQUIREMENT: <aside> floated right, 25% width, margin, padding, border -->
      <aside>
        <h3 id="sidebar-title">Hiring Process &amp; Info</h3>

        <h4>Recruitment Process</h4>
        <ul>
          <li><strong>Stage 1:</strong> Initial Interview (30 mins)</li>
          <li><strong>Stage 2:</strong> Technical &amp; System Discussion</li>
          <li><strong>Stage 3:</strong> Practical Coding Task</li>
          <li><strong>Stage 4:</strong> Final Interview with Manager</li>
          <li><strong>Stage 5:</strong> Job Offer &amp; Onboarding</li>
        </ul>

        <h4>Perks &amp; Benefits</h4>
        <ul>
          <li>Flexible work options (Can Tho campus or remote)</li>
          <li>Annual learning budget for courses and books</li>
          <li>Equipment budget for your home office setup</li>
          <li>Health insurance and paid leave</li>
          <li>Team events and annual company retreat</li>
        </ul>

        <h4>Contact</h4>
        <p>Have any questions about open positions or working with us?</p>
        <p>
          <strong>Email:</strong> <a href="mailto:careers@nexedu.edu.vn">careers@nexedu.edu.vn</a><br>
          <strong>Working Hours:</strong> Mon – Fri, 8:30 AM – 5:30 PM ICT (UTC+7)
        </p>
      </aside>
      <!-- NEX-90: Preserve 25% floated <aside> sidebar and clearfix container -->

      <!-- Job Listings (Dynamically loaded & filtered from MySQL) -->
      <section class="jobs-main">
        <h2>Current Open Positions</h2>

        <?php
        // NEX-86: Include database configuration (establishes $conn)
        require_once("settings.php");

        // NEX-89: Split semicolon-delimited strings into <li> elements for <ol> and <ul>
        if (!function_exists('renderListItems')) {
            function renderListItems(string $text) {
                $items = array_filter(array_map('trim', explode(";", $text)));
                $html = "";
                foreach ($items as $item) {
                    $html .= "<li>" . htmlspecialchars($item, ENT_QUOTES, 'UTF-8') . "</li>\n";
                }
                return $html;
            }
        }

        mysqli_set_charset($conn, "utf8mb4");

        // NEX-113: Build parameterized SQL query from search/filter inputs
        $where_clauses = [];
        $param_types   = "";
        $param_values  = [];

        if ($keyword !== "") {
            $like_kw         = "%" . $keyword . "%";
            $where_clauses[] = "(job_title LIKE ? OR department LIKE ? OR job_ref LIKE ? OR overview LIKE ?)";
            $param_types    .= "ssss";
            $param_values[]  = $like_kw;
            $param_values[]  = $like_kw;
            $param_values[]  = $like_kw;
            $param_values[]  = $like_kw;
        }

        if ($category !== "") {
            $where_clauses[] = "department LIKE ?";
            $param_types    .= "s";
            $param_values[]  = "%" . $category_map[$category] . "%";
        }

        if ($location !== "") {
            $where_clauses[] = "location LIKE ?";
            $param_types    .= "s";
            $param_values[]  = "%" . $location_map[$location] . "%";
        }

        $sql = "SELECT * FROM jobs";
        if (!empty($where_clauses)) {
            $sql .= " WHERE " . implode(" AND ", $where_clauses);
        }
        $sql .= " ORDER BY job_ref ASC";

        $jobs = [];
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            if ($param_types !== "") {
                mysqli_stmt_bind_param($stmt, $param_types, ...$param_values);
            }
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $jobs[] = $row;
                }
                mysqli_free_result($result);
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
        ?>

        <p class="manage-summary">
          Showing <strong><?php echo count($jobs); ?></strong> open position(s)
          <?php if ($keyword !== "" || $category !== "" || $location !== ""): ?>
            &mdash; Active filters:
            <?php if ($keyword !== ""): ?>
              <span class="badge">Keyword: <?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
            <?php if ($category !== ""): ?>
              <span class="badge">Discipline: <?php echo htmlspecialchars($category_map[$category], ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
            <?php if ($location !== ""): ?>
              <span class="badge">Location: <?php echo htmlspecialchars($location_map[$location], ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
          <?php endif; ?>
        </p>

        <?php if (!empty($jobs)): ?>
          <?php foreach ($jobs as $job): ?>
            <?php
              $job_ref    = htmlspecialchars($job['job_ref'], ENT_QUOTES, 'UTF-8');
              $job_title  = htmlspecialchars($job['job_title'], ENT_QUOTES, 'UTF-8');
              $department = htmlspecialchars($job['department'], ENT_QUOTES, 'UTF-8');
              $job_loc    = htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8');
              $reports_to = htmlspecialchars($job['reports_to'], ENT_QUOTES, 'UTF-8');
              $salary     = htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8');
              $overview   = htmlspecialchars($job['overview'], ENT_QUOTES, 'UTF-8');
              $role_id    = "role-" . strtolower($job_ref) . "-title";
            ?>
            <!-- NEX-88: Semantic job card rendered dynamically -->
            <article class="card">
              <header>
                <span class="badge">REF: <?php echo $job_ref; ?></span>
                <span class="badge"><?php echo $department; ?></span>
                <span class="badge"><?php echo $job_loc; ?></span>

                <h3 id="<?php echo $role_id; ?>"><?php echo $job_title; ?></h3>
                <p>Reports to: <strong><?php echo $reports_to; ?></strong></p>
                <p class="salary">Salary: <?php echo $salary; ?></p>
              </header>

              <section>
                <h4>Role Overview</h4>
                <p><?php echo nl2br($overview); ?></p>
              </section>

              <!-- Ordered List (<ol>) for Key Responsibilities -->
              <section>
                <h4>Key Responsibilities</h4>
                <ol>
                  <?php echo renderListItems($job['responsibilities']); ?>
                </ol>
              </section>

              <!-- Unordered List (<ul>) for Requirements -->
              <section>
                <h4>Candidate Requirements &amp; Qualifications</h4>
                <h5>Essential Requirements:</h5>
                <ul>
                  <?php echo renderListItems($job['essential_reqs']); ?>
                </ul>

                <h5>Highly Desirable &amp; Preferable Qualifications:</h5>
                <ul>
                  <?php echo renderListItems($job['preferable_reqs']); ?>
                </ul>
              </section>

              <a href="apply.php?job=<?php echo urlencode($job['job_ref']); ?>" class="btn">Apply for Position <?php echo $job_ref; ?></a>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <article class="card">
            <p class="empty-state">
              No open positions matched your search criteria.
              <a href="jobs.php">View all open positions</a>.
            </p>
          </article>
        <?php endif; ?>

      </section>
    </div>

    <!-- Inline CSS: One intentional inline style -->
    <div class="card" style="border-top: 4px solid #0071e3;">
      <h4>Equal Opportunity Statement</h4>
      <p>
        NexEdu Technologies welcomes applications from all qualified candidates regardless of background. If you need any assistance during the interview process, feel free to reach out to us at <a href="mailto:careers@nexedu.edu.vn">careers@nexedu.edu.vn</a>.
      </p>
    </div>

  </main>

<?php include ("modules/footer.inc");?>

</body>

</html>
