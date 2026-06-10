<?php
session_start();
$_SESSION['username'] = "Данила";
echo 'Привет, ' . $_SESSION['username'] . "<br>";
?>
<a href="page2.php">На следующую страницу</a>