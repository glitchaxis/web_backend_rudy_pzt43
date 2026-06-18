# Fib Pasta Bar — LR8 (PHP + MySQL)

## Установка

### 1. Создание базы данных

Открой phpMyAdmin: http://localhost/phpmyadmin

Создай базу `LR8` и импортируй `database.sql`:
```sql
-- Вкладка SQL в phpMyAdmin, вставь содержимое database.sql
```

Или через командную строку:
```bash
cd C:\xampp\mysql\bin
mysql -u root -p -e "CREATE DATABASE LR8 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p LR8 < C:\xampp\htdocs\LR8\database.sql
```

### 2. Настройка подключения

Если пароль root не пустой — отредактируй `config.php`:
```php
$DB_PASS = 'твой_пароль';
```

### 3. Запуск

Помести папку в `htdocs`:
```
C:\xampp\htdocs\LR8\
```

Открой: http://localhost/LR8/index.php

## Структура БД

| Таблица | Описание |
|---------|----------|
| `categories` | Категории меню (Пицца, Паста, Супы...) |
| `products` | Товары с ценами, описанием, изображениями |
| `orders` | Заказы клиентов |
| `order_items` | Позиции в заказе |

## Функционал

- **Каталог** — товары из БД с категориями
- **Поиск** — по названию и описанию
- **Сортировка** — цена ↑/↓, название А-Я/Я-А
- **Фильтрация** — по категории, по цене (мин/макс)
- **Пагинация** — 8 товаров на страницу
- **Корзина** — AJAX добавление, изменение количества, удаление
- **Оформление заказа** — форма + сохранение в БД

## Файлы

```
LR8/
├── index.php          # Главная (каталог)
├── cart.php           # Корзина
├── cart_ajax.php      # AJAX обработчик
├── checkout.php       # Оформление заказа
├── order_success.php  # Подтверждение заказа
├── config.php         # Подключение к БД
├── functions.php      # Функции
├── database.sql       # Структура БД + данные
└── styles.css         # Стили
```
