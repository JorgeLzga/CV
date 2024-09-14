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

        $subtotal = $_POST["subtotal"];
        $ids_cart = $_POST["ids_cart"];
        $id_user = $_POST["id_user"];
        $ids_products = $_POST["ids_products"];
        $quantity = $_POST["quantities"];
        $stock = $_POST["stock"];

        $user = $objUser->getByID($_SESSION["idUser"]);
        $numberCart = $objCart->getNumbersOfItem($user["id"]);

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
            <link rel="stylesheet" href="../css/pasarela.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Pasarela</title>
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
                    <form action="../controllers/sale-cart.php" method="POST">
                            <p>Pasarela de Pago - <span>Cobro de envio $200</span></p>

                            <label for="nombre">Nombre en la Tarjeta:</label>
                            <input type="text" id="nombre" name="nombre" required>

                            <label for="tarjeta">Número de Tarjeta:</label>
                            <input type="text" id="tarjeta" name="tarjeta" required>

                            <label for="fecha">Fecha de Expiración:</label>
                            <input type="text" id="fecha" name="fecha" placeholder="MM/AA" required>

                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" required>

                            <label for="direccion">Dirección de Envío:</label>
                            <input type="text" id="direccion" name="direccion" required>

                            <label for="cp">Código Postal:</label>
                            <input type="text" id="cp" name="cp" required>

                            <label for="municipio">Município:</label>
                            <select id="municipio" name="municipio" required>
                                <option value="mazatlan">Mazatlan</option>
                                <option value="concordia">Concordia</option>
                                <option value="culiacan">Culiacan</option>
                                <option value="fuerte">El fuerte</option>
                            </select>

                            <div class="total">Total: $<?php echo $subtotal + 200; ?></div>

                            <input type="hidden" name="total" value="<?php echo ($subtotal + 200) ?>">
                            <input type="hidden" name="subtotal" value="<?php echo $subtotal ?>">
                            <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                            
                            <?php 
                                for ($i=0; $i < count($ids_cart); $i++) {
                            ?>
                                <input type="hidden" name="ids_products[]" value="<?php echo $ids_products[$i] ?>">
                                <input type="hidden" name="ids_cart[]" value="<?php echo $ids_cart[$i] ?>">
                                <input type="hidden" name="quantities[]" value="<?php echo $quantity[$i] ?>">
                                <input type="hidden" name="stock[]" value="<?php echo $stock[$i] ?>">
                            <?php } ?>

                            <button type="submit" name="btn-sale">Pagar</button>
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
            <link rel="stylesheet" href="../css/pasarela.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Pasarela</title>
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
                            <li>Pasarela</li>
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
                        <form action="../controllers/sale-cart.php" method="POST">
                            <p>Pasarela de Pago - <span>Cobro de envio $200</span></p>

                            <label for="nombre">Nombre en la Tarjeta:</label>
                            <input type="text" id="nombre" name="nombre" required>

                            <label for="tarjeta">Número de Tarjeta:</label>
                            <input type="text" id="tarjeta" name="tarjeta" required>

                            <label for="fecha">Fecha de Expiración:</label>
                            <input type="text" id="fecha" name="fecha" placeholder="MM/AA" required>

                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" required>

                            <label for="direccion">Dirección de Envío:</label>
                            <input type="text" id="direccion" name="direccion" required>

                            <label for="cp">Código Postal:</label>
                            <input type="text" id="cp" name="cp" required>

                            <label for="municipio">Município:</label>
                            <select id="municipio" name="municipio" required>
                                <option value="mazatlan">Mazatlan</option>
                                <option value="concordia">Concordia</option>
                                <option value="culiacan">Culiacan</option>
                                <option value="fuerte">El fuerte</option>
                            </select>
                            
                            <div class="total">Total: $<?php echo $subtotal + 200; ?></div>

                            <input type="hidden" name="total" value="<?php echo ($subtotal + 200) ?>">
                            <input type="hidden" name="subtotal" value="<?php echo $subtotal ?>">
                            <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                            
                            <?php 
                                for ($i=0; $i < count($ids_cart); $i++) {
                            ?>
                                <input type="hidden" name="ids_products[]" value="<?php echo $ids_products[$i] ?>">
                                <input type="hidden" name="ids_cart[]" value="<?php echo $ids_cart[$i] ?>">
                                <input type="hidden" name="quantities[]" value="<?php echo $quantity[$i] ?>">
                                <input type="hidden" name="stock[]" value="<?php echo $stock[$i] ?>">
                            <?php } ?>
                            
                            <button type="submit" name="btn-sale">Pagar</button>
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