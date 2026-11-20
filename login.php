<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: manage.php");
    exit();
}

require_once("settings.php");

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if ($username === "" || $password === "") {
        $error = "Invalid credentials";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT user_id, password, role FROM users WHERE username = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                $_SESSION['admin_role'] = $user['role'];
                mysqli_close($conn);
                header("Location: manage.php");
                exit();
            } else {
                $error = "Invalid credentials";
            }
        } else {
            $error = "Invalid credentials";
        }
    }
}

mysqli_close($conn);
?>
<?php include("modules/header.inc"); ?>
<?php include("modules/nav.inc"); ?>

  <main id="main-content" class="container">
    <div class="section-header">
      <h1>Manager Login</h1>
      <p>Sign in with authorized HR manager credentials to access candidate applications.</p>
    </div>

    <section class="card login-card" aria-labelledby="login-heading">
      <h2 id="login-heading">Sign In</h2>

      <?php if ($error !== ""): ?>
        <p class="alert-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <form method="post" action="login.php">
        <div class="form-group">
          <label for="username">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"
            autocomplete="username"
            required
          >
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            autocomplete="current-password"
            required
          >
        </div>

        <div>
          <button type="submit" class="btn">Log In</button>
        </div>
      </form>
    </section>
  </main>

<?php include("modules/footer.inc"); ?>

</body>

</html>
