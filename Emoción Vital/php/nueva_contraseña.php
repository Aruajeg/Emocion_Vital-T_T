<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/Style/style_nueva_pass.css">
    <title>RESTAURAR</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form id=loginForm" action="" method="POST">
                <h1>Recuperar Contraseña</h1>
                <input type="password" placeholder="Nueva contraseña" name="correo" required>
                <input type="password" placeholder="Repite la contraseña" name="correo" required>
                <button>Cambiar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Estas a solo un paso</h1>
                    <p>Ingresa tu nueva contraseña</p>
                </div>
            </div>
        </div>
        
        </div>
        <!-- Botón para volver al inicio -->
        <div style="text-align:center; margin-top:30px;">
            <a href="/login_register.php" class="btn-2">Volver a iniciar sesión</a>
        </div>

    </div>
    </div>

    <script src="Js\script.js"></script>

    <script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const correo = this.correo.value.trim();
    const username = this.username.value.trim();
    const contrasena = this.contrasena.value.trim();
    if (!correo || !username || !contrasena) {
        alert('Por favor, completa todos los campos.');
        e.preventDefault();
    }
});
</script>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const correo = this.correo.value.trim();
    const contrasena = this.contrasena.value.trim();
    if (!correo || !contrasena) {
        alert('Por favor, completa todos los campos.');
        e.preventDefault();
    }
});
</script>

</body>

</html>