<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: bienvenida.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style\style.css">
    <title>Formulario de inicio de sesión y registro</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="php/registro_usuario_be.php" method="POST">
                <h1>Crear Cuenta</h1>
                <div class="social-icons">
                    <a href="https://www.youtube.com/@UNEFA_VEN" target="_blank" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.facebook.com/groups/2487908341354828/?hoisted_section_header_type=recently_seen&multi_permalinks=3659583284187322" target="_blank" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/unefa_ve/" target="_blank" class="icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://x.com/Unefa_VEN" target="_blank" class="icon"><i class="fa-brands fa-twitter"></i></a>
                </div>
                <input type="email" placeholder="Correo electrónico" name="correo">
                <input type="text" placeholder="Usuario" name="username">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <button>Crear</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="php/login_usuario_be.php" method="POST">
                <h1>Iniciar Sesión</h1>
                <div class="social-icons">
                    <a href="https://www.youtube.com/@UNEFA_VEN" target="_blank" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.facebook.com/groups/2487908341354828/?hoisted_section_header_type=recently_seen&multi_permalinks=3659583284187322" target="_blank" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/unefa_ve/" target="_blank" class="icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://x.com/Unefa_VEN" target="_blank" class="icon"><i class="fa-brands fa-twitter"></i></a>
                </div>
                <input type="email" placeholder="Correo electrónico" name="correo">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <a href="#">¿Olvidaste tu contraseña?</a>
                <button>Entrar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¿Primera vez aquí?</h1>
                    <p>Ingresa tu información personal para acceder al sitio</p>
                    <button class="hidden" id="login">Iniciar Sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Bienvenido!</h1>
                    <p>¡Accede para agendar tu cita ahora!</p>
                    <button class="hidden" id="register">Registrate</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Js\script.js"></script>
</body>

</html>