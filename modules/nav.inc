<?php require_once(__DIR__ . '/active_page.inc'); ?>
    <nav>
      <a href="index.php" class="brand">
        <img src="images/NexEdu-Logo-cut.png" alt="NexEdu logo" width="38" height="38">
        NexEdu <span>Technologies</span>
      </a>

      <ul>
        <li><a href="index.php" <?php echo is_active('index.php', $current_page); ?>>Home</a></li>
        <li><a href="jobs.html" <?php echo is_active('jobs.html', $current_page); ?>>Careers</a></li>
        <li><a href="apply.php" <?php echo is_active('apply.php', $current_page); ?>>Apply Now</a></li>
        <li><a href="about.php" <?php echo is_active('about.php', $current_page); ?>>About Team</a></li>
      </ul>
    </nav>
  </header>