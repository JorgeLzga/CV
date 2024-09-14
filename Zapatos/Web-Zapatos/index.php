<?php

    include("db/Connection.php");
    include("models/User.php");
    include("models/Product.php");
    include("models/Cart.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objProduct = new Product(Connection::getConnection());

    $products = $objProduct->getProductsDiscount();

    if (isset($_SESSION["isLogged"])) {
        $objUser = new User(Connection::getConnection());
        $objCart = new Cart(Connection::getConnection());

        
        $user = $objUser->getByID($_SESSION["idUser"]);

        $numberCart = $objCart->getNumbersOfItem($user["id"]);


        if ($objUser->isAdmin($user["id_rol"])) {

?>
    <!-- Pagina si esta logueado y es administrador -->
    <!DOCTYPE html>
    <html lang="es">
        <head>
            
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="globals.css" />
            <link rel="stylesheet" href="index.css" />
            <link rel="stylesheet" href="./css/modal.css" />
            <link rel="stylesheet" href="./css/card.css">
            <lik rel="stylesheet" href="/css/carrusel.css">
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
             <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Pagina principal</title>
        </head>
        <body>
            <div class="container">
                <nav class="container__aside">
                    <div class="container__aside__title">
                        <a href="#"
                            ><h1>Tienda<span>Zapatos</span></h1></a
                        >

                    </div>
                    <ul>
                        <li><i class='bx bxs-building-house' ></i> <a href="./">Principal</a></li>
                        <li><i class='bx bxs-dashboard'></i> <a href="views/catalogue.php">Catálogo</a></li>
                        <li><i class='bx bx-plus-medical'></i> <a href="views/create-product.php">Crear Producto</a></li>
                        <li><i class='bx bxs-edit-alt' ></i> <a href="views/modify-product.php">Modificar Producto</a></li>
                    </ul>
                </nav>
                <main class="content">
                    <header class="content__header">
                        <ul>
                            <li>Principal</li>
                            <li class="profile-options">
                                <span><?php echo $user["nombre"] ?></span>
                                <a href="views/cart.php?id=<?php echo $user["id"] ?>">
                                <?php if ($numberCart > 0) { ?>
                                    <i class='bx bx-cart-alt cart-contain'>
                                        <div class="cart-count"><?php echo $numberCart ?></div>
                                    </i>
                                <?php } else { ?> 
                                    <i class='bx bx-cart-alt cart-contain'>
                                        <div></div>
                                    </i>
                                <?php } ?> 
                                </a>
                                <div class="profile__custom">
                                    <i class='bx bx-user-circle'></i>
                                    <div class="profile__menu">
                                        <i class="bx bx-chevron-down"></i>
                                        <div class="profile__custom__menu">
                                            <a href="views/my-sale.php">Compras</a>
                                            <a href="controllers/logout.php">Cerrar Sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </header>
                    <div class="content__products">
                        <div class="content-products__header">
                        <div id="carousel">
                          <button id="prevBtn" onclick="prevSlide()">&lt;</button>
                             <div class="carousel-container">
                                     <?php foreach ($products as $product) { ?>
                                       <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="carousel-item">
                                       <div id="image-carousel-container">
                                      <div id="image-carousel">
                                  <img src="img-carrusel/ 1.jpg" alt="primera Imagen 1">
                                 <img src="img-carrusel/2.jpg" alt="segunda Imagen 2">
                               <img src="img-carrusel/3.jpg" alt="tercera Imagen 3">
                            </a>
                            <?php } ?>
                             </div>
                             <button id="prev-btn">&#9664;</button>
                             <button id="next-btn">&#9654;</button>

                                       </div> <br>
                            <h1 class="content-products__title">¿Quiénes somos?</h1>
                            <div class="content-products__text">
                           

                            <p>Somos la empresa de ventas en linea líder en comercio de calzado y de muy buena calidad de América Latina. Nuestro propósito es democratizar el comercio y los servicios financieros para transformar la vida de millones de personas en la región.</p>
                            </div>
                            <!-- Carrusel de imágenes -->
                        </div>
                        <div class="content__offers">
                            <h2 class="content__offers__title">Mira las siguientes <span>ofertas</span></h2>
                            <?php foreach ($products as $product) { ?>
                                <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t">
                                    <div class="card">
                                        <div class="card-header--discount">
                                            <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                            <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                        </div>
                                        <div class="card__image">
                                            <?php if ($product["imagen"] == "") { ?>
                                                <img src="img/imagen-default.png" >
                                            <?php } else { ?>
                                                <img src="img/<?php echo $product["imagen"] ?>" >
                                            <?php } ?>
                                        </div>
                                        <div class="card__data">
                                            <div class="card__data-data card__data-data--pre">
                                                <p>Precio</p>
                                                <span>$<?php echo $product["precio"] ?></span>
                                            </div>
                                            <div class="card__data-data">
                                                <p>Precio</p>
                                                <span>$<?php 
                                                    $price = $product["precio"];
                                                    $porcent = $product["descuento"];
                                                    $discount = $price * ($porcent / 100);
                                                    $newPrice = $price - $discount;
                                                    echo $newPrice;
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </main>
            </div>

            <script src="./scripts/modal.js"></script>
            <script src="./scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            <script src="script.js"></script>
        </body>
    </html>
    <?php } else { ?>
        <!-- Pagina si esta logueado pero no es administrador -->
        <!DOCTYPE html>
        <html lang="es">
            <head>
    
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" href="globals.css" />
                <link rel="stylesheet" href="index.css" />
                <link rel="stylesheet" href="./css/modal.css" />
                <link rel="stylesheet" href="./css/card.css">
                <lik rel="stylesheet" href="/css/carrusel.css">
                <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Pagina principal</title>
            </head>
            <body>
                <div class="container">
                    <nav class="container__aside">
                        <div class="container__aside__title">
                            <a href="#"
                                ><h1>Tienda<span>Zapatos</span></h1></a
                            >

                        </div>
                        <ul>
                            <li><i class='bx bxs-building-house' ></i> <a href="./">Principal</a></li>
                            <li><i class='bx bxs-dashboard'></i> <a href="views/catalogue.php">Catálogo</a></li>
                        </ul>
                    </nav>
                    <main class="content">
                        <header class="content__header">
                            <ul>
                                <li>Principal</li>
                                <li class="profile-options">
                                    <span><?php echo $user["nombre"] ?></span>
                                    <a href="views/cart.php?id=<?php echo $user["id"] ?>">
                                    <?php if ($numberCart > 0) { ?>
                                        <i class='bx bx-cart-alt cart-contain'>
                                            <div class="cart-count"><?php echo $numberCart ?></div>
                                        </i>
                                    <?php } else { ?> 
                                        <i class='bx bx-cart-alt cart-contain'>
                                            <div></div>
                                        </i>
                                    <?php } ?> 
                                    </a>
                                    <div class="profile__custom">
                                        <i class='bx bx-user-circle'></i>
                                        <div class="profile__menu">
                                            <i class="bx bx-chevron-down"></i>
                                            <div class="profile__custom__menu">
                                                <a href="views/my-sale.php">Compras</a>
                                                <a href="controllers/logout.php">Cerrar Sesión</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </header>
                        <div class="content__products">
                        <div class="content-products__header">
                        <div id="carousel">
                          <button id="prevBtn" onclick="prevSlide()">&lt;</button>
                             <div class="carousel-container">
                                     <?php foreach ($products as $product) { ?>
                                       <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="carousel-item">
                                       <div id="image-carousel-container">
                                      <div id="image-carousel">
                                  <img src="img-carrusel/ 1.jpg" alt="primera Imagen 1">
                                 <img src="img-carrusel/2.jpg" alt="segunda Imagen 2">
                               <img src="img-carrusel/3.jpg" alt="tercera Imagen 3">
                            </a>
                            <?php } ?>
                             </div>
                             <button id="prev-btn">&#9664;</button>
                             <button id="next-btn">&#9654;</button>

                                       </div> <br>

                            <div class="content-products__header">
                                <h1 class="content-products__title">¿Quiénes somos?</h1>
                                <div class="content-products__text">
                                <p>Somos la empresa de ventas en linea líder en comercio de calzado y de muy buena calidad de América Latina. Nuestro propósito es democratizar el comercio y los servicios financieros para transformar la vida de millones de personas en la región.</p>
                                </div>
                                <!-- Carrusel de imágenes -->
                            </div>
                            <div class="content__offers">
                                <h2 class="content__offers__title">Mira las siguientes <span>ofertas</span></h2>
                                <?php foreach ($products as $product) { ?>
                                    <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t">
                                        <div class="card">
                                            <div class="card-header--discount">
                                                <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                            </div>
                                            <div class="card__image">
                                                <?php if ($product["imagen"] == "") { ?>
                                                    <img src="img/imagen-default.png" >
                                                <?php } else { ?>
                                                    <img src="img/<?php echo $product["imagen"] ?>" >
                                                <?php } ?>
                                            </div>
                                            <div class="card__data">
                                                <div class="card__data-data card__data-data--pre">
                                                    <p>Precio</p>
                                                    <span>$<?php echo $product["precio"] ?></span>
                                                </div>
                                                <div class="card__data-data">
                                                    <p>Precio</p>
                                                    <span>$<?php 
                                                        $price = $product["precio"];
                                                        $porcent = $product["descuento"];
                                                        $discount = $price * ($porcent / 100);
                                                        $newPrice = $price - $discount;
                                                        echo $newPrice;
                                                    ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </main>
                </div>

                <script src="./scripts/modal.js"></script>
                <script src="./scripts/profile-options.js"></script>
                <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
                <script src="script.js"></script>
            </body>
        </html>
    <?php } ?>

    <?php } else {?>
        <!-- Pagina sin loguear -->
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" href="globals.css" />
                <link rel="stylesheet" href="index.css" />
                <link rel="stylesheet" href="./css/modal.css" />
                <link rel="stylesheet" href="./css/card.css">
                <link rel="stylesheet" href="./css/carrusel.css">
                <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Pagina principal</title>
            </head>
            <body>
                <div class="container">
                    <nav class="container__aside">
                        <div class="container__aside__title">
                            <a href="#"
                                ><h1>Tienda<span>Zapatos</span></h1></a
                            >
                        </div>
                        <ul>
                            <li><i class='bx bxs-building-house' ></i> <a href="./">Principal</a></li>
                            <li><i class='bx bxs-dashboard'></i> <a href="views/catalogue.php">Catálogo</a></li>
                        </ul>
                    </nav>
                    <main class="content">
                        <header class="content__header">
                            <ul>
                                <li>Principal</li>
                                <li class="profile">
                                    <button
                                        class="profile__button"
                                        data-modal="modal-login"
                                    >
                                        Iniciar Sesión
                                    </button>
                                    <button
                                        class="profile__button"
                                        data-modal="modal-register"
                                    >
                                        Registrarse
                                    </button>
                                </li>
                            </ul>
                        </header>
                        <div class="content__products">

                        <div class="content__products">
                        <div class="content-products__header">
                        <div id="carousel">
                          <button id="prevBtn" onclick="prevSlide()">&lt;</button>
                             <div class="carousel-container">
                                     <?php foreach ($products as $product) { ?>
                                       <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="carousel-item">
                                       <div id="image-carousel-container">
                                      <div id="image-carousel">
                                  <img src="img-carrusel/ 1.jpg" alt="primera Imagen 1">
                                 <img src="img-carrusel/2.jpg" alt="segunda Imagen 2">
                               <img src="img-carrusel/3.jpg" alt="tercera Imagen 3">
                            </a>
                            <?php } ?>
                             </div>
                             <button id="prev-btn">&#9664;</button>
                             <button id="next-btn">&#9654;</button>

                                       </div> <br>



                            <div class="content-products__header">
                                <h1 class="content-products__title">¿Quiénes somos?</h1>
                                <div class="content-products__text">
                                <p>Somos la empresa de ventas en linea líder en comercio de calzado y de muy buena calidad de América Latina. Nuestro propósito es democratizar el comercio y los servicios financieros para transformar la vida de millones de personas en la región.</p>
                                </div>
                            
                            </div>
                            <div class="content__offers">
                                <h2 class="content__offers__title">Mira las siguientes <span>ofertas</span></h2>
                                <?php foreach ($products as $product) { ?>
                                    <a href="views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t">
                                        <div class="card">
                                            <div class="card-header--discount">
                                                <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                            </div>
                                            <div class="card__image">
                                                <?php if ($product["imagen"] == "") { ?>
                                                    <img src="img/imagen-default.png" >
                                                <?php } else { ?>
                                                    <img src="img/<?php echo $product["imagen"] ?>" >
                                                <?php } ?>
                                            </div>
                                            <div class="card__data">
                                                <div class="card__data-data card__data-data--pre">
                                                    <p>Precio</p>
                                                    <span>$<?php echo $product["precio"] ?></span>
                                                </div>
                                                <div class="card__data-data">
                                                    <p>Precio</p>
                                                    <span>$<?php 
                                                        $price = $product["precio"];
                                                        $porcent = $product["descuento"];
                                                        $discount = $price * ($porcent / 100);
                                                        $newPrice = $price - $discount;
                                                        echo $newPrice;
                                                    ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </main>

                    <div class="modal" id="modal-login">
                        <div class="card__modal">
                            <div class="modal__header">
                                <h1>Iniciar Sesión</h1>
                                <i class="bx bx-x"></i>
                            </div>
                            <div class="modal__body">
                                <form
                                    action="controllers/login.php"
                                    method="post"
                                >
                                    <input
                                        type="text"
                                        name="email"
                                        class="modal__input"
                                        placeholder="Correo"
                                    />
                                    <input
                                        type="password"
                                        name="password"
                                        class="modal__input"
                                        placeholder="Contraseña"
                                    />
                                    <div class="modal__footer">
                                        <button
                                            type="button"
                                            class="modal__button modal__button--cancel"
                                        >
                                            Cancelar
                                        </button>
                                        <button
                                            type="submit"
                                            name="btn-login"
                                            class="modal__button modal__button--success"
                                        >
                                            Iniciar sesion
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="modal-register">
                        <div class="card__modal">
                            <div class="modal__header">
                                <h1>Registrarse</h1>
                                <i class="bx bx-x"></i>
                            </div>
                            <div class="modal__body">
                                <form
                                    action="controllers/sing-up.php"
                                    method="post"
                                >
                                    <input
                                        type="text"
                                        name="name"
                                        class="modal__input"
                                        placeholder="nombre"
                                    />
                                    <input
                                        type="text"
                                        name="email"
                                        class="modal__input"
                                        placeholder="Correo"
                                    />
                                    <input
                                        type="password"
                                        name="password"
                                        class="modal__input"
                                        placeholder="Contraseña"
                                    />

                                    <input
                                        type="password"
                                        name="conf-pass"
                                        class="modal__input"
                                        placeholder="Confirmar Contraseña"
                                    />
                                    <div class="modal__footer">
                                        <button
                                            type="button"
                                            class="modal__button modal__button--cancel"
                                        >
                                            Cancelar
                                        </button>
                                        <button
                                            type="submit"
                                            name="btn-register"
                                            class="modal__button modal__button--success"
                                        >
                                            Registrarse
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="scripts/modal.js"></script>
                <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
                <script src="script.js"></script>
            </body>
        </html>
    <?php } ?>