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
        $objCart = new Cart(Connection::getConnection());

        $user = $objUser->getByID($_SESSION["idUser"]);
        $numberCart = $objCart->getNumbersOfItem($user["id"]);

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
            <title>Crear Producto</title>
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
                            <li>Crear Productos</li>
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
                        <form
                        action="../controllers/create-products.php"
                        method="POST"
                        enctype="multipart/form-data"
                        class="form-user"
                        >
                        <h2 class="form__title">Crear producto</h2>
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
                            />
                        </div>
                        <div class="inputs">
                            <label for="">Existencia</label>
                            <input
                                type="number"
                                placeholder="Existencia del producto"
                                class="inputs__input"
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
                            <label for="">Imagen</label>
                            <input type="file" class="inputs__input" name="image" />
                        </div>
                        <div class="inputs">
                            <label for="">Descripcion</label>
                            <textarea name="description" class="inputs__input inputs__input--area" placeholder="Descripccion del producto"></textarea>
                        </div>
                        <input
                            type="submit"
                            value="Crear"
                            class="form_button"
                            name="create_button"
                        />
                    </form>
            </div>
                </main>
            </div>

            <script src="../scripts/modal.js"></script>
            <script src="../scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        </body>
    </html>

    <?php } else { 
        header("Location: http://localhost/projects/comercio/Web-Zapatos");
    }?>