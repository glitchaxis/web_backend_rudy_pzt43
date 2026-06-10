<?php
session_start();
echo $_SESSION['username'] . ', ты пришёл на другую страницу этого сайта!';
echo "<br>";
?>
<a href="page3.php">На следующую страницу</a>