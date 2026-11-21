<?php
session_start();
    function sanitizes(string $value): string
    {
        return htmlspecialchars(
            trim(stripslashes($value)),
            ENT_QUOTES,
            'UTF-8'
        );
    }

$errors=[];
$job_ref=sanitizes($_POST['job_ref'] ?? '');
if (!preg_match('/^[A-Z]{2}[0-9]{3}$/',$job_ref)){
    $errors[] = 'Job reference must be 2 uppercase letters followed by 3 digits.';
}

$first_name=sanitizes($_POST['first_name'] ?? '');
if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿĀ-ỹ\s]{1,20}$/u',$first_name)){
    $errors[]= 'The first name segment must only contain letters and 20 maximum.';
}

$last_name=sanitizes($_POST['last_name'] ?? '');
if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿĀ-ỹ\s]{1,20}$/u',$last_name)){
    $errors[]= 'The last name segment must only contain letters and 20 maximum.';
}

$address=sanitizes($_POST['address'] ?? '');

$suburb=sanitizes($_POST['suburb'] ?? '');

$postcode=sanitizes($_POST['postcode'] ?? '');
if (!preg_match('/^[0-9]{4}$/',$postcode)){
    $errors[]='Post code only contains 4 digits without any word.';
}

$other_skills=sanitizes($_POST['other_skills'] ?? '');

$dob=$_POST['dob'] ?? '';

$email=sanitizes($_POST['email'] ?? '');

$phone=sanitizes($_POST['phone'] ?? '');
if (!preg_match('/^[0-9]{8,12}$/',$phone)){
    $errors[]='Phone number only contains from 8 to 12 digits.';
}

$gender=$_POST['gender'] ?? '';

$state=$_POST['state'] ?? '';
$allowed_states=['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (!in_array($state, $allowed_states,true)){
    $errors[]="please select a valid state/territory.";
}

$skills = $_POST['skills'] ?? [];
$skills_text = implode(', ', $skills);

if (!empty($errors)){
    echo '<h1>Please fix these issues</h1>';
    echo '<ul>';

    foreach ($errors as $error) {
        echo '<li>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
    }

    echo '</ul>';
    echo '<p><a href="apply.php">Return to the application form</a></p>';
    exit;
}

require_once ('settings.php');

$sql = 'INSERT INTO eoi (
    job_ref, first_name, last_name, dob, email, phone, gender,
    address, suburb, state, postcode,
    skill_html5, skill_css3, skill_wcag, skill_uiux, other_skills
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

$stmt=$conn -> prepare($sql);

if (!$stmt){
    die('Cannot prepare the application insert.');
}

$stmt->bind_param(
    'sssssssssssss',
    $job_ref,
    $first_name,
    $last_name,
    $dob,
    $email,
    $phone,
    $gender,
    $address,
    $suburb,
    $state,
    $postcode,
    $skills_text,
    $other_skills
);

if (!$stmt->execute()) {
    $stmt->close();
    die('Could not save the application. Please try again later.');
}

$eoi_number = $conn->insert_id;
$stmt->close();

?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Application received</title></head>
<body>
    <main>
        <h1>Application received</h1>
        <p>Your EOI number is #<?= (int) $eoi_number ?>.</p>
        <p><a href="apply.php">Return to the application form</a></p>
    </main>
</body>
</html>
