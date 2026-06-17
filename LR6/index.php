<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru" data-bs-spy="scroll">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <base target="_blank">
</head>
<?php
$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);
?>
<body>

<?php if ($alert): ?>
<div class="container mt-3" style="position: relative; z-index: 9999;">
    <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $alert['text']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

    <header class="header sticky-top">
        <div class="header-container">
            <div class="header-top">
                <a href="#" class="logo-box">
                    <img src="content/media/logos/logo-1.png" alt="Fib Pasta Bar">
                </a>
                <div class="delivery-info">
                    <span class="delivery-title">Доставка пасты <span class="highlight">Москва</span></span>
                    <div class="rating-bar">
                        <img src="content/media/icons/icon-yandex-food.png" class="icon" alt="Yandex Food">
                        <span>Яндекс еда</span>
                        <span class="dot">&#9679;</span>
                        <span>4.8</span>
                        <span class="star">&#9733;</span>
                        <span>Время доставки</span>
                        <span class="dot">&#9679;</span>
                        <span>от 31 мин</span>
                    </div>
                </div>
                <button class="callback-btn" data-bs-toggle="modal" data-bs-target="#callbackModal">Заказать звонок</button>
                <div class="phone-number">8 499 391-84-49</div>
            </div>
            <div class="header-bottom">
                <nav class="nav-menu">
                    <a href="#pizza">Пицца</a>
                    <a href="#pasta">Паста</a>
                    <a href="#soups">Супы</a>
                    <a href="#salads">Салаты</a>
                    <a href="#drinks">Напитки</a>
                    <a href="#desserts">Десерты</a>
                    <a href="#bakery">Бакалея</a>
                    <a href="#antipasti">Антипасти</a>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ещё</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#akcii">Акции</a></li>
                            <li><a class="dropdown-item" href="#combo">Комбо</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#delivery">Контакты</a></li>
                        </ul>
                    </div>
                    <a href="#" class="nav-login">Войти</a>
                </nav>
                <button class="cart-btn" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                    <span class="cart-text">Корзина</span>
                    <span class="cart-sep"></span>
                    <span class="cart-count">1</span>
                </button>
                <button class="burger-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-label="Меню">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <a href="#" class="logo-box">
                <img src="content/media/logos/logo-1.png" alt="Fib Pasta Bar" height="32">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <nav class="mobile-nav flex-grow-1 overflow-auto py-3">
                <a href="#pizza" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Пицца</a>
                <a href="#pasta" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Паста</a>
                <a href="#soups" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Супы</a>
                <a href="#salads" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Салаты</a>
                <a href="#drinks" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Напитки</a>
                <a href="#desserts" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Десерты</a>
                <a href="#bakery" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Бакалея</a>
                <a href="#antipasti" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Антипасти</a>
                <a href="#akcii" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Акции</a>
                <a href="#combo" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Комбо</a>
                <a href="#delivery" class="d-block px-4 py-3" data-bs-dismiss="offcanvas">Контакты</a>
                <a href="#" class="nav-login d-block px-4 py-3 mt-2 border-top">Войти</a>
            </nav>
            <div class="p-4 border-top d-flex flex-column gap-3">
                <div class="phone-number text-center" style="font-size: 20px;">8 499 391-84-49</div>
                <button class="callback-btn w-100" data-bs-toggle="modal" data-bs-target="#callbackModal" data-bs-dismiss="offcanvas">Заказать звонок</button>
            </div>
        </div>
    </div>

    <section class="hero-section py-4" id="hero">
        <div class="container-fluid">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="poster-grid-top position-relative">
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-4.png" alt=""></div>
                            <div class="poster poster--main"><img src="content/media/posters/poster-1.png" alt=""></div>
                            <div class="poster poster--main poster--dark d-none d-md-block"><img src="content/media/posters/poster-2.png" alt=""></div>
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-4.png" alt=""></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="poster-grid-top position-relative">
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-2.png" alt=""></div>
                            <div class="poster poster--main"><img src="content/media/posters/poster-4.png" alt=""></div>
                            <div class="poster poster--main poster--dark d-none d-md-block"><img src="content/media/posters/poster-1.png" alt=""></div>
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-2.png" alt=""></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="poster-grid-top position-relative">
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-1.png" alt=""></div>
                            <div class="poster poster--main"><img src="content/media/posters/poster-2.png" alt=""></div>
                            <div class="poster poster--main poster--dark d-none d-md-block"><img src="content/media/posters/poster-4.png" alt=""></div>
                            <div class="poster poster--side d-none d-xl-block"><img src="content/media/posters/poster-1.png" alt=""></div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Назад</span>
                </button>
                <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Вперёд</span>
                </button>
            </div>
        </div>
    </section>

    <section class="section novinki-section py-3" id="novinki">
        <div class="container">
            <h2 class="section-title-top mb-3">Новинки</h2>
            <div class="row g-3 flex-nowrap overflow-auto pb-2">
                <div class="col-auto">
                    <div class="new-pizza d-flex align-items-center gap-3 p-3 rounded-3 bg-white">
                        <div class="new-pizza-image-box flex-shrink-0">
                            <img src="content/media/icons/pizza-icon.png" alt="" width="56" height="56">
                        </div>
                        <div class="new-pizza-info">
                            <p class="new-pizza-name mb-1">Карбонара</p>
                            <p class="new-pizza-price mb-0">от 120 ₽</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="new-pizza d-flex align-items-center gap-3 p-3 rounded-3 bg-white">
                        <div class="new-pizza-image-box flex-shrink-0">
                            <img src="content/media/icons/pizza-icon.png" alt="" width="56" height="56">
                        </div>
                        <div class="new-pizza-info">
                            <p class="new-pizza-name mb-1">Карбонара</p>
                            <p class="new-pizza-price mb-0">от 120 ₽</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="new-pizza d-flex align-items-center gap-3 p-3 rounded-3 bg-white">
                        <div class="new-pizza-image-box flex-shrink-0">
                            <img src="content/media/icons/pizza-icon.png" alt="" width="56" height="56">
                        </div>
                        <div class="new-pizza-info">
                            <p class="new-pizza-name mb-1">Карбонара</p>
                            <p class="new-pizza-price mb-0">от 120 ₽</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="new-pizza d-flex align-items-center gap-3 p-3 rounded-3 bg-white">
                        <div class="new-pizza-image-box flex-shrink-0">
                            <img src="content/media/icons/pizza-icon.png" alt="" width="56" height="56">
                        </div>
                        <div class="new-pizza-info">
                            <p class="new-pizza-name mb-1">Карбонара</p>
                            <p class="new-pizza-price mb-0">от 120 ₽</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pasta-section py-3" id="pasta">
        <div class="container">
            <h2 class="section-title-pasta mb-4">Паста</h2>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-1.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-2.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-3.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-4.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-1.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-2.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-3.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-4.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section pasta-section py-3" id="pasta2">
        <div class="container">
            <h2 class="section-title-pasta mb-4">Паста</h2>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-1.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-2.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-3.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-4.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-1.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-2.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-3.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                        <div class="image-box mb-3">
                            <img src="content/media/pizzas/pizza-4.png" alt="" class="img-fluid">
                        </div>
                        <div class="product-info flex-grow-1">
                            <h3 class="title mb-2">С креветками и трюфелями</h3>
                            <p class="description mb-0">Домашнаяя паста феттуччине, сливочный соус, креветки, трюфельное масло, черный перец, пармезан.350 г</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                            <p class="price mb-0">от 600 ₽</p>
                            <button class="add-btn" onclick="addToCart()">В корзину</button>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section akcii-section py-4" id="akcii">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Наши <span class="highlight">акции</span></h2>
            </div>
            <div class="cakes-grid">
                <div class="cakes-large"><img src="content/media/posters/poster-5.png" alt=""></div>
                <div class="cakes-small"><img src="content/media/posters/poster-5.png" alt=""></div>
                <div class="cakes-small"><img src="content/media/posters/poster-5.png" alt=""></div>
                <div class="cakes-small"><img src="content/media/posters/poster-5.png" alt=""></div>
                <div class="cakes-small"><img src="content/media/posters/poster-5.png" alt=""></div>
            </div>
            <div class="text-center mt-4">
                <button class="all-sales">Все акции</button>
            </div>
        </div>
    </section>

    <section class="section subscribe-section py-5" id="subscribe">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="subscribe-box p-4 rounded-3 bg-white text-center">
                        <h2 class="section-title mb-3">Подпишитесь на <span class="highlight">рассылку</span></h2>
                        <p class="text-muted mb-4">Получайте эксклюзивные акции и новости первыми</p>
                        <form action="subscribe.php" method="POST" class="row g-3 justify-content-center">
                            <div class="col-12 col-md-8">
                                <input type="email" name="email" class="form-control" placeholder="Ваш email" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Подписаться</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section faq-section py-5" id="faq">
        <div class="container">
            <h2 class="section-title text-center mb-4">Частые <span class="highlight">вопросы</span></h2>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true">
                                    Как оформить заказ?
                                </button>
                            </h2>
                            <div id="faqCollapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Выберите блюда из меню, нажмите «В корзину», затем перейдите в корзину и оформите заказ. Минимальная сумма доставки — 600 ₽.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false">
                                    Какое время доставки?
                                </button>
                            </h2>
                            <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Среднее время доставки по Москве составляет от 31 минуты. Точное время зависит от вашего района и загруженности кухни.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false">
                                    Есть ли бесплатная доставка?
                                </button>
                            </h2>
                            <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Бесплатная доставка при заказе от 1500 ₽. При меньшей сумме стоимость доставки рассчитывается автоматически.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false">
                                    Какие способы оплаты принимаете?
                                </button>
                            </h2>
                            <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Мы принимаем оплату картой онлайн, картой курьеру, наличными и через Apple Pay / Google Pay.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="payment-and-delivery py-5 mt-5" id="delivery">
        <div class="container">
            <h3 class="payment-text text-center mb-5">Оплата и доставка</h3>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-grid-element text-center position-relative p-4 pt-5 rounded-3 bg-white">
                        <div class="info-grid-element-icon position-absolute top-0 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle">
                            <img src="content/media/icons/icon-1.png" alt="" width="40" height="40">
                        </div>
                        <div class="info-grid-element-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-grid-element text-center position-relative p-4 pt-5 rounded-3 bg-white">
                        <div class="info-grid-element-icon position-absolute top-0 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle">
                            <img src="content/media/icons/icon-2.png" alt="" width="40" height="40">
                        </div>
                        <div class="info-grid-element-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-grid-element text-center position-relative p-4 pt-5 rounded-3 bg-white">
                        <div class="info-grid-element-icon position-absolute top-0 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle">
                            <img src="content/media/icons/icon-3.png" alt="" width="40" height="40">
                        </div>
                        <div class="info-grid-element-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-grid-element text-center position-relative p-4 pt-5 rounded-3 bg-white">
                        <div class="info-grid-element-icon position-absolute top-0 start-50 translate-middle d-flex align-items-center justify-content-center rounded-circle">
                            <img src="content/media/icons/icon-4.png" alt="" width="40" height="40">
                        </div>
                        <div class="info-grid-element-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="map ratio ratio-21x9 rounded-3 overflow-hidden" style="max-height: 322px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.0!2d37.5!3d55.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDQyJzAwLjAiTiAzN8KwMzAnMDAuMCJF!5e0!3m2!1sru!2sru!4v1" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer py-5">
        <div class="container position-relative">
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="#" class="footer-logo d-block mb-3">
                        <img src="content/media/logos/logo-1.png" alt="YaBao" height="40">
                    </a>
                    <a href="#" class="footer-link d-block mb-3">Калорийность и состав</a>
                    <div class="social-block">
                        <h4 class="footer-title mb-3">Мы в соцсетях</h4>
                        <div class="row g-2">
                            <div class="col-auto"><a href="#" class="social-link" data-bs-toggle="tooltip" title="Наш YouTube канал">YouTube</a></div>
                            <div class="col-auto"><a href="#" class="social-link" data-bs-toggle="tooltip" title="Facebook страница">Facebook</a></div>
                            <div class="col-auto"><a href="#" class="social-link" data-bs-toggle="tooltip" title="Instagram профиль">Instagram</a></div>
                            <div class="col-auto"><a href="#" class="social-link" data-bs-toggle="tooltip" title="ВКонтакте сообщество">ВКонтакте</a></div>
                        </div>
                        <div class="footer-address mt-3">Москва ул. Проспект<br>Вернадского 86В</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="#" class="footer-link d-block">Правовая информация</a>
                    <a href="phpmailer_simple.php" class="footer-link d-block mt-2">PHPMailer: Простое сообщение</a>
                    <a href="phpmailer_attach.php" class="footer-link d-block mt-2">PHPMailer: С вложением</a>
                    <a href="phpmailer_multi.php" class="footer-link d-block mt-2">PHPMailer: Несколько адресатов</a>
                    <a href="survey.php" class="footer-link d-block mt-2">Анкета клиента</a>
                </div>
                <div class="col-12 col-lg-5">
                    <h4 class="footer-title-uppercase mb-4">Остались вопросы? А мы всегда на связи:</h4>
                    <div class="row g-2">
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="Viber"><img src="content/media/icons/icon-viber.png" alt="" width="24" height="24"></a></div>
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="Skype"><img src="content/media/icons/icon-skype.png" alt="" width="24" height="24"></a></div>
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="Messenger"><img src="content/media/icons/icon-messenger.png" alt="" width="24" height="24"></a></div>
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="Telegram"><img src="content/media/icons/icon-telegram.png" alt="" width="24" height="24"></a></div>
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="Facebook"><img src="content/media/icons/icon-facebook.png" alt="" width="24" height="24"></a></div>
                        <div class="col-4 col-md-2"><a href="#" class="messenger-box d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="tooltip" title="ВКонтакте"><img src="content/media/icons/icon-vk.png" alt="" width="24" height="24"></a></div>
                        <div class="col-12"><a href="#" class="messenger-box write-to-us d-flex align-items-center justify-content-center rounded-3" data-bs-toggle="modal" data-bs-target="#callbackModal">Написать нам</a></div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-5 pt-4 border-top">
                <div class="col-12 col-md-4 text-center text-md-start">
                    <p class="copyright mb-0">YaBao Все права защищены © 2021</p>
                </div>
                <div class="col-12 col-md-4 text-center my-3 my-md-0">
                    <a href="tel:84993918449" class="footer-phone d-block mb-2">8 499 391-84-49</a>
                    <button class="callback-btn" data-bs-toggle="modal" data-bs-target="#callbackModal">Заказать звонок</button>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                        <div class="payment-icon" data-bs-toggle="tooltip" title="Оплата Visa"><img src="content/media/icons/icon-visa.png" alt="" width="46" height="46"></div>
                        <div class="payment-icon" data-bs-toggle="tooltip" title="Оплата PayPal"><img src="content/media/icons/icon-paypal.png" alt="" width="46" height="46"></div>
                        <div class="payment-icon" data-bs-toggle="tooltip" title="Оплата Mastercard"><img src="content/media/icons/icon-mastercard.png" alt="" width="46" height="46"></div>
                    </div>
                </div>
            </div>
        </div>
        <img src="content/media/logos/logo-2.png" class="footer-logo-bg d-none d-lg-block" alt="bg logo">
    </footer>

    <div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callbackModalLabel">Заказать звонок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="callbackForm" action="callback.php" method="POST">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Ваше имя</label>
                            <input type="text" class="form-control" id="userName" name="name" placeholder="Иван" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="userPhone" name="phone" placeholder="+7 (999) 000-00-00" required>
                        </div>
                        <div class="mb-3">
                            <label for="userMessage" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="userMessage" name="message" rows="3" placeholder="Удобное время для звонка..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">Корзина</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded-3" style="background: var(--color-bg-light);">
                <img src="content/media/pizzas/pizza-1.png" width="60" height="60" class="rounded-3 object-fit-cover" alt="">
                <div class="flex-grow-1">
                    <div class="fw-bold" style="font-size: 14px;">С креветками и трюфелями</div>
                    <div class="text-muted" style="font-size: 13px;">600 ₽</div>
                </div>
                <span class="fw-bold">1 шт.</span>
            </div>
            <div class="mt-4">
                <p class="mb-2 fw-bold" style="font-size: 14px;">До бесплатной доставки:</p>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mt-2 text-muted" style="font-size: 13px;">Осталось 970 ₽</p>
            </div>
        </div>
        <div class="offcanvas-footer p-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold">Итого:</span>
                <span class="fw-bold" style="font-size: 20px;">600 ₽</span>
            </div>
            <button class="btn btn-primary w-100">Оформить заказ</button>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cartToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <span style="color: var(--color-primary); margin-right: 8px;">&#10003;</span>Товар добавлен в корзину!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function(){
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        var cartToastEl = document.getElementById('cartToast');
        var cartToast = new bootstrap.Toast(cartToastEl, { delay: 3000 });

        window.addToCart = function() {
            cartToast.show();
            var countEl = document.querySelector('.cart-count');
            if(countEl) {
                countEl.textContent = parseInt(countEl.textContent) + 1;
            }
        };

        var mobileMenu = document.getElementById('mobileMenuOffcanvas');
        var burgerBtn = document.querySelector('.burger-menu-btn');
        if (mobileMenu && burgerBtn) {
            mobileMenu.addEventListener('show.bs.offcanvas', function () {
                burgerBtn.classList.add('is-active');
            });
            mobileMenu.addEventListener('hide.bs.offcanvas', function () {
                burgerBtn.classList.remove('is-active');
            });
        }
    })();
    </script>
</body>
</html>