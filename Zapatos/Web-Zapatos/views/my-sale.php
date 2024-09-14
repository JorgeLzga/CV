<?php

    include("../db/Connection.php");
    include("../models/User.php");
    include("../models/Sale.php");
    /* require_once("../models/Product.php"); */
    include("../models/Cart.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    if(isset($_SESSION["isLogged"])) {
        $objUser = new User(Connection::getConnection());
        $objSale = new Sale(Connection::getConnection());
        $objCart = new Cart(Connection::getConnection());

        $user = $objUser->getByID($_SESSION["idUser"]);
        $numberCart = $objCart->getNumbersOfItem($user["id"]);
        $sales = $objSale->getByID($user["id"]);
        $salesCart = $objSale->saleCartByID($user["id"]);

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
            <link rel="stylesheet" href="../css/table.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Compras</title>
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
                            <li>Mis compras</li>
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
                        <!-- Aqui va la tabla de mis compras -->
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
            <link rel="stylesheet" href="../css/table.css" />
            <link
                href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                rel="stylesheet"
            />
            <title>Compras</title>
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
                            <li>Mis compras</li>
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
                    <div class="content__products--table">
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
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Descuento</th>
                                    <th>Cantidad</th>
                                    <th>Municipio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $sale) { ?>
                                <tr>
                                    <td><img src="../img/<?php echo $sale["imagen"] ?>" alt="Producto"></td>
                                    <td><?php echo $sale["nombre"]?></td>
                                    <td><?php
                                            $tempDate = date_create($sale["fecha"]);
                                            $day = date_format($tempDate, "d");
                                            $month = date_format($tempDate, "m");
                                            $year = date_format($tempDate, "Y");
                                            $date = getFormatDate($day, $month, $year);
                                            echo $date ?>
                                    </td>
                                    <td>$<?php echo $sale["precio_actual"]?></td>
                                    <td>$<?php echo $sale["subtotal"]?></td>
                                    <td>$<?php echo $sale["total"]?></td>
                                    <td>-<?php echo $sale["descuento"]?>%</td>
                                    <td><?php echo $sale["cantidad"]?></td>
                                    <td><?php echo $sale["municipio"]?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table>
                            <caption>Detalles de Venta del Carrito</caption>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Descuento</th>
                                    <th>Cantidad</th>
                                    <th>Municipio</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($salesCart as $saleCart) { ?>
                                <tr>
                                    <td><img src="../img/<?php echo $saleCart["imagen"] ?>" alt="Producto"></td>
                                    <td><?php echo $saleCart["nombre"]?></td>
                                    <td><?php
                                            $tempDate = date_create($saleCart["fecha"]);
                                            $day = date_format($tempDate, "d");
                                            $month = date_format($tempDate, "m");
                                            $year = date_format($tempDate, "Y");
                                            $date = getFormatDate($day, $month, $year);
                                            echo $date ?>
                                    </td>
                                    <td>$<?php echo $saleCart["precio"]?></td>
                                    <td>$<?php 
                                            $price = $saleCart["precio"];
                                            $porcent = $saleCart["descuento"];
                                            $discount = $price * ($porcent / 100);
                                            $newPrice = $price - $discount;
                                            echo $newPrice * $saleCart["cantidad"];
                                         ?></td>
                                    <td>$<?php echo $saleCart["total"]?></td>
                                    <td>-<?php echo $saleCart["descuento"]?>%</td>
                                    <td><?php echo $saleCart["cantidad"]?></td>
                                    <td><?php echo $saleCart["municipio"]?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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