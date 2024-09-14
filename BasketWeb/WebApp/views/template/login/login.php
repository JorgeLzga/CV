<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php 
    require("../../template/header.php")?>
    <main>
        <div class="bg order-1 order-md-2 banner-login"></div>
        <div class="contents order-2 order-md-1">

            <div class="body-text">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="form-block">
                            <div class="text-center mb-5">
                                <h3 class="text-terracota">Login <strong>BasketApp</strong></h3>
                            </div>
                            <form action="validarLogin.php" method="POST">
                                <div class="form-group mb-3">
                                    <label class="text-barron" for="usuario">Usuario</label>
                                    <input type="text" name="vUsuario" class="form-control placeholder-light" placeholder="Usuario" 
                                            id="usuario" 
                                            minlength="5" 
                                            maxlength="8"
                                            required
                                            title="El Usuario debe tener al menos 8 caracteres"required >
                                </div>
                              
                                <div class="form-group mb-4">
                                    <label class="text-barron" for="password">Contraseña</label>
                                    <input type="password" class="form-control placeholder-light" id="vContrasena" placeholder="Contraseña" 
                                        name="vContrasena"
                                        pattern="^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                        maxlength="8" 
                                        title="La Contraseña debe tener al menos 8 caracteres, un número, una mayúscula y un carácter especial: !@#$%^&*"
                                        required>
                                </div>

                                <div>
                                    <?php if (isset($_GET['error'])) { ?>
                                        <center>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo htmlspecialchars($_GET['error']); ?>
                                            </div>
                                        
                                    </center>
                                    <?php } ?>
                                </div>

                                <input type="submit" value="Inicar Sesion" class="button-terracota">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>
