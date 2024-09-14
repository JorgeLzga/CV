<?php

    include("../models/Sale.php");
    require_once("../models/Product.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $sale = new Sale(Connection::getConnection());
    $product = new Product(Connection::getConnection());

    if (isset($_POST["btn-sale"])) {
        $total = $_POST["total"];
        $quantity = $_POST["quantity"];
        $idUser = $_POST["id_user"];
        $idProduct = $_POST["id_product"];
        $stock = $_POST["current_stock"];
        $subtotal = $_POST["subtotal"];
        $current_price = $_POST["current_price"];
        $municipio = $_POST["municipio"];

        $SALE = [
            $quantity,
            $total,
            $idUser,
            $idProduct,
            $subtotal,
            $current_price,
            $municipio
        ];

        $flag = createSale($sale, $product, $SALE, $idProduct, ($stock - $quantity));

        if ($flag) {
            header("Location: http://localhost/projects/comercio/Web-Zapatos/views/my-sale.php?id=" . $idUser);
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

    function createSale(Sale $sale, Product $product, array $arraySale, int $id, float $newStock) : bool
    {
        $flag = false;

        if ($sale->create($arraySale) && $product->updateStock($id, $newStock)) {
            $flag = true;
        } 

        return  $flag;
    }

?>