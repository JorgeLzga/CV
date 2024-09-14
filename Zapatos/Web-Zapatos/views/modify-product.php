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

    if (isset($_SESSION["isLogged"])) {
        $objUser = new User(Connection::getConnection());
        $objProduct = new Product(Connection::getConnection());
        $objProductId = new Product(Connection::getConnection());
        $objCart = new Cart(Connection::getConnection());
        
        $user = $objUser->getByID($_SESSION["idUser"]);
        $products = $objProduct->getAll(true);
        $numberCart = $objCart->getNumbersOfItem($user["id"]);
        
        if ($objUser->isAdmin($user["id_rol"])) {

?>

<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="../globals.css" />
            <link rel="stylesheet" href="../css/static.css" />
            <link rel="stylesheet" href="../css/modal.css" />
            <link rel="stylesheet" href="../css/card.css">
            <link rel="stylesheet" href="../css/form.css">
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Modificar Productos</title>
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
                            <li>Modificar Productos</li>
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
                            <form action="#">
                                <input type="text" placeholder="Buscar...">
                            </form>
                        </div>
                        <div class="content__products__items">
                            <?php foreach ($products as $product) { ?>
                                <?php if ($product["descuento"] > 0) { ?>
                                    <div href="#" class="container__card m-t">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["id"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["nombre"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["precio"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["existencia"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["descuento"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["descripcion"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["imagen"] ?>">
                                        <div class="card__admin">
                                            <div class="card__admin--items">
                                                    <button id="<?php echo $product["id"] ?>" class="card__admin--options">
                                                        <i class='bx bx-edit-alt'></i>
                                                    </button>
                                                    <button class="card__admin--options">
                                                        <i class='bx bx-x' id="id=<?php echo $product["id"] ?>" ></i>
                                                    </button>
                                                </div>
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
                                    </div>
                                    <?php } else { ?>
                                    <div class="container__card m-t">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["id"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["nombre"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["precio"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["existencia"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["descuento"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["descripcion"] ?>">
                                        <input class="inputs__hidden" type="hidden" value="<?php echo $product["imagen"] ?>">
                                        <div class="card__admin">
                                            <div class="card__admin--items">
                                                    <button id="<?php echo $product["id"] ?>" class="card__admin--options">
                                                        <i class='bx bx-edit-alt'></i>
                                                    </button>
                                                    <button class="card__admin--options" >
                                                        <i class='bx bx-x' id="id=<?php echo $product["id"] ?>" ></i>
                                                    </button>
                                            </div>
                                            <div>
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
                                    </div>
                                        <?php } ?>
                                <?php } ?>
                        </div>
                        <div class="content__modify">
                            <div class="content_modify__header">
                                <i class='bx bx-left-arrow-alt'></i>
                            </div>
                            <div class="content_modify__form">
                                <form
                                action="../controllers/edit-product.php"
                                method="POST"
                                enctype="multipart/form-data"
                                class="form-user form-user--desactive"
                                >
                                <h2 class="form__title">Modificar producto</h2>
                                <input type="hidden" class="inputs__input" name="id_product" >
                                    <div class="inputs">
                                        <label for="">Nombre</label>
                                        <input
                                            type="text"
                                            placeholder="Nombre del producto"
                                            class="inputs__input"
                                            name="name"
                                        />
                                    </div>
                                    <div class="inputs">
                                        <label for="">Precio</label>
                                        <input
                                            type="number"
                                            placeholder="Precio del producto"
                                            class="inputs__input"
                                            name="price"
                                            min="0"
                                        />
                                    </div>
                                    <div class="inputs">
                                        <label for="">Existencia</label>
                                        <input
                                            type="number"
                                            placeholder="Existencia del producto"
                                            class="inputs__input"
                                            min="0"
                                            name="stock"
                                        />
                                    </div>
                                    <div class="inputs">
                                        <label for="">Descuento</label>
                                        <input
                                            type="number"
                                            placeholder="Descuento del producto"
                                            class="inputs__input"
                                            name="discount"
                                            min="0"
                                            max="100"
                                        />
                                    </div>
                                    <div class="inputs">
                                        <label for="">Descripcion</label>
                                        <textarea name="description" class="inputs__input inputs__input--area" placeholder="Descripccion del producto"></textarea>
                                    </div>
                                    <input type="hidden" class="inputs__input" name="preload" >
                                    <div class="inputs">
                                        <label for="">Imagen</label>
                                        <input type="file" class="inputs__input" name="image" />
                                    </div>
                                    <input
                                        type="submit"
                                        value="Modificar"
                                        class="form_button"
                                        name="modify_button"
                                    />
                                </form>
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

            <script src="../scripts/modal-modify.js"></script>
            <script src="../scripts/form-modify.js"></script>
            <script src="../scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        </body>
    </html>

    <?php } } else {header("Location: http://localhost/projects/comercio/Web-Zapatos");}?>