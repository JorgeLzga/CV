<?php

    include("../Classes/Validation.php");
    include("../models/Product.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objProduct = new Product(Connection::getConnection());

    $flag = false;

    if (isset($_POST["modify_button"])) {
        $idProduct = $_POST["id_product"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $discount = $_POST["discount"];
        $description = $_POST["description"];
        $preload = $_POST["preload"];
        $image = $_FILES['image']['name'];

        $PRODUCT_VOID = [
            $name,
            $price,
            $description,
            $stock,
            $image,
            $discount,
        ];

        $PRODUCT_UPDATE = [
            $name,
            $price,
            $description,
            $stock,
            $image,
            $discount,
        ];

        $PRODUCT_WITH_IMAGE = [
            $name,
            $price,
            $description,
            $stock,
            $preload,
            $discount,
        ];

        if ($image == "" && $preload == "") {
            $flag = $objProduct->update($idProduct, $PRODUCT_VOID, true);

            if ($flag) {
                header("Location: http://localhost/projects/comercio/Web-Zapatos/views/modify-product.php");
            } else {
                showError("Ups error al actualizar producto!");
            }
        }

        if ($image != "") {
            $temp = $_FILES['image']['tmp_name'];

            $binder = "../img";

            $path = $binder . '/' . $image;

            move_uploaded_file($temp, $binder . '/' . $image);

            $flag = $objProduct->update($idProduct, $PRODUCT_UPDATE);

            if ($flag) {
                header("Location: http://localhost/projects/comercio/Web-Zapatos/views/modify-product.php");
            } else {
                showError("Ups error al actualizar producto!");
            }
        } else {
            $flag = $objProduct->update($idProduct, $PRODUCT_WITH_IMAGE);

            if ($flag) {
                header("Location: http://localhost/projects/comercio/Web-Zapatos/views/modify-product.php");
            } else {
                showError("Ups error al actualizar producto!");
            }
        }
    } else {
        header("Location: http://localhost/projects/comercio/Web-Zapatos");
    }

    function showError(string $title)
    {
        if (isset($_SESSION["isLogged"])) {
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
        } else {
            header("Location: http://localhost/projects/comercio/Web-Zapatos");
        }
    }

?>