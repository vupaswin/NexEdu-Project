<?php 
include 'settings.php';
$sql = "SELECT * FROM about ORDER BY member_id ASC";
$result = mysqli_query($conn, $sql);
if (!$result) {
  die("Cannot load members");
}
include 'modules/header.inc'; 'modules/nav.inc';
?>

  <!-- 2. MAIN CONTENT AREA -->
  <main id="main-content" class="container">

    <!-- Page Header -->
    <div class="section-header">
      <span class="badge">Engineering &amp; Design Collective</span>
      <h1>Meet Our Team</h1>
      <p>
        We are Group 03, collaborating to engineer high-standard accessible web solutions and resilient digital learning experiences.
      </p>
    </div>

    <!-- SECTION 1: GROUP & COURSE INFORMATION (NESTED LIST REQUIREMENT) -->
    <section class="card">
      <h2>Group &amp; Tutorial Laboratory Information</h2>
      <p>Our core team operates under the following laboratory session schedule and campus location:</p>

      <!-- Mandatory Rubric Requirement: Nested List (<ul> inside <ul>) -->
      <ul class="nested-list">
        <li>
          Team &amp; Institutional Affiliation:
          <ul>
            <li><strong>Group Name:</strong> NextGen Tech (Group 03)</li>
            <li><strong>Institution:</strong> Swinburne Vietnam (Swinburne University of Technology)</li>
            <li><strong>Campus:</strong> Can Tho Campus (Ninh Kieu District, Can Tho City)</li>
          </ul>
        </li>
        <li>
          Tutorial Laboratory Schedule:
          <ul>
            <li><strong>Tutorial Session:</strong> Wednesday 08:00 AM - 12:00 PM ICT (UTC+7)</li>
            <li><strong>Laboratory Venue:</strong> Melbourne (Building Delta FPT)</li>
            <li><strong>Head Instructor:</strong> Mr. Wilson Doan</li>
          </ul>
        </li>
      </ul>
    </section>

    <!-- SECTION 2: GROUP PHOTO (<figure> & <figcaption> REQUIREMENT) -->
    <section>
      <h2>Development Team Portrait</h2>

      <!-- Mandatory Rubric Feature: <figure> with <figcaption> (Under 300KB) -->
      <figure>
        <img src="images/group studying.jpg" alt="Group photo of our four team members" width="840" height="440">
        <figcaption>
          Figure 1.1: NextGen Tech Project Team (Right to Left: Anh Quan Nguyen, Anh Vu Pham, Nguyen Cao Minh Tat, and Ho Kim Hoan Nguyen) collaborating at the Can Tho cafe. (High-res asset: 93.1 KB &lt; 300KB maximum threshold).
        </figcaption>
      </figure>
    </section>

    <!-- SECTION 3: TEAM MEMBER CONTRIBUTIONS & QUOTES (DEFINITION LIST) -->
    <section>
      <h2>Team Member Profiles &amp; Contributions</h2>
      <p>Individual specializations, key platform contributions, and perspectives from each team member.</p>

      <!-- Mandatory Rubric Requirement: Definition List (<dl>, <dt>, <dd>) -->
      <dl>

        <?php
        while ($member = mysqli_fetch_assoc($result)) {
          ?>

          <div class ="card">
            <dt>
              <span>
                <?php echo htmlspecialchars($member["full_name"]); ?>

              </span>
              <span class = "student_id">
                ID: <?php echo htmlspecialchars($member["student_id"]); ?>
              </span>
            </dt>
            <dd class = "role" >
              <?php echo htmlspecialchars($member["part1_role"]); ?>
            </dd>
            <dd>
              <strong>Part 1 Contributions:</strong>
              <?php echo htmlspecialchars($member["part1_work"]); ?>
            </dd>
            <dd class = "role">
              <?php echo htmlspecialchars($member["part2_role"]); ?>

            </dd>
            <dd>
              <strong>Part 2 Contributions:</strong>
              <?php echo htmlspecialchars($member["part2_work"]); ?>
            </dd>
            <dd>
              <blocquote>
                <?php echo htmlspecialchars($member["quote"]); ?>
              </blocquote>
            
            </dd>
          

            
          </div>
          <?php
          }
          ?>

      </dl>
    </section>

    <!-- SECTION 4: FUN FACTS TABLE (WITH CAPTION & HOVER HIGHLIGHT) -->
    <section>
      <h2>Team Perspectives &amp; Fun Facts</h2>
      <p>A glimpse into the diverse personalities, career goals, and cultural roots of our development team.</p>

      <table>
        <caption>Table 2.1: NexEdu Core Development Team - Passions, Fuel &amp; Origins</caption>
        <thead>
          <tr>
            <th scope="col">Team Member</th>
            <th scope="col">Dream Tech Role</th>
            <th scope="col">Go-to Coding Fuel / Snack</th>
            <th scope="col">Hometown &amp; Country</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Anh Vu Pham</th>
            <td>Master Layout &amp; System Architecture (index.html)</td>
            <td>Vietnamese Black Coffee (Cà Phê Đen)</td>
            <td>Dong Thap, Vietnam</td>
          </tr>
          <tr>
            <th scope="row">Ho Kim Hoan Nguyen</th>
            <td>Information Architecture &amp; Semantic Expert (jobs.html)</td>
            <td>Sting &amp; play Minecraft </td>
            <td>Can Tho, Vietnam</td>
          </tr>
          <tr>
            <th scope="row">Nguyen Cao Minh Tat</th>
            <td>Team Visuals &amp; Jira Scrum Master (about.html)</td>
            <td>Masala Chai &amp; Roasted Pistachios</td>
            <td>Can Tho, Vietnam</td>
          </tr>
          <tr>
            <th scope="row">Anh Quan Nguyen</th>
            <td>Form Logic &amp; Accessibility Lead (apply.html)</td>
            <td>Vietnamese Black Coffee (Cà Phê Đen)</td>
            <td>Dong Thap, Vietnam</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4">
              <strong>Collective Superpower:</strong> Cross-cultural empathy, relentless accessibility testing, and semantic precision.
            </td>
          </tr>
        </tfoot>
      </table>
    </section>

    <!-- Inline CSS Requirement: One intentional inline style on about.html -->
    <div class="card" style="border-bottom: 4px solid #0071e3;">
      <h4>Collaboration &amp; Code Quality Standards</h4>
      <p>
        Our team enforces strict code review benchmarks, semantic HTML5 structure, accessible keyboard navigation, and clean CSS styling across all platforms.
      </p>
    </div>

  </main>
<?php include ('modules/footer.inc'); ?>
  

</body>

</html>
