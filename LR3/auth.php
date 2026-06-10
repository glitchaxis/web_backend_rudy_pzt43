<?php
if (isset($_POST['username'])) {
    echo 'Добро пожаловать, ' . htmlentities($_POST['username']) . '!';
} else {
    echo 'Данные не переданы';
}
