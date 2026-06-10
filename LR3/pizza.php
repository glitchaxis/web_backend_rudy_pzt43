<h3>Заказ пиццы</h3>
<form action="pizza.php" method="POST">
    Размер пиццы: <br>
    <input type="radio" name="size" value="small" checked> Маленькая (250 руб.) <br>
    <input type="radio" name="size" value="medium"> Средняя (350 руб.) <br>
    <input type="radio" name="size" value="large"> Большая (450 руб.) <br><br>

    Топпинги: <br>
    <input type="checkbox" name="topping[]" value="cheese"> Сыр <br>
    <input type="checkbox" name="topping[]" value="mushrooms"> Грибы <br>
    <input type="checkbox" name="topping[]" value="sausages"> Колбаса <br>
    <input type="checkbox" name="topping[]" value="olives"> Оливки <br><br>

    Комментарий к заказу: <br>
    <textarea name="comment"></textarea><br><br>

    Способ доставки:
    <select name="delivery">
        <option value="pickup">Самовывоз</option>
        <option value="delivery">Курьером</option>
    </select><br><br>

    <input type="submit" value="Заказать">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalPrice = 0;

    if (isset($_POST['size'])) {
        if ($_POST['size'] === 'small') $totalPrice += 250;
        elseif ($_POST['size'] === 'medium') $totalPrice += 350;
        elseif ($_POST['size'] === 'large') $totalPrice += 450;
    }

    if (isset($_POST['topping'])) {
        $totalPrice += count($_POST['topping']) * 50;
    }

    echo "Итого к оплате: " . $totalPrice . " руб.<br>";

    if (isset($_POST['topping'])) {
        echo "Выбранные топпинги: " . implode(', ', $_POST['topping']) . "<br>";
    } else {
        echo "Топпинги не выбраны<br>";
    }

    echo "Комментарий: " . htmlentities($_POST['comment']) . '<br>';
    echo "Вариант доставки: " . htmlentities($_POST['delivery']);
}
