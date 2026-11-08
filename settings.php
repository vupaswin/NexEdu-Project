<?php
// Database connection parameters
$host   = "localhost";       // Usually 'localhost' or an IP/domain
$user   = "root";       // MySQL username (e.g., 'root')
$pwd    = "";           // Password (leave empty '' for marker access per specs)
$sql_db = "nexedu-db";       // Database name (e.g., 'nexedu_db')

// Establish database connection guard
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Check if connection was successful
if (!$conn) {
    // User-friendly error message if the database is down
    die("<p><span style=\"color:red;\">Database connection failed.</span> Please try again later.</p>");
}
?>