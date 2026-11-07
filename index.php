<?php include ("modules/header.inc");?>
<?php include ("modules/nav.inc");?>

  <!-- 2. MAIN CONTENT AREA -->
  <main id="main-content">

    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <span class="badge">2026 Engineering &amp; Design Recruitment Drive</span>
        <h1 id="hero-heading">Engineering the Future of Human Learning</h1>
        <p>
          Join our collaborative engineering and experience design teams creating universally accessible,
          high-performance web applications.
        </p>
        <div>
          <a href="jobs.html" class="btn">Explore Open Positions</a>
          <a href="about.html" class="btn btn-outline">Meet Our Team</a>
        </div>

        <img src="images/hero-campus.jpg" alt="NexEdu campus building in Can Tho" width="1200" height="440">
      </div>
    </section>

    <!-- Search & Filter Box -->
    <section class="container">
      <form method="get" action="jobs.html" class="card">
        <div class="form-row">
          <div class="form-group">
            <label for="keyword">Search Positions</label>
            <input type="search" id="keyword" name="keyword" placeholder="e.g. Platform Engineer, UX Designer...">
          </div>
          <div class="form-group">
            <label for="category">Discipline</label>
            <select id="category" name="category">
              <option value="">All Disciplines</option>
              <option value="engineering">Platform &amp; Infrastructure</option>
              <option value="design">Accessibility &amp; UX Design</option>
              <option value="data">Data &amp; Systems Architecture</option>
            </select>
          </div>
          <div class="form-group">
            <label for="location">Location Model</label>
            <select id="location" name="location">
              <option value="">All Locations</option>
              <option value="cantho">Can Tho (HQ Campus)</option>
              <option value="hcmc">Ho Chi Minh City (Hybrid)</option>
              <option value="remote">Remote (Vietnam Wide)</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn">Search Jobs</button>
          </div>
        </div>
      </form>
    </section>

    <!-- Core Workplace Culture Values -->
    <section class="container">
      <div class="section-header">
        <span class="badge">Engineering Culture</span>
        <h2>How We Build and Collaborate</h2>
        <p>Our teams value rigorous software craft, universal accessibility, and open collaboration.</p>
      </div>

      <div class="grid-3">
        <article class="card">
          <span class="badge">Accessibility First</span>
          <h3>Universal Digital Access</h3>
          <p>
            We engineer our web applications strictly to WCAG 2.1 AA benchmarks, ensuring screen reader compatibility,
            proper keyboard navigation, and inclusive design from day one.
          </p>
        </article>

        <article class="card">
          <span class="badge">Reliability</span>
          <h3>Modern Cloud Infrastructure</h3>
          <p>
            Our distributed services are built for high availability and low latency, utilizing container
            orchestration, structured logging, and automated testing pipelines.
          </p>
        </article>

        <article class="card">
          <span class="badge">Continuous Growth</span>
          <h3>Dedicated Learning Support</h3>
          <p>
            Every team member receives annual professional development budgets, dedicated hackathon days, and
            structured mentorship opportunities.
          </p>
        </article>
      </div>
    </section>

    <!-- Department Overview Table (Colspan & Rowspan Requirement) -->
    <section class="container">
      <div class="section-header">
        <span class="badge">Department Directory</span>
        <h2>Open Headcount &amp; Technical Stacks</h2>
        <p>Overview of team divisions, active technical stacks, open positions, and work arrangements.</p>
      </div>

      <table>
        <caption>Table 1.1: NexEdu Technologies Departmental Allocation &amp; Technical Stacks</caption>
        <thead>
          <tr>
            <th scope="col">Division</th>
            <th scope="col">Department</th>
            <th scope="col">Core Technical Stack</th>
            <th scope="col">Open Roles</th>
            <th scope="col">Location Model</th>
          </tr>
        </thead>
        <tbody>
          <!-- Rowspan: Division 'Platform Engineering' spans 2 rows -->
          <tr>
            <th scope="row" rowspan="2">Platform Engineering</th>
            <td>Core Infrastructure &amp; SRE</td>
            <td>Kubernetes, Golang, Terraform, PostgreSQL</td>
            <td>3 Positions</td>
            <td>Can Tho / Hybrid</td>
          </tr>
          <tr>
            <td>Adaptive Learning Systems</td>
            <td>TypeScript, Python, GraphQL, Redis</td>
            <td>2 Positions</td>
            <td>Remote / Vietnam</td>
          </tr>

          <!-- Rowspan: Division 'Experience & Design' spans 2 rows -->
          <tr>
            <th scope="row" rowspan="2">Experience &amp; Design</th>
            <td>Accessibility (A11y) &amp; UI</td>
            <td>Semantic HTML5, Modern CSS, WCAG 2.1 AA, Figma</td>
            <td>2 Positions</td>
            <td>Can Tho (HQ)</td>
          </tr>
          <tr>
            <td>Pedagogical UX Research</td>
            <td>User Journey Mapping, Mixed Methods, Heuristics</td>
            <td>1 Position</td>
            <td>Can Tho &amp; HCMC / Hybrid</td>
          </tr>

          <!-- Colspan: Merged cross-departmental row -->
          <tr>
            <th scope="row">Data Governance</th>
            <td>Academic Privacy &amp; Compliance</td>
            <td colspan="2">Encrypted Telemetry, Auditing Systems (2 Shared Fellowships)</td>
            <td>National Remote</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"><strong>Total Active Recruitment Requisitions Across All Disciplines:</strong></td>
            <td><strong>10 Headcounts</strong></td>
            <td><strong>Target Commencement: Q4 2026 – Q1 2027</strong></td>
          </tr>
        </tfoot>
      </table>

      <!-- Inline CSS Requirement: One intentional inline style on index.html -->
      <div class="card" style="border-left: 5px solid #0071e3;">
        <h3>Candidate Remuneration &amp; Parity Standards</h3>
        <p>
          NexEdu Technologies operates a transparent compensation framework. All positions listed on our portal are
          fully funded, benchmarked against top-tier tech compensation standards in Vietnam, and backed by
          comprehensive health coverage, social insurance, and professional development support.
        </p>
      </div>

      <!-- Acknowledgement of Country & Community -->
      <div class="card">
        <h3>Acknowledgement of Country &amp; Community</h3>
        <p>
          NexEdu Technologies acknowledges the Traditional Custodians of the lands upon which Swinburne University of
          Technology operates, particularly the Wurundjeri Woi-wurrung people of the Kulin Nation upon whose unceded
          ancestral lands the foundation of our academic curriculum stands. In extending our educational mission to
          Vietnam, we also respectfully pay tribute to the dynamic heritage, learning traditions, and community wisdom
          of the Mekong Delta region and Can Tho City where our Asia-Pacific development studios flourish.
        </p>
      </div>
    </section>

  </main>

  <!-- 3. SITE FOOTER (SHARED ACROSS ALL PAGES) -->
  <?php include ("modules/footer.inc");?>

</body>

</html>
