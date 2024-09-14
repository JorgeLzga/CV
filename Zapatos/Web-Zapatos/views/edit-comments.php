<?php

    include("../models/Comments.php");
    include("../db/Connection.php");

    session_start();

    Connection::setHost("localhost");
    Connection::setDbName("tienda_zapatos");
    Connection::setUser("root");
    Connection::setPassword("");

    $objComments = new Comments(Connection::getConnection());

    $idComment = $_GET["id"];
    $idProduct = $_GET["id_product"];

    $comment = $objComments->getByID($idComment);

    if (isset($_SESSION["isLogged"])) {

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../globals.css">
    <link rel="stylesheet" href="../css/edit-comments.css">
    <title>Editar comentarios</title>
</head>
<body>
    <form action="../controllers/edit-comment.php" method="post" class="form-edit">
        <h1>Actualizar comentario</h1>
        <input type="hidden" value="<?php echo $comment["id"] ?>" name="id_comment">
        <input type="hidden" value="<?php echo $idProduct ?>" name="id_product">
        <textarea name="comment"><?php echo $comment["comentario"] ?></textarea>
        <input type="submit" name="btn-comment" value="Actualizar" class="btn btn-primary">
        <a href="../views/product-details.php?id=<?php echo $idProduct ?>" class="btn-a">Cancelar</a>
    </form>
</body>
</html>

<?php } else {
    header("Location: http://localhost/projects/comercio/Web-Zapatos/");
}?>