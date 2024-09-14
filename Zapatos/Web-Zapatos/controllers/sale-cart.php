<?php

    include("../models/Sale.php");
    require_once("../models/Product.php");
    require_once("../models/Cart.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $sale = new Sale(Connection::getConnection());
    $cart = new Cart(Connection::getConnection());
    $product = new Product(Connection::getConnection());

    if (isset($_POST["btn-sale"])) {
        $ids_cart = $_POST["ids_cart"];
        $total_price = $_POST["total"];
        $id_user = $_POST["id_user"];
        $municipio = $_POST["municipio"];
        $ids_products = $_POST["ids_products"];
        $quantity = $_POST["quantities"];
        $total_product = $_POST["stock"];

        $flag = createSale($sale, $product, $cart, $ids_products, $total_product, $quantity, $total_price, $ids_cart, $municipio, $id_user);

        if ($flag) {
            header("Location: http://localhost/projects/comercio/Web-Zapatos/views/my-sale.php?id=" . $id_user);
        } else {
            showError("Ups ha ocurrido un error al hacer tu compra!");
        }

    } else {
        header("Location: http://localhost/projects/comercio/Web-Zapatos");
    }

    function showError(string $title)
    {
        echo '
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <link rel="stylesheet" href="../css/static.css" />
                    <link rel="stylesheet" href="../globals.css" />
                    <link rel="stylesheet" href="../css/error.css" />
                    <title>Error</title>
                </head>
                <body>
                    <div class="container">
                        <nav class="container__aside">
                            <div class="container__aside__title">
                                <a href="/projects/comercio/Web-Zapatos/"
                                    ><h1>Tienda<span>Zapatos</span></h1></a
                                >
                            </div>
                        </nav>
                        <div class="content__products">
                            <div class="div1">
                                <h1>Ups ha ocurrido un <span>error</span> :/</h1>
                            </div>
                            <div class="div2 div2--no-inputs">
                                <h2>' . $title . '</h2>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ';
    }

    function createSale(Sale $sale, Product $product, Cart $cart, $ids_product, $stock, $quantity, $total, $ids_cart, $municipio, $id_user) : bool
    {
        $flag = false;

        for ($i=0; $i < count($ids_product); $i++) { 
            /* Actualiza el stock */
            $flagUpdate = $product->updateStock($ids_product[$i], ($stock[$i] - $quantity[$i]));
            /* Hace el insert en la tabla de venta del carrito */
            $flagInsert = $sale->saleCartFunction([$total, $ids_cart[$i], $id_user, $ids_product[$i], $municipio, $quantity[$i]]);
            /* Elimina los productos del carrito */
            $flagDelete = $cart->delete($ids_cart[$i]);
        }

        if ($flagUpdate && $flagInsert && $flagDelete) {
            $flag = true;
        } 

        return  $flag;
    }

?>