<?php
if (isset($_GET['name']) && isset($_GET['city'])) {
    echo 'Пользователь ' . htmlspecialchars($_GET['name']) . ' проживает в городе ' . htmlspecialchars($_GET['city']);
} else {
    echo 'Данные не введены';
}
