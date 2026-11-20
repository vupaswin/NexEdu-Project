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

      <!-- Job Listings (Dynamically loaded from MySQL) -->
      <section class="jobs-main">
        <h2>Current Open Positions</h2>

        <?php
        require_once("settings.php");

        // Hàm hỗ trợ tách chuỗi theo dòng thành các thẻ <li> (giữ nguyên chuẩn HTML5/WAVE accessibility)
        if (!function_exists('renderListItems')) {
            function renderListItems(string $text) {
                $lines = array_filter(array_map('trim', explode("\n", $text)));
                $html = "";
                foreach ($lines as $line) {
                    $cleanLine = preg_replace('/^(\d+[\.\)]\s*|[\-\*\•]\s*)/', '', $line);
                    $html .= "<li>" . htmlspecialchars($cleanLine) . "</li>\n";
                }
                return $html;
            }
        }

        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        if (!$conn) {
            echo "<article class='card'><p>Database connection failed. Please try again later.</p></article>";
        } else {
            mysqli_set_charset($conn, "utf8mb4");

            // Truy vấn theo đúng yêu cầu NEX-87
            $query = "SELECT * FROM jobs ORDER BY job_ref ASC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $job_ref = htmlspecialchars($row['job_ref']);
                    $job_title = htmlspecialchars($row['job_title']);
                    $department = htmlspecialchars($row['department']);
                    $location = htmlspecialchars($row['location']);
                    $reports_to = htmlspecialchars($row['reports_to']);
                    $salary = htmlspecialchars($row['salary']);
                    $overview = htmlspecialchars($row['overview']);
                    $role_id = "role-" . strtolower($job_ref) . "-title";
        ?>
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

                      <!-- Ordered List (<ol>) for Key Responsibilities -->
                      <section>
                        <h4>Key Responsibilities</h4>
                        <ol>
                          <?php echo renderListItems($row['responsibilities']); ?>
                        </ol>
                      </section>

                      <!-- Unordered List (<ul>) for Requirements -->
                      <section>
                        <h4>Candidate Requirements &amp; Qualifications</h4>
                        <h5>Essential Requirements:</h5>
                        <ul>
                          <?php echo renderListItems($row['essential_reqs']); ?>
                        </ul>

                        <h5>Highly Desirable &amp; Preferable Qualifications:</h5>
                        <ul>
                          <?php echo renderListItems($row['preferable_reqs']); ?>
                        </ul>
                      </section>

                      <a href="apply.php?job=<?php echo urlencode($row['job_ref']); ?>" class="btn">Apply for Position <?php echo $job_ref; ?></a>
                    </article>
        <?php
                }
            } else {
                echo "<article class='card'><p>No open positions available at the moment.</p></article>";
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