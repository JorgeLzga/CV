<?php

    include("../Classes/Validation.php");
    require_once("../models/User.php");
    require_once("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $user = new User(Connection::getConnection());

    $objValidation = new Validation();
    $errorMessage = [];
    
    if (isset($_POST["btn-register"])) {

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confPass = $_POST["conf-pass"];

        $errorMessage = $objValidation->campoVacio($name, "Nombre");
        $errorMessage = $objValidation->campoVacio($email, "Correo");
        $errorMessage = $objValidation->campoVacio($password, "Contraseña");
        $errorMessage = $objValidation->campoVacio($confPass, "Confirmar Constraseña");

        if ($errorMessage) {
            showErrorInputs($errorMessage);
        } else {
            if (!$objValidation->passwordConfirmation($password, $confPass)) {
                showErrorConfirmation();
            } else {
                $name = $objValidation->limpiarVariable($name);
                $email = $objValidation->limpiarVariable($email);
                $password = $objValidation->limpiarVariable($password);

                $USER = [
                    $name,
                    $email,
                    sha1($password),
                ];

                if ($user->create($USER)) {
                    header("Location: http://localhost/projects/comercio/Web-Zapatos");
                } else {
                    showError("Ups error al crear usuario!");
                }
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