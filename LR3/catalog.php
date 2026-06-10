<?php
// 1. Массив товаров
$products = [
    ['name' => 'Ноутбук Lenovo', 'category' => 'Электроника', 'price' => 55000],
    ['name' => 'Смартфон iPhone 13', 'category' => 'Электроника', 'price' => 70000],
    ['name' => 'Книга по PHP', 'category' => 'Книги', 'price' => 1200],
    ['name' => 'Роман "1984"', 'category' => 'Книги', 'price' => 800],
    ['name' => 'Кофеварка', 'category' => 'Бытовая техника', 'price' => 4500],
    ['name' => 'Микроволновка', 'category' => 'Бытовая техника', 'price' => 6000],
    ['name' => 'Игровая мышь', 'category' => 'Электроника', 'price' => 2500],
    ['name' => 'Сковорода', 'category' => 'Кухня', 'price' => 1800],
];
$categories = array_unique(array_column($products, 'category'));
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$selected_category = $_GET['category'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог товаров</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .filters { margin-bottom: 20px; padding: 15px; background-color: #e9ecef; width: max-content; }
    </style>
</head>
<body>

    <h2>Фильтр каталога</h2>

    <p>
        <strong>Быстрые фильтры:</strong>
        <a href="catalog.php?min_price=1000">Товары дороже 1000</a> |
        <a href="catalog.php?category=Книги">Только книги</a> |
        <a href="catalog.php">Сбросить всё</a>
    </p>

    <div class="filters">
        <form action="catalog.php" method="GET">
            <label>Минимальная цена:</label><br>
            <input type="number" name="min_price" value="<?= htmlspecialchars($min_price) ?>"><br><br>

            <label>Максимальная цена:</label><br>
            <input type="number" name="max_price" value="<?= htmlspecialchars($max_price) ?>"><br><br>

            <label>Категория:</label><br>
            <select name="category">
                <option value="">Все категории</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($selected_category === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <input type="submit" value="Применить фильтр">
        </form>
    </div>

    <h2>Список товаров</h2>

    <table>
        <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена (руб.)</th>
        </tr>
        <?php
        $found = false; 

        foreach ($products as $item) {
            $show = true;
            if ($min_price !== '' && $item['price'] < (int)$min_price) {
                $show = false;
            }
            if ($max_price !== '' && $item['price'] > (int)$max_price) {
                $show = false;
            }
            if ($selected_category !== '' && $item['category'] !== $selected_category) {
                $show = false;
            }
            if ($show) {
                $found = true;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                echo "<td>" . htmlspecialchars($item['category']) . "</td>";
                echo "<td>" . htmlspecialchars($item['price']) . "</td>";
                echo "</tr>";
            }
        }
        if (!$found) {
            echo "<tr><td colspan='3'>По вашему запросу ничего не найдено.</td></tr>";
        }
        ?>
    </table>

</body>
</html>