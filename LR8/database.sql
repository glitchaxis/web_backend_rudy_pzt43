CREATE DATABASE IF NOT EXISTS LR8 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE LR8;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    sort_order INT DEFAULT 0
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    weight VARCHAR(50),
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(200) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    customer_email VARCHAR(200),
    delivery_address TEXT NOT NULL,
    comment TEXT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('new','processing','delivered','cancelled') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO categories (name, slug, sort_order) VALUES ('Пицца', 'pizza', 1);

INSERT INTO products (category_id, name, description, price, weight, image) VALUES
(1, 'Маргарита', 'Томатный соус, моцарелла, свежий базилик, оливковое масло', 390.00, '450 г', 'content/media/pizzas/pizza-1.png'),
(1, 'Пепперони', 'Томатный соус, моцарелла, острая колбаса пепперони, орегано', 520.00, '480 г', 'content/media/pizzas/pizza-2.png'),
(1, 'Четыре сыра', 'Соус бешамель, моцарелла, пармезан, горгонзола, чеддер', 580.00, '450 г', 'content/media/pizzas/pizza-3.png'),
(1, 'Гавайская', 'Томатный соус, моцарелла, ветчина, ананасы', 470.00, '460 г', 'content/media/pizzas/pizza-4.png'),
(1, 'Мясная', 'Томатный соус, моцарелла, ветчина, бекон, пепперони, охотничьи колбаски', 620.00, '520 г', 'content/media/pizzas/pizza-1.png'),
(1, 'Диабло', 'Томатный соус, моцарелла, пепперони, халапеньо, острый соус', 550.00, '470 г', 'content/media/pizzas/pizza-2.png'),
(1, 'Карбонара', 'Сливочный соус, моцарелла, бекон, яйцо, пармезан, черный перец', 590.00, '480 г', 'content/media/pizzas/pizza-3.png'),
(1, 'С грибами', 'Сливочный соус, моцарелла, шампиньоны, белые грибы, трюфельное масло', 540.00, '460 г', 'content/media/pizzas/pizza-4.png'),
(1, 'Барбекю', 'Барбекю соус, моцарелла, куриная грудка, бекон, красный лук', 560.00, '490 г', 'content/media/pizzas/pizza-1.png'),
(1, 'Вегетарианская', 'Томатный соус, моцарелла, болгарский перец, томаты, шампиньоны, маслины, лук', 450.00, '440 г', 'content/media/pizzas/pizza-2.png'),
(1, 'С морепродуктами', 'Сливочный соус, моцарелла, креветки, мидии, кальмары, лимон', 720.00, '480 г', 'content/media/pizzas/pizza-3.png'),
(1, 'Буррата', 'Томатный соус, моцарелла, буррата, руккола, томаты черри, песто', 680.00, '470 г', 'content/media/pizzas/pizza-4.png');
