<?php include 'header.php'; ?>

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

        <!-- Member 1: Anh Vu Pham -->
        <div class="card">
          <dt>
            <span>Anh Vu Pham</span>
            <span class="student-id">ID: 106217835</span>
          </dt>
          <dd class="role">Master Layout &amp; System Architecture (index.html)</dd>
          <dd>
            <strong>Key Contributions:</strong> Sets up the GitHub repository and GitHub Pages deployment workflow, defines baseline styles.css rules (resets, typography, shared navigation, footer), develops index.html (hero background, search interface, accessible table with merged cells), handles final ZIP packaging and Canvas verification, and ensures the production branch builds properly on GitHub Pages.
          </dd>
          <dd>
            <blockquote>
              &ldquo; Trang web này được vận hành bằng cà phê và sự khủng hoảng hiện sinh..&rdquo;<br>
              <small>English Translation: "Powered by coffee and existential dread."</small>
            </blockquote>
          </dd>
        </div>

        <!-- Member 2: Ho Kim Hoan Nguyen -->
        <div class="card">
          <dt>
            <span>Ho Kim Hoan Nguyen</span>
            <span class="student-id">ID: 106638368</span>
          </dt>
          <dd class="role">Information Architecture &amp; Semantic Expert (jobs.html)</dd>
          <dd>
            <strong>Key Contributions:</strong> Codes jobs.html following a strict HTML5 semantic hierarchy, including multi-level headings, ordered and unordered lists, multiple section tags, and a right-aligned 25% width aside box, and runs W3C Validator syntax reviews across all HTML and CSS files to enforce zero syntax warnings or errors before integration.
          </dd>
          <dd>
            <blockquote>
              &ldquo;Những ngày giông bão tạo nên ngày tháng tươi đẹp hơn.&rdquo;<br>
              <small>English Translation: "Bad days build better days."</small>
            </blockquote>
          </dd>
        </div>

        <!-- Member 3: Nguyen Cao Minh Tat -->
        <div class="card">
          <dt>
            <span>Nguyen Cao Minh Tat</span>
            <span class="student-id">ID: 10691366</span>
          </dt>
          <dd class="role">Team Visuals &amp; Jira Scrum Master (about.html)</dd>
          <dd>
            <strong>Key Contributions:</strong> Configures the Jira board (Epics, User Stories, and Sprint backlog) and monitors delivery velocity, builds about.html with nested academic schedule lists, a figure team portrait strictly under 300KB, and an interactive hexadecimal-styled table with a hover state, and acts as the primary team liaison with the tutor.
          </dd>
          <dd>
            <blockquote>
              &ldquo;Đừng dùng chương đầu tiên của cuộc đời mình để so sánh với chương thứ mười của người khác.&rdquo;<br>
              <small>English Translation: "Do not compare the first chapter of your life to the tenth chapter of someone else."</small>
            </blockquote>
          </dd>
        </div>

        <!-- Member 4: Anh Quan Nguyen -->
        <div class="card">
          <dt>
            <span>Anh Quan Nguyen</span>
            <span class="student-id">ID: 106913272</span>
          </dt>
          <dd class="role">Form Logic &amp; Accessibility Lead (apply.html)</dd>
          <dd>
            <strong>Key Contributions:</strong> Builds apply.html using a pure Flexbox layout. Implements strict HTML5 validation rules, including regular expression patterns, required constraints, fieldsets/legends, and field types, checks WCAG AA colour contrast, explicit input-label associations, full keyboard navigation, and embeds the formal Indigenous Recognition statement.
          </dd>
          <dd>
            <blockquote>
              &ldquo;Bạn có thể khóc, có thể chửi, có thể làm bất cứ thứ gì nếu thất bại. Nhưng nếu từ bỏ, thì bạn không khác gì một kẻ thất bại.&rdquo;<br>
              <small>English Translation: "You can cry, can swear, can do whatever you want if you fail. But if you give up, you are a failure."</small>
            </blockquote>
          </dd>
        </div>

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
<?php include 'footer.php'; ?>
  

</body>

</html>
