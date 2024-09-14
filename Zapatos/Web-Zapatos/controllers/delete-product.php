<?php 

    include("../Classes/Validation.php");
    include("../models/Product.php");
    include("../db/Connection.php");

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $product = new product(Connection::getConnection());

    $idProduct = $_GET["id"];

    if ($product->delete($idProduct)) {
        header("Location: http://localhost/projects/comercio/Web-Zapatos/views/modify-product.php");
    } else {
        echo "Ups ocurrio un error!";
    }

?>