<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php include("modules/header.inc"); ?>
<?php include("modules/nav.inc"); ?>

  <main id="main-content" class="container">
    <div class="section-header">
      <span class="badge">Authenticated HR Portal</span>
      <h1>HR Management Dashboard</h1>
      <p>
        Signed in as <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?></strong>.
      </p>
    </div>

    <section class="card" aria-labelledby="portal-status-heading">
      <h2 id="portal-status-heading">Session Active</h2>
      <p>
        Access to this page is protected by the NEX-205 session verification guard.
        Candidate EOI query, filtering, status update, deletion, and whitelist sorting features (NEX-301, NEX-302, NEX-303) mount in this protected dashboard.
      </p>
      <div>
        <a href="logout.php" class="btn btn-outline">Log Out</a>
      </div>
    </section>
  </main>

<?php include("modules/footer.inc"); ?>

</body>

</html>
