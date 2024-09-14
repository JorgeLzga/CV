<?php

    include("../db/Connection.php");
    include("../models/User.php");
    include("../models/Cart.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    if(isset($_SESSION["isLogged"])) {
        $objUser = new User(Connection::getConnection());
        $objCart = new Cart(Connection::getConnection());

        $idUser = $_GET["id"];

        $user = $objUser->getByID($_SESSION["idUser"]);
        $itemsCart = $objCart->getAllCartByIdUser($idUser);

        if ($objUser->isAdmin($user["id_rol"])) {

?>

<!-- Admin -->
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="../globals.css" />
            <link rel="stylesheet" href="../css/static.css" />
            <link rel="stylesheet" href="../css/card-cart.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Carrito</title>
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
                            <li>Carrito</li>
                            <li class="profile-options">
                                <span><?php echo $user["nombre"] ?></span>
                                <a href="#">
                                    <i class='bx bx-cart-alt'></i>
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
                        <form action="pasarela-carrito.php" method="post">
                            <h2 class="container-cart__title">Productos</h2>
                            <input type="hidden" name="subtotal" id="total_price">
                            <input type="hidden" name="id_user" value="<?php echo $user["id"] ?>">
                            <div class="container-cart">
                            <?php if ($itemsCart) { ?>
                                <?php foreach ($itemsCart as $cart) { ?>
                                    <input type="hidden" id="id_products" value="<?php echo $cart["id"] ?>" name="ids_cart[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["id_product"] ?>" name="ids_products[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["cantidad"] ?>" name="quantities[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["existencia"] ?>" name="stock[]">
                                    <div class="card-cart">
                                        <div class="card-cart__img">
                                            <img src="../img/<?php echo $cart["imagen"] ?>" >
                                        </div>
                                        <span class="standar"><?php echo $cart["nombre"] ?></span>
                                        <span class="standar c-p">$<?php echo $cart["precio_original"] ?></span>
                                        <span class="standar">-<?php echo $cart["descuento"] ?>%</span>
                                        <span class="standar">Cantidad: <?php echo $cart["cantidad"] ?></span>
                                        <span class="standar c-p">$<?php echo $cart["precio"] ?></span>
                                        <a href="../controllers/delete-cart.php?id=<?php echo $cart["id"] ?>&idUser=<?php echo $idUser ?>">
                                            <span class="delete-span">
                                                <i class='bx bx-trash i-delete'></i>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <h1 class="message-error">No tienes ningun producto en el carrito</h1>
                            <?php } ?>
                            </div>
                            <input type="submit" value="Comprar" class="btn-buy">
                            <span class="price-total"></span>
                        </form>
                    </div>
                </main>
            </div>

            <script src="../scripts/total.js"></script>
            <script src="../scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        </body>
    </html>
    <!-- Usuario -->
<?php } else { ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="../globals.css" />
            <link rel="stylesheet" href="../css/static.css" />
            <link rel="stylesheet" href="../css/card-cart.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Carrito</title>
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
                            <li>Carrito</li>
                            <li class="profile-options">
                                <span><?php echo $user["nombre"] ?></span>
                                <a href="#">
                                    <i class='bx bx-cart-alt'></i>
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
                        <form action="pasarela-carrito.php" method="post">
                            <h2 class="container-cart__title">Productos</h2>
                            <input type="hidden" name="subtotal" id="total_price">
                            <input type="hidden" name="id_user" value="<?php echo $user["id"] ?>">
                            <div class="container-cart">
                            <?php if ($itemsCart) { ?>
                                <?php foreach ($itemsCart as $cart) { ?>
                                    <input type="hidden" id="id_products" value="<?php echo $cart["id"] ?>" name="ids_cart[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["id_product"] ?>" name="ids_products[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["cantidad"] ?>" name="quantities[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["existencia"] ?>" name="stock[]">
                                    <input type="hidden" id="id_products" value="<?php echo $cart["precio_original"] ?>" name="prices[]">
                                    <div class="card-cart">
                                        <div class="card-cart__img">
                                            <img src="../img/<?php echo $cart["imagen"] ?>" >
                                        </div>
                                        <span class="standar"><?php echo $cart["nombre"] ?></span>
                                        <span class="standar c-p">Precio original: $<?php echo $cart["precio_original"] ?></span>
                                        <span class="standar">Descuento: -<?php echo $cart["descuento"] ?>%</span>
                                        <span class="standar">Cantidad: <?php echo $cart["cantidad"] ?></span>
                                        <span class="standar c-p">Total: $<?php echo $cart["precio"] ?></span>
                                        <a href="../controllers/delete-cart.php?id=<?php echo $cart["id"] ?>&idUser=<?php echo $idUser ?>">
                                            <span class="delete-span">
                                                <i class='bx bx-trash i-delete'></i>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <h1 class="message-error">No tienes ningun producto en el carrito</h1>
                            <?php } ?>
                            </div>
                            <input type="submit" value="Comprar" class="btn-buy">
                            <span class="price-total"></span>
                        </form>
                    </div>
                </main>
            </div>

            <script src="../scripts/total.js"></script>
            <script src="../scripts/profile-options.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        </body>
    </html>
<?php } ?>

<?php } else {
    header("Location: http://localhost/projects/comercio/Web-Zapatos/");
} ?>