<?php

    if (!isset($_GET["id"])) {
        header("Location: http://localhost/projects/comercio/Web-Zapatos/");
    }

    include("../db/Connection.php");
    require_once("../models/User.php");
    require_once("../models/Product.php");
    require_once("../models/Comments.php");
    include("../models/Cart.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objProduct = new Product(Connection::getConnection());
    $objComments = new Comments(Connection::getConnection());
    $objCart = new Cart(Connection::getConnection());

    $idProducto = $_GET["id"];

    $products = $objProduct->getByID($idProducto);
    $comments = $objComments->getCommentsByID($idProducto);
    
    if (isset($_SESSION["isLogged"])) {
        $objUser = new User(Connection::getConnection());
        
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
            <link rel="stylesheet" href="../globals.css" />
            <link rel="stylesheet" href="../css/static.css" />
            <link rel="stylesheet" href="../css/modal.css" />
            <link rel="stylesheet" href="../css/card.css">
            <link rel="stylesheet" href="../css/details.css">
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Detalle Producto</title>
        </head>
        <body>
            <div class="container">
                <nav class="container__aside">
                    <div class="container__aside__title">
                        <a href="../"
                            ><h1>Tienda<span>Zapatos</span></h1></a
                        >

                    </div>
                    <ul>
                        <li><i class='bx bxs-building-house' ></i> <a href="../">Principal</a></li>
                        <li><i class='bx bxs-dashboard'></i> <a href="catalogue.php">Catálogo</a></li>
                        <li><i class='bx bx-plus-medical'></i> <a href="create-product.php">Crear Producto</a></li>
                        <li><i class='bx bxs-edit-alt' ></i> <a href="modify-product.php">Modificar Producto</a></li>
                    </ul>
                </nav>
                <main class="content">
                    <header class="content__header">
                        <ul>
                            <li>Detalle Del Producto</li>
                            <li class="profile-options">
                                <span><?php echo $user["nombre"] ?></span>
                                <a href="cart.php?id=<?php echo $user["id"] ?>">
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
                                            <a href="#">Compras</a>
                                            <a href="../controllers/logout.php">Cerrar Sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </header>
                    <div class="content__products">
                    <div class="content__details">
                            <div class="content__details__image">
                                <img src="../img/<?php echo $products["imagen"] ?>" />
                            </div>
                            <div class="content__details__details">
                                <h1 class="content__details__h1"><?php echo $products["nombre"] ?></h1>
                                <p class="content__details__p">
                                    <?php echo $products["descripcion"] ?>
                                </p>
                                <?php if ($products["descuento"] > 0) { ?>
                                <div class="third__content">
                                <span class="text__price text__price--gray">Precio: $<?php echo $products["precio"] ?></span>
                                    <div class="content__details__price">
                                        <span class="text__price">Subtotal: $</span>
                                        <span class="number__price"><?php 
                                            $price = $products["precio"];
                                            $porcent = $products["descuento"];
                                            $discount = $price * ($porcent / 100);
                                            $newPrice = $price - $discount;
                                            echo $newPrice;
                                         ?></span>
                                        <span class="number__discount"
                                            >- <?php echo $products["descuento"] ?>% descuento</span
                                        >
                                    </div>
                                    <div class="content__details__quantity">
                                        <span>Cantidad:</span>
                                        <div class="select-options">
                                            <div class="select">
                                                <span id="first-number"></span>
                                                <i class="bx bx-chevron-down"></i>
                                            </div>
                                            <div class="option">
                                                <?php 
                                                    $count = $products["existencia"];
                                                    for ($i=1; $i <= $count; $i++) {       
                                                ?>
                                                <span><?php echo $i ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="pasarela.php" method="post">
                                        <input type="hidden" name="subtotal" class="input-hidden-id">
                                        <input type="hidden" name="quantity" class="input-hidden-id">
                                        <input type="hidden" value="<?php echo $products["existencia"] ?>" name="current_stock">
                                        <input type="hidden" value="<?php echo $products["precio"] ?>" name="current_price">
                                        <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                        <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                        <button
                                            class="form__button form__button--primary"
                                            type="submit"
                                            name="btn-sale"
                                        >
                                            Comprar
                                        </button>
                                        <input class="inputs-hidden-cart" type="hidden" value="<?php echo $user["id"] ?>">
                                        <input class="inputs-hidden-cart" type="hidden" value="<?php echo $products["id"] ?>">
                                        <input class="inputs-hidden-cart" type="hidden" value="">
                                        <input class="inputs-hidden-cart" type="hidden" value="">
                                        <a id="route_cart">
                                            <button type="button" class="form__button form__button--secondary">
                                                Añadir al carrito
                                            </button>
                                        </a>
                                    </form>
                                </div>
                                <?php } else { ?>
                                    <div class="third__content">
                                        <div class="content__details__price">
                                            <span class="text__price">Subtotal: $</span>
                                            <span class="number__price"><?php echo $products["precio"] ?></span>
                                        </div>
                                        <div class="content__details__quantity">
                                            <span>Cantidad:</span>
                                            <div class="select-options">
                                                <div class="select">
                                                    <span id="first-number"></span>
                                                    <i class="bx bx-chevron-down"></i>
                                                </div>
                                                <div class="option">
                                                    <?php 
                                                        $count = $products["existencia"];
                                                        for ($i=1; $i <= $count; $i++) { 
                                                            
                                                    ?>
                                                    <span><?php echo $i ?></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="pasarela.php" method="post">
                                            <input type="hidden" name="subtotal" class="input-hidden-id">
                                            <input type="hidden" name="quantity" class="input-hidden-id">
                                            <input type="hidden" value="<?php echo $products["existencia"] ?>" name="current_stock">
                                            <input type="hidden" value="<?php echo $products["precio"] ?>" name="current_price">
                                            <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                            <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                            <button
                                                class="form__button form__button--primary"
                                                type="submit"
                                                name="btn-sale"
                                            >
                                                Comprar
                                            </button>
                                            <input class="inputs-hidden-cart" type="hidden" value="<?php echo $user["id"] ?>">
                                            <input class="inputs-hidden-cart" type="hidden" value="<?php echo $products["id"] ?>">
                                            <input class="inputs-hidden-cart" type="hidden" value="">
                                            <input class="inputs-hidden-cart" type="hidden" value="">
                                            <a id="route_cart">
                                                <button type="button" class="form__button form__button--secondary">
                                                    Añadir al carrito
                                                </button>
                                            </a>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="content__comments">
                            <?php
                                function getFormatDate(string $day, string $month, string $year) : string
                                {
                                    $months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
                                    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", ];
                                    $monthString = $months[$month - 1];
                                    $monthFormat = $day . " " . $monthString . ", " . $year;
                                    return $monthFormat;
                                }
                            ?>
                            <div class="comments__header">
                                <h3 class="comments__header__title">Comentarios</h3>
                            </div>
                            <div class="comments__container">
                                <div class="comments__coments">
                                    <?php if (!$comments) { ?>
                                        <h2 class="comments__no-comments">Aun no hay comentarios</h2>
                                    <?php } else { ?>
                                    <?php foreach ($comments as $comment) { ?>
                                    <div class="comments__card">
                                        <div class="comments__card__profile">
                                            <i class='bx bx-user-circle card__profile__icon'></i>
                                            <h2><?php echo $comment["nombre"] ?></h2>
                                            <span><?php
                                            $tempDate = date_create($comment["fecha"]);
                                            $day = date_format($tempDate, "d");
                                            $month = date_format($tempDate, "m");
                                            $year = date_format($tempDate, "Y");
                                            $date = getFormatDate($day, $month, $year);
                                            echo $date ?>
                                            </span>
                                        </div>
                                        <div class="card__second-part">
                                            <p class="comments__card__text"><?php echo $comment["comentario"] ?></p>
                                            <?php if ($comment["id_usuario"] == $user["id"]) { ?>
                                            <div class="comments_operations">
                                                <a href="edit-comments.php?id=<?php echo $comment["id"] ?>&id_product=<?php echo $products["id"] ?>">
                                                    <i class='bx bxs-edit-alt' ></i>
                                                </a>
                                                <i class='bx bxs-trash' id="id=<?php echo $comment["id"] ?>" ></i>
                                                <input type="hidden" value="<?php echo $products["id"] ?>" id="input-hidden-id-product">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="comments__container__likes">
                                    <div class="first-part__comments">
                                        <button class="btn-comments" id="btn_comments">Añadir Comentario</button>
                                    </div>
                                    <div class="second-part__comments">
                                        <i class='bx bx-chevron-left' id="btn-back"></i>
                                        <form action="../controllers/comments.php" method="post">
                                            <textarea name="area-comments" cols="30" rows="10" placeholder="Escribe un comentario..."></textarea>
                                            <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                            <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                            <input type="submit" value="Añadir" class="btn-comments" name="btn_comments">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <div class="modal" id="modal-alert">
                        <div class="card__modal">
                            <div class="modal__header">
                                <h1 class="modal__header--alert">Alerta!</h1>
                            </div>
                            <div class="modal__body">
                                <h2>Estas seguro que quieres eliminar este elemento?</h2>
                                    <div class="modal__footer">
                                        <button
                                            type="button"
                                            class="modal__button modal__button--cancel"
                                        >
                                            Cancelar
                                        </button>
                                        <a
                                            class="modal__button modal__button--success"
                                        >
                                            Eliminar
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>

            <script src="../scripts/quantity.js"></script>
            <script src="../scripts/modal-comment.js"></script>
            <script src="../scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        </body>
    </html>

    <!-- Pagina si esta logueado pero no es administrador -->
    <?php } else { ?>
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" href="../globals.css" />
                <link rel="stylesheet" href="../css/static.css" />
                <link rel="stylesheet" href="../css/modal.css" />
                <link rel="stylesheet" href="../css/card.css">
                <link rel="stylesheet" href="../css/details.css">
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Detalle Producto</title>
            </head>
            <body>
                <div class="container">
                    <nav class="container__aside">
                        <div class="container__aside__title">
                            <a href="../"
                                ><h1>Tienda<span>Zapatos</span></h1></a
                            >

                        </div>
                        <ul>
                            <li><i class='bx bxs-building-house' ></i> <a href="../">Principal</a></li>
                            <li><i class='bx bxs-dashboard'></i> <a href="catalogue.php">Catálogo</a></li>
                        </ul>
                    </nav>
                    <main class="content">
                        <header class="content__header">
                            <ul>
                                <li>Detalle Del Producto</li>
                                <li class="profile-options">
                                    <span><?php echo $user["nombre"] ?></span>
                                    <a href="cart.php?id=<?php echo $user["id"] ?>">
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
                                                <a href="../views/my-sale.php">Compras</a>
                                                <a href="../controllers/logout.php">Cerrar Sesión</a>
                                            </div>
                                        </div>
                                    </div>
                            </li>
                            </ul>
                        </header>
                        <div class="content__products">
                            <div class="content__details">
                            <div class="content__details__image">
                                <img src="../img/<?php echo $products["imagen"] ?>" />
                            </div>
                            <div class="content__details__details">
                                <h1 class="content__details__h1"><?php echo $products["nombre"] ?></h1>
                                <p class="content__details__p">
                                    <?php echo $products["descripcion"] ?>
                                </p>
                                <?php if ($products["descuento"] > 0) { ?>
                                <div class="third__content">
                                    <span class="text__price text__price--gray">Precio: $<?php echo $products["precio"] ?></span>
                                    <div class="content__details__price">
                                        <span class="text__price">Subtotal: $</span>
                                        <span class="number__price"><?php 
                                            $price = $products["precio"];
                                            $porcent = $products["descuento"];
                                            $discount = $price * ($porcent / 100);
                                            $newPrice = $price - $discount;
                                            echo $newPrice;
                                         ?></span>
                                        <span class="number__discount"
                                            >- <?php echo $products["descuento"] ?>% descuento</span
                                        >
                                    </div>
                                    <div class="content__details__quantity">
                                        <span>Cantidad:</span>
                                        <div class="select-options">
                                            <div class="select">
                                                <span id="first-number"></span>
                                                <i class="bx bx-chevron-down"></i>
                                            </div>
                                            <div class="option">
                                                <?php 
                                                    $count = $products["existencia"];
                                                    for ($i=1; $i <= $count; $i++) {       
                                                ?>
                                                <span><?php echo $i ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="pasarela.php" method="post">
                                        <input type="hidden" name="subtotal" class="input-hidden-id">
                                        <input type="hidden" name="quantity" class="input-hidden-id">
                                        <input type="hidden" value="<?php echo $products["existencia"] ?>" name="current_stock">
                                        <input type="hidden" value="<?php echo $products["precio"] ?>" name="current_price">
                                        <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                        <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                        <button
                                            class="form__button form__button--primary"
                                            type="submit"
                                            name="btn-sale"
                                        >
                                            Comprar
                                        </button>
                                        <input class="inputs-hidden-cart" type="hidden" value="<?php echo $user["id"] ?>">
                                        <input class="inputs-hidden-cart" type="hidden" value="<?php echo $products["id"] ?>">
                                        <input class="inputs-hidden-cart" type="hidden" value="">
                                        <input class="inputs-hidden-cart" type="hidden" value="">
                                        <a id="route_cart">
                                            <button type="button" class="form__button form__button--secondary">
                                                Añadir al carrito
                                            </button>
                                        </a>
                                    </form>
                                </div>
                                <?php } else { ?>
                                    <div class="third__content">
                                        <div class="content__details__price">
                                            <span class="text__price">Subtotal: $</span>
                                            <span class="number__price"><?php echo $products["precio"] ?></span>
                                        </div>
                                        <div class="content__details__quantity">
                                            <span>Cantidad:</span>
                                            <div class="select-options">
                                                <div class="select">
                                                    <span id="first-number"></span>
                                                    <i class="bx bx-chevron-down"></i>
                                                </div>
                                                <div class="option">
                                                    <?php 
                                                        $count = $products["existencia"];
                                                        for ($i=1; $i <= $count; $i++) { 
                                                            
                                                    ?>
                                                    <span><?php echo $i ?></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="pasarela.php" method="post">
                                            <input type="hidden" name="subtotal" class="input-hidden-id">
                                            <input type="hidden" name="quantity" class="input-hidden-id">
                                            <input type="hidden" value="<?php echo $products["existencia"] ?>" name="current_stock">
                                            <input type="hidden" value="<?php echo $products["precio"] ?>" name="current_price">
                                            <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                            <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                            <button
                                                class="form__button form__button--primary"
                                                type="submit"
                                                name="btn-sale"
                                            >
                                                Comprar
                                            </button>
                                            <input class="inputs-hidden-cart" type="hidden" value="<?php echo $user["id"] ?>">
                                            <input class="inputs-hidden-cart" type="hidden" value="<?php echo $products["id"] ?>">
                                            <input class="inputs-hidden-cart" type="hidden" value="">
                                            <input class="inputs-hidden-cart" type="hidden" value="">
                                            <a id="route_cart">
                                                <button type="button" class="form__button form__button--secondary">
                                                    Añadir al carrito
                                                </button>
                                            </a>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="content__comments">
                            <?php
                                function getFormatDate(string $day, string $month, string $year) : string
                                {
                                    $months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
                                    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", ];
                                    $monthString = $months[$month - 1];
                                    $monthFormat = $day . " " . $monthString . ", " . $year;
                                    return $monthFormat;
                                }
                            ?>
                            <div class="comments__header">
                                <h3 class="comments__header__title">Comentarios</h3>
                            </div>
                            <div class="comments__container">
                                <div class="comments__coments">
                                    <?php if (!$comments) { ?>
                                        <h2 class="comments__no-comments">Aun no hay comentarios</h2>
                                    <?php } else { ?>
                                    <?php foreach ($comments as $comment) { ?>
                                    <div class="comments__card">
                                        <div class="comments__card__profile">
                                            <i class='bx bx-user-circle card__profile__icon'></i>
                                            <h2><?php echo $comment["nombre"] ?></h2>
                                            <span><?php
                                            $tempDate = date_create($comment["fecha"]);
                                            $day = date_format($tempDate, "d");
                                            $month = date_format($tempDate, "m");
                                            $year = date_format($tempDate, "Y");
                                            $date = getFormatDate($day, $month, $year);
                                            echo $date ?>
                                            </span>
                                        </div>
                                        <div class="card__second-part">
                                            <p class="comments__card__text"><?php echo $comment["comentario"] ?></p>
                                            <?php if ($comment["id_usuario"] == $user["id"]) { ?>
                                            <div class="comments_operations">
                                                <a href="edit-comments.php?id=<?php echo $comment["id"] ?>&id_product=<?php echo $products["id"] ?>">
                                                    <i class='bx bxs-edit-alt' ></i>
                                                </a>
                                                <i class='bx bxs-trash' id="id=<?php echo $comment["id"] ?>" ></i>
                                                <input type="hidden" value="<?php echo $products["id"] ?>" id="input-hidden-id-product">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="comments__container__likes">
                                    <div class="first-part__comments">
                                        <button class="btn-comments" id="btn_comments">Añadir Comentario</button>
                                    </div>
                                    <div class="second-part__comments">
                                        <i class='bx bx-chevron-left' id="btn-back"></i>
                                        <form action="../controllers/comments.php" method="post">
                                            <textarea name="area-comments" cols="30" rows="10" placeholder="Escribe un comentario..."></textarea>
                                            <input type="hidden" value="<?php echo $user["id"] ?>" name="id_user">
                                            <input type="hidden" value="<?php echo $products["id"] ?>" name="id_product">
                                            <input type="submit" value="Añadir" class="btn-comments" name="btn_comments">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </main>

                    <div class="modal" id="modal-alert">
                        <div class="card__modal">
                            <div class="modal__header">
                                <h1 class="modal__header--alert">Alerta!</h1>
                            </div>
                            <div class="modal__body">
                                <h2>Estas seguro que quieres eliminar este elemento?</h2>
                                    <div class="modal__footer">
                                        <button
                                            type="button"
                                            class="modal__button modal__button--cancel"
                                        >
                                            Cancelar
                                        </button>
                                        <a
                                            class="modal__button modal__button--success"
                                        >
                                            Eliminar
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="../scripts/quantity.js"></script>
                <script src="../scripts/modal-comment.js"></script>
                <script src="../scripts/profile-options.js"></script>
                <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
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
                <link rel="stylesheet" href="../globals.css" />
                <link rel="stylesheet" href="../css/static.css" />
                <link rel="stylesheet" href="../css/modal.css" />
                <link rel="stylesheet" href="../css/card.css">
                <link rel="stylesheet" href="../css/details.css">
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Detalle Producto</title>
            </head>
            <body>
                <div class="container">
                    <nav class="container__aside">
                        <div class="container__aside__title">
                            <a href="../"
                                ><h1>Tienda<span>Zapatos</span></h1></a
                            >

                        </div>
                        <ul>
                            <li><i class='bx bxs-building-house' ></i> <a href="../">Principal</a></li>
                            <li><i class='bx bxs-dashboard'></i> <a href="catalogue.php">Catálogo</a></li>
                        </ul>
                    </nav>
                    <main class="content">
                        <header class="content__header">
                            <ul>
                                <li>Detalle Del Producto</li>
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
                            <div class="content__details">
                            <div class="content__details__image">
                                <img src="../img/<?php echo $products["imagen"] ?>" />
                            </div>
                            <div class="content__details__details">
                                <h1 class="content__details__h1"><?php echo $products["nombre"] ?></h1>
                                <p class="content__details__p">
                                    <?php echo $products["descripcion"] ?>
                                </p>
                                <?php if ($products["descuento"] > 0) { ?>
                                <div class="third__content">
                                <span class="text__price text__price--gray">Precio: $<?php echo $products["precio"] ?></span>
                                    <div class="content__details__price">
                                        <span class="text__price">Subtotal: $</span>
                                        <span class="number__price"><?php 
                                            $price = $products["precio"];
                                            $porcent = $products["descuento"];
                                            $discount = $price * ($porcent / 100);
                                            $newPrice = $price - $discount;
                                            echo $newPrice;
                                         ?></span>
                                        <span class="number__discount"
                                            >- <?php echo $products["descuento"] ?>% descuento</span
                                        >
                                    </div>
                                    <div class="content__details__quantity">
                                        <span>Cantidad:</span>
                                        <div class="select-options">
                                            <div class="select select--desactive">
                                                <span id="first-number"></span>
                                                <i class="bx bx-chevron-down"></i>
                                            </div>
                                            <div class="option">
                                                <?php 
                                                    $count = $products["existencia"];
                                                    for ($i=1; $i <= $count; $i++) { 
                                                            
                                                ?>
                                                <span><?php echo $i ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="">
                                        <button
                                            class="form__button form__button--desactive"
                                            type="submit"
                                        >
                                            Comprar
                                        </button>
                                        <button class="form__button form__button--desactive" type="submit">
                                            Añadir al carrito
                                        </button>
                                    </form>
                                </div>
                                <?php } else { ?>
                                    <div class="third__content">
                                        <div class="content__details__price">
                                            <span class="text__price">Precio: $</span>
                                            <span class="number__price"><?php echo $products["precio"] ?></span>
                                        </div>
                                        <div class="content__details__quantity">
                                            <span>Cantidad:</span>
                                            <div class="select-options">
                                                <div class="select select--desactive">
                                                    <span id="first-number"></span>
                                                    <i class="bx bx-chevron-down"></i>
                                                </div>
                                                <div class="option">
                                                    <?php 
                                                        $count = $products["existencia"];
                                                        for ($i=1; $i <= $count; $i++) { 
                                                            
                                                    ?>
                                                    <span><?php echo $i ?></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="">
                                            <button
                                                class="form__button form__button--desactive"
                                                type="submit"
                                            >
                                                Comprar
                                            </button>
                                            <button class="form__button form__button--desactive" type="submit">
                                                Añadir al carrito
                                            </button>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="content__comments">
                            <?php
                                function getFormatDate(string $day, string $month, string $year) : string
                                {
                                    $months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
                                    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", ];
                                    $monthString = $months[$month - 1];
                                    $monthFormat = $day . " " . $monthString . ", " . $year;
                                    return $monthFormat;
                                }
                            ?>
                            <div class="comments__header">
                                <h3 class="comments__header__title">Comentarios</h3>
                            </div>
                            <div class="comments__container">
                                <div class="comments__coments">
                                <?php if (!$comments) { ?>
                                        <h2 class="comments__no-comments">Aun no hay comentarios</h2>
                                    <?php } else { ?>
                                    <?php foreach ($comments as $comment) { ?>
                                    <div class="comments__card">
                                        <div class="comments__card__profile">
                                            <i class='bx bx-user-circle card__profile__icon'></i>
                                            <h2><?php echo $comment["nombre"] ?></h2>
                                            <span><?php
                                            $tempDate = date_create($comment["fecha"]);
                                            $day = date_format($tempDate, "d");
                                            $month = date_format($tempDate, "m");
                                            $year = date_format($tempDate, "Y");
                                            $date = getFormatDate($day, $month, $year);
                                            echo $date ?>
                                            </span>
                                        </div>
                                        <div class="card__second-part">
                                            <p class="comments__card__text"><?php echo $comment["comentario"] ?></p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="comments__container__likes">
                                    <div class="first-part__comments">
                                        <p>Debes iniciar sesion para añadir un comentario!</p>
                                    </div>
                                    <div class="second-part__comments">
                                        <i class='bx bx-chevron-left' id="btn-back"></i>
                                        <form action="">
                                            <textarea name="" id="" cols="30" rows="10" placeholder="Escribe un comentario..."></textarea>
                                            <input type="submit" value="Añadir" class="btn-comments">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    action="../controllers/login.php"
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
                                    action="../controllers/sing-up.php"
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

                <script src="../scripts/quantity.js"></script>
                <script src="../scripts/modal.js"></script>
                <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            </body>
        </html>
    <?php } ?>