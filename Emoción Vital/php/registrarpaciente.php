<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="/Style/llenardatos.css">
    <style>
        .volver-inicio {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 24px;
            background: #4e73df;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .volver-inicio:hover {
            background: #2e59d9;
            color: #fff;
            text-decoration: none;
        }
        .volver-inicio i {
            margin-right: 6px;
        }
        .page-title {
            text-align: center;
            color:rgb(22, 74, 65);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    
    <div class="container" style="max-width:600px;margin:40px auto;">
        <h1 class="page-title">Registrar Paciente</h1>
        <h2>Registrar Paciente</h2>
        <?php
        // Mostrar mensaje si viene por GET, pero no es obligatorio para mostrar el formulario
        if (isset($_GET['mensaje']) && $_GET['mensaje'] !== '') {
            echo '<div class="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
        }
        ?>
        <form method="post" action="/php/registrarpacientelogica.php">
            <div>
                <label for="nombre1">Primer Nombre:</label>
                <input type="text" id="nombre1" name="nombre1" required class="form-control"
                       pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$" title="Solo letras y espacios, mínimo 2 caracteres">
            </div>
            <div>
                <label for="nombre2">Segundo Nombre:</label>
                <input type="text" id="nombre2" name="nombre2" class="form-control"
                       pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{0,30}$" title="Solo letras y espacios">
            </div>
            <div>
                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" required class="form-control"
                       pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$" title="Solo letras y espacios, mínimo 2 caracteres">
            </div>
            <div>
                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2" class="form-control"
                       pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{0,30}$" title="Solo letras y espacios">
            </div>
            <div>
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required class="form-control"
                       pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|es|net|org|edu|gov|co|ve|mx|ar|cl|pe|uy|ec|bo|py|br|cr|gt|hn|ni|pa|sv|do|cu|pr|us)$"
                       title="Ingrese un correo válido">
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required class="form-control"
                       pattern="^[0-9]{7,15}$" title="Solo números, entre 7 y 15 dígitos">
            </div>
            <div>
                <label for="n_documento">N° Documento:</label>
                <input type="text" id="n_documento" name="n_documento" required class="form-control"
                       pattern="^[0-9]{5,20}$" title="Solo números, entre 5 y 20 dígitos">
            </div>
            <div>
                <label for="tipo_documento">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento" required class="form-control">
                    <option value="">Seleccione</option>
                    <option value="V">V</option>
                    <option value="E">E</option>
                    <option value="P">P</option>
                    <option value="J">J</option>
                </select>
            </div>
            <div>
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required class="form-control">
            </div>
            <div>
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required class="form-control">
                    <option value="">Seleccione</option>
                    <option value="Hombre">Hombre</option>
                    <option value="Mujer">Mujer</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div>
                <label for="desc_paciente">Descripción / Motivo de la consulta:</label>
                <textarea id="desc_paciente" name="desc_paciente" rows="3" required class="form-control"></textarea>
            </div>
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Registrar Paciente</button>
            </div>
        </form>
        <a href="/php/dashboard.php" class="volver-inicio">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
    <!-- Font Awesome para el ícono -->
    <script src="https://kit.fontawesome.com/4b8b3e1c1a.js" crossorigin="anonymous"></script>
</body>
</html>

