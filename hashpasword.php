<?php
$password = "apelisolutions";
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
echo $hashedPassword;
?>
