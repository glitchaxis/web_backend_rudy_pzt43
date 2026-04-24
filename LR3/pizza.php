<h3>Заказ пиццы</h3>
<form action="pizza.php" method="POST">
    Размер пиццы: <br>
    <input type = "radio" name = "size" value="small" checked> Маленькая (250 руб.) <br>
    <input type = "radio" name = "size" value="medium"> Средняя (350 руб.) <br>
    <input type = "radio" name = "size" value="large"> Большая (450 руб.) <br>

    Топпинги: <br>
    <input type = "checkbox" name = "topping[]" value = "cheese">Сыр <br>
    <input type = "checkbox" name = "topping[]" value = "mushrooms">Грибы <br>
    <input type = "checkbox" name = "topping[]" value = "sausages">Колбаса <br>
    <input type = "checkbox" name = "topping[]" value = "olives">Оливки <br>
    
    Комментарий к заказу: <br>
    <textarea name="comment"></textarea>

    Способ доставки: 
    <select id = "delivery" name = "delivery">
        <option value = "pickup">Самовывоз </option>
        <option value = "delivery">Курьером </option>
    </select>  
    <input type = "submit" value = "Заказать">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalPrice = 0;

    if ($_POST['size'] === 'small') $totalPrice += 250;
    elseif ($_POST['size'] === 'medium') $totalPrice += 350;
    else $totalPrice += 450;

    if (isset($_POST['topping'])) {
        $totalPrice += count($_POST['topping']) * 50; 
    }
    

    echo "Итого к оплате: " . $totalPrice . " руб.<br>";
    if (isset($_POST['topping']))
        echo "Выбранные топпинги: " . implode(', ', $_POST['topping']) . "<br>";
    else echo "Топпинги не выбраны<br>";

    echo "Комментарий:" . htmlentities($_POST['comment']) . '<br>';
    echo "Вариант доставки: " . $_POST['delivery'];

}
?>