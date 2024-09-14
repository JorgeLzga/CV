<?php 

    include("../models/Comments.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $comments = new Comments(Connection::getConnection());

    $idComments = $_GET["id"];
    $idProduct = $_GET["id_product"];

    if ($comments->delete($idComments)) {
        header("Location: http://localhost/projects/comercio/Web-Zapatos/views/product-details.php?id=" . $idProduct);
    } else {
        showError("Ups ocurrio un error!");
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

?>