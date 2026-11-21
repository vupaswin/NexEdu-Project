<?php include ("modules/header.inc");?>
<?php include ("modules/nav.inc");?>

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

    <!-- Layout Container with Floated Aside & Clearfix -->
    <div class="clearfix">

      <!-- NEX-90: Preserve 25% floated <aside> sidebar and clearfix container -->
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

      <!-- Job Listings (Dynamically loaded from MySQL - NEX-77) -->
      <section class="jobs-main">
        <h2>Current Open Positions</h2>

        <!-- NEX-110: Keyword Search Form (Placed inside .jobs-main to preserve layout) -->
        <form method="GET" action="jobs.php" class="search-form" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
          <label for="job-search" style="position: absolute; left: -9999px;">Search jobs by keyword</label>
          <input 
            type="text" 
            id="job-search" 
            name="keyword" 
            placeholder="Search by job title, department, or keyword..." 
            value="<?php echo isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''; ?>"
            style="flex: 1; min-width: 220px; padding: 0.6rem 0.8rem; border: 1px solid #ccc; border-radius: 6px;"
          >
          <button type="submit" class="btn">Search</button>
          <?php if (!empty(trim($_GET['keyword'] ?? ''))): ?>
            <a href="jobs.php" class="btn" style="background-color: #6c757d;">Clear</a>
          <?php endif; ?>
        </form>

        <?php
        // NEX-86: Include database configuration and establish MySQL connection
        require_once("settings.php");

        // NEX-89: Split semicolon or newline-delimited strings into clean <li> elements
        if (!function_exists('renderListItems')) {
            function renderListItems(string $text) {
                $raw_items = preg_split('/;|\r\n|\r|\n/', $text);
                $html = "";
                foreach ($raw_items as $item) {
                    $clean = preg_replace('/^(\d+\.\s*|-\s*)/', '', trim($item));
                    if ($clean !== '') {
                        $html .= "<li>" . htmlspecialchars($clean) . "</li>\n";
                    }
                }
                return $html;
            }
        }

        // NEX-86: Connect to MySQL database
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        if (!$conn) {
            echo "<article class='card'><p>Database connection failed. Please try again later.</p></article>";
        } else {
            mysqli_set_charset($conn, "utf8mb4");

            // NEX-110: Secure keyword search using MySQLi Prepared Statements
            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
            $stmt = null;

            if ($keyword !== '') {
                $searchParam = "%" . $keyword . "%";
                $query = "SELECT * FROM jobs 
                          WHERE job_ref LIKE ? 
                             OR job_title LIKE ? 
                             OR department LIKE ? 
                             OR location LIKE ? 
                             OR overview LIKE ? 
                          ORDER BY job_ref ASC";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            } else {
                // NEX-87: Default query when no search keyword is entered
                $query = "SELECT * FROM jobs ORDER BY job_ref ASC";
                $result = mysqli_query($conn, $query);
            }

            if ($result && mysqli_num_rows($result) > 0) {
                if ($keyword !== '') {
                    echo "<p>Showing <strong>" . mysqli_num_rows($result) . "</strong> result(s) for <em>\"" . htmlspecialchars($keyword) . "\"</em>:</p>";
                }

                // NEX-88: Iterate through query rows to render semantic <article class="card"> elements
                while ($job = mysqli_fetch_assoc($result)) {
                    $job_ref = htmlspecialchars($job['job_ref']);
                    $job_title = htmlspecialchars($job['job_title']);
                    $department = htmlspecialchars($job['department']);
                    $location = htmlspecialchars($job['location']);
                    $reports_to = htmlspecialchars($job['reports_to']);
                    $salary = htmlspecialchars($job['salary']);
                    $overview = htmlspecialchars($job['overview']);
                    $role_id = "role-" . strtolower($job_ref) . "-title";
        ?>
                    <!-- NEX-88: Semantic job card rendered dynamically -->
                    <article class="card">
                      <header>
                        <span class="badge">REF: <?php echo $job_ref; ?></span>
                        <span class="badge"><?php echo $department; ?></span>
                        <span class="badge"><?php echo $location; ?></span>

                        <h3 id="<?php echo $role_id; ?>"><?php echo $job_title; ?></h3>
                        <p>Reports to: <strong><?php echo $reports_to; ?></strong></p>
                        <p class="salary">Salary: <?php echo $salary; ?></p>
                      </header>

                      <section>
                        <h4>Role Overview</h4>
                        <p><?php echo nl2br($overview); ?></p>
                      </section>

                      <!-- NEX-89: Ordered List (<ol>) for Key Responsibilities -->
                      <section>
                        <h4>Key Responsibilities</h4>
                        <ol>
                          <?php echo renderListItems($job['responsibilities']); ?>
                        </ol>
                      </section>

                      <!-- NEX-89: Unordered List (<ul>) for Requirements -->
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
        <?php
                }
            } else {
                if ($keyword !== '') {
                    echo "<article class='card'><p>No open positions matched your search for <strong>\"" . htmlspecialchars($keyword) . "\"</strong>.</p></article>";
                } else {
                    echo "<article class='card'><p>No open positions available at the moment.</p></article>";
                }
            }

            // NEX-110 & NEX-86: Close statement, free result set, and close database connection
            if ($stmt) {
                mysqli_stmt_close($stmt);
            }
            if ($result) {
                mysqli_free_result($result);
            }
            mysqli_close($conn);
        }
        ?>

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