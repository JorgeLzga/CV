<?php

    include("../Classes/Validation.php");
    include("../models/Product.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $product = new product(Connection::getConnection());

    $objValidation = new Validation();
    $errorMessage = [];
    
    if (isset($_POST["create_button"])) {

        $name = $_POST["name"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $discount = $_POST["discount"];
        $image = $_FILES['image']['name'];
        $description = $_POST["description"];

        $errorMessage = $objValidation->campoVacio($name, "Nombre");
        $errorMessage = $objValidation->campoVacio($price, "Precio");
        $errorMessage = $objValidation->campoVacio($stock, "Existencia");
        $errorMessage = $objValidation->campoVacio($image, "Imagen");
        $errorMessage = $objValidation->campoVacio($description, "Descripcción");

        if ($errorMessage) {
            showErrorInputs($errorMessage);
        } else {
            $PRODUCT = [
                $name,
                $price,
                $description,
                $stock,
                $image,
                $discount,
            ];

            $temp = $_FILES['image']['tmp_name'];

            $binder = "../img";

            $path = $binder . '/' . $image;

            move_uploaded_file($temp, $binder . '/' . $image);

            $flag = $product->create($PRODUCT);

            if ($flag) {
                header("Location: http://localhost/projects/comercio/Web-Zapatos/views/create-product.php");
            } else {
                showError("Ups error al crear producto!");
            }
        }
    } else {
        header("Location: http://localhost/projects/comercio/Web-Zapatos");
    }

    function showErrorInputs(array $errorMessage)
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
                            <div class="div2 div2--inputs">
                                <h2>Campos Vacíos</h2> ';
                                foreach ($errorMessage as $error) {
                                    echo '
                                        <ul>
                                            <li> ' . $error . '</li>
                                        </ul>
                                    ';
                                }
                            '
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ';
    }

    function showErrorConfirmation()
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
                                <h2>Contraseña mal escrita!</h2>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ';
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