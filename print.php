<?php 

$_SESSION['userid'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Debugging: Check session variables
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit();

?>