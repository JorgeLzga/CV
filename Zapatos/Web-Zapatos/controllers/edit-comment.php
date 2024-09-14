<?php

    include("../Classes/Validation.php");
    include("../models/Comments.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objComments = new Comments(Connection::getConnection());

    $flag = false;

    if (isset($_POST["btn-comment"])) {
        $idComment = $_POST["id_comment"];
        $idProduct = $_POST["id_product"];
        $comment = $_POST["comment"];

        $flag = $objComments->update($idComment, [$comment]);

        if ($flag) {
            header("Location: http://localhost/projects/comercio/Web-Zapatos/views/product-details.php?id=" . $idProduct);
        } else {
            showError("Ups ocurrio un error al actualizar el comentario");
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