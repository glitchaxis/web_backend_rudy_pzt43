<?php
session_start();
unset($_SESSION['username']);
echo 'Привет, ' . $_SESSION['username'];
session_destroy();
?>