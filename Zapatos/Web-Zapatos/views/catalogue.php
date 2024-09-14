<?php

    include("../db/Connection.php");
    require_once("../models/User.php");
    require_once("../models/Product.php");
    include("../models/Cart.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objProduct = new Product(Connection::getConnection());

    $products = $objProduct->getAll(true);

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
            <link rel="stylesheet" href="../globals.css" />
            <link rel="stylesheet" href="../css/static.css" />
            <link rel="stylesheet" href="../css/modal.css" />
            <link rel="stylesheet" href="../css/card.css">
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Pagina Catálogo</title>
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
                            <li>Catálogo</li>
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
                                            <a href="my-sale.php">Compras</a>
                                            <a href="../controllers/logout.php">Cerrar Sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </header>
                    <div class="content__products">
                        <div class="content__search">
                            <i class='bx bx-search'></i>
                            <input type="text" placeholder="Buscar..." id="search">
                        </div>
                        <div class="content__products__items">
                            <?php foreach ($products as $product) { ?>
                                <?php if ($product["descuento"] > 0) { ?>
                                    <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                    data-name="<?php echo $product["nombre"] ?>">
                                        <div class="card" data-name="<?php echo $product["nombre"] ?>">
                                            <div class="card-header--discount">
                                                <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                            </div>
                                            <div class="card__image">
                                                <?php if ($product["imagen"] == "") { ?>
                                                    <img src="../img/imagen-default.png" >
                                                <?php } else { ?>
                                                    <img src="../img/<?php echo $product["imagen"] ?>" >
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
                                    <?php } else { ?>
                                            <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                            data-name="<?php echo $product["nombre"] ?>">
                                            <div class="card">
                                                <div class="">
                                                    <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                </div>
                                                <div class="card__image">
                                                    <?php if ($product["imagen"] == "") { ?>
                                                        <img src="../img/imagen-default.png" >
                                                    <?php } else { ?>
                                                        <img src="../img/<?php echo $product["imagen"] ?>" >
                                                    <?php } ?>
                                                </div>
                                                <div class="card__data">
                                                    <div class="card__data-data">
                                                        <p>Precio</p>
                                                        <span>$<?php 
                                                            echo $product["precio"];
                                                        ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <?php } ?>
                                <?php } ?>
                        </div>
                    </div>
                </main>
            </div>

            <script src="../scripts/modal.js"></script>
            <script src="../scripts/filter.js"></script>
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
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Pagina Catálogo</title>
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
                                <li>Catálogo</li>
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
                                                <a href="my-sale.php">Compras</a>
                                                <a href="../controllers/logout.php">Cerrar Sesión</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </header>
                        <div class="content__products">
                            <div class="content__search">
                                <i class='bx bx-search'></i>
                                    <input type="text" placeholder="Buscar..." id="search">
                            </div>
                            <div class="content__products__items">
                                <?php foreach ($products as $product) { ?>
                                    <?php if ($product["descuento"] > 0) { ?>
                                        <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                        data-name="<?php echo $product["nombre"] ?>">
                                            <div class="card" data-name="<?php echo $product["nombre"] ?>">
                                                <div class="card-header--discount">
                                                    <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                    <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                                </div>
                                                <div class="card__image">
                                                    <?php if ($product["imagen"] == "") { ?>
                                                        <img src="../img/imagen-default.png" >
                                                    <?php } else { ?>
                                                        <img src="../img/<?php echo $product["imagen"] ?>" >
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
                                        <?php } else { ?>
                                                <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                                data-name="<?php echo $product["nombre"] ?>">
                                                <div class="card" data-name="<?php echo $product["nombre"] ?>">
                                                    <div class="">
                                                        <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                    </div>
                                                    <div class="card__image">
                                                        <?php if ($product["imagen"] == "") { ?>
                                                            <img src="../img/imagen-default.png" >
                                                        <?php } else { ?>
                                                            <img src="../img/<?php echo $product["imagen"] ?>" >
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card__data">
                                                        <div class="card__data-data">
                                                            <p>Precio</p>
                                                            <span>$<?php 
                                                                echo $product["precio"];
                                                            ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php } ?>
                                    <?php } ?>
                            </div>
                        </div>
                    </main>
                </div>

                <script src="../scripts/modal.js"></script>
                <script src="../scripts/filter.js"></script>
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
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                />
                <title>Pagina Catálogo</title>
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
                                <li>Catálogo</li>
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
                            <div class="content__search">
                                <i class='bx bx-search'></i>
                                <input type="text" placeholder="Buscar..." id="search">
                            </div>
                            <div class="content__products__items">
                                <?php foreach ($products as $product) { ?>
                                    <?php if ($product["descuento"] > 0) { ?>
                                        <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                        data-name="<?php echo $product["nombre"] ?>">
                                            <div class="card" data-name="<?php echo $product["nombre"] ?>">
                                                <div class="card-header--discount">
                                                    <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                    <span>descuento <div class="porcent"><?php echo $product["descuento"] ?>%</div></span>
                                                </div>
                                                <div class="card__image">
                                                    <?php if ($product["imagen"] == "") { ?>
                                                        <img src="../img/imagen-default.png" >
                                                    <?php } else { ?>
                                                        <img src="../img/<?php echo $product["imagen"] ?>" >
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
                                        <?php } else { ?>
                                                <a href="../views/product-details.php?id=<?php echo $product["id"] ?>" class="container__card m-t"
                                                data-name="<?php echo $product["nombre"] ?>">
                                                <div class="card" data-name="<?php echo $product["nombre"] ?>">
                                                    <div class="">
                                                        <h2 class="card__title"><?php echo $product["nombre"] ?></h2>
                                                    </div>
                                                    <div class="card__image">
                                                        <?php if ($product["imagen"] == "") { ?>
                                                            <img src="../img/imagen-default.png" >
                                                        <?php } else { ?>
                                                            <img src="../img/<?php echo $product["imagen"] ?>" >
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card__data">
                                                        <div class="card__data-data">
                                                            <p>Precio</p>
                                                            <span>$<?php 
                                                                echo $product["precio"];
                                                            ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php } ?>
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

                <script src="../scripts/modal.js"></script>
                <script src="../scripts/filter.js"></script>
                <script src="../scripts/profile-options.js"></script>
                <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            </body>
        </html>
    <?php } ?>