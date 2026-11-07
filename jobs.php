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

      <!-- Job Listings (Multiple <section> elements) -->
      <section class="jobs-main">
        <h2>Current Open Positions</h2>

        <!-- POSITION 1: SENIOR LEARNING PLATFORM ENGINEER (REF: ED101) -->
        <article class="card">
          <header>
            <span class="badge">REF: ED101</span>
            <span class="badge">Engineering &bull; Cloud Platform</span>
            <span class="badge">Can Tho Campus / Hybrid</span>
            <h3 id="role-ed101-title">Senior Learning Platform Engineer</h3>
            <p>Reports directly to: <strong>Principal Cloud Architect</strong></p>
            <p class="salary">Salary: $145,000 – $168,000 AUD (~2.3B – 2.7B VND/yr) + 11.5% Superannuation / Benefits</p>
          </header>

          <section>
            <h4>Role Overview</h4>
            <p>
              As a Senior Learning Platform Engineer, you will build and maintain core services for our learning system, ensuring high performance and reliability for students and teachers.
            </p>
          </section>

          <!-- Ordered List (<ol>) for Key Responsibilities -->
          <section>
            <h4>Key Responsibilities</h4>
            <ol>
              <li>Develop backend web services using Golang, TypeScript, and Docker.</li>
              <li>Optimize database performance using PostgreSQL and Redis.</li>
              <li>Work with Frontend Developers to create REST and GraphQL APIs.</li>
              <li>Set up automated testing and continuous deployment pipelines.</li>
              <li>Monitor system health and troubleshoot operational issues.</li>
            </ol>
          </section>

          <!-- Unordered List (<ul>) for Requirements -->
          <section>
            <h4>Candidate Requirements &amp; Qualifications</h4>
            <h5>Essential Requirements:</h5>
            <ul>
              <li>Bachelor's degree in Computer Science, Software Engineering, or equivalent industry experience (5+ years).</li>
              <li>Experience with backend development in Go, Node.js, or Java.</li>
              <li>Good knowledge of SQL databases and REST APIs.</li>
              <li>Familiarity with Git and basic Linux operational commands.</li>
            </ul>

            <h5>Highly Desirable &amp; Preferable Qualifications:</h5>
            <ul>
              <li>Previous experience working with EdTech applications or LMS.</li>
              <li>Basic knowledge of cloud platforms like AWS or Google Cloud.</li>
              <li>Familiarity with ISO 27001 compliance standards, GDPR, and Vietnamese personal data protection regulations (Decree 13/2023/ND-CP).</li>
            </ul>
          </section>

          <a href="apply.html?job=ED101" class="btn">Apply for Position ED101</a>
        </article>

        <!-- POSITION 2: ACCESSIBILITY UX DESIGNER (REF: UX204) -->
        <article class="card">
          <header>
            <span class="badge">REF: UX204</span>
            <span class="badge">Design &amp; Product</span>
            <span class="badge">Can Tho / Ho Chi Minh City</span>
            <h3 id="role-ux204-title">Accessibility UX Designer</h3>
            <p>Reports to: <strong>Design Team Lead</strong></p>
            <p class="salary">Salary: $120,000 – $138,000 AUD (~1.9B – 2.2B VND/yr) + 11.5% Superannuation / Benefits</p>
          </header>

          <section>
            <h4>Role Overview</h4>
            <p>
              We are looking for a UX Designer to help us build user-friendly and accessible interfaces for everyone, including users with disabilities.
            </p>
          </section>

          <!-- Ordered List (<ol>) for Key Responsibilities -->
          <section>
            <h4>Key Responsibilities</h4>
            <ol>
              <li>Conduct user testing and interviews with various user groups.</li>
              <li>Design wireframes, prototypes, and UI components in Figma.</li>
              <li>Ensure web designs follow web accessibility guidelines (WCAG).</li>
              <li>Collaborate closely with developers during implementation.</li>
              <li>Share UX and accessibility best practices with the team.</li>
            </ol>
          </section>

          <!-- Unordered List (<ul>) for Requirements -->
          <section>
            <h4>Candidate Requirements &amp; Qualifications</h4>
            <h5>Essential Requirements:</h5>
            <ul>
              <li>3+ years of experience in UI/UX design for web applications.</li>
              <li>Proficiency in Figma and wireframing tools.</li>
              <li>Basic understanding of web accessibility standards (WCAG).</li>
              <li>Strong communication and teamwork skills.</li>
            </ul>

            <h5>Highly Desirable &amp; Preferable Qualifications:</h5>
            <ul>
              <li>IAAP Certification (such as CPACC or WAS credential).</li>
              <li>Fundamental working knowledge of semantic HTML5, modern CSS3 layout techniques, and browser rendering engines.</li>
              <li>Experience conducting cognitive load and readability assessments for educational materials.</li>
            </ul>
          </section>

          <a href="apply.html?job=UX204" class="btn">Apply for Position UX204</a>
        </article>

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
