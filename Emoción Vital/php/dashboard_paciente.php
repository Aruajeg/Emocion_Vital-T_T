<?php
session_start();
if(!isset($_SESSION['usuario'])){
    echo '<script> 
        alert("Debes iniciar sesión para tener acceso a esta página");
        window.location = "index.php";
        </script>';
    session_destroy();
    die();
}

// --- CONEXIÓN A LA BASE DE DATOS (debe ir antes de cualquier consulta) ---
$host = "localhost";
$user = "root";
$pass = "";
$db = "implantacion";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ahora puedes hacer tus consultas:
$total_pacientes = $conn->query("SELECT COUNT(*) FROM paciente")->fetch_row()[0];
$total_citas_activas = $conn->query("SELECT COUNT(*) FROM solicitar_cita WHERE Status='ACTIVO'")->fetch_row()[0];
$total_citas = $conn->query("SELECT COUNT(*) FROM solicitar_cita")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PACIENTE</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="/Style/styles_dashboard_pacientes.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-lg order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Brand-->
            <img src="/Imagen/Psico4.png" alt="Logo del consultorio" style="height:50px; vertical-align:middle; margin-left:20px;">
            <a class="navbar-brand ps-3" href="#">EMOCIÓN VITAL</a>
            <!-- Navbar Search-->
            <!--<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="#" id="btnPerfilUsuario" data-bs-toggle="modal" data-bs-target="#perfilModal">Cuenta</a>
                        </li>
                        <li><a class="dropdown-item" href="/php/cerrar_sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <!-- Sidebar-->
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">PRINCIPAL</div>
                            <a class="nav-link" href="/php/dashboard_paciente.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                <span>Inicio</span>
                            </a>
                            <div class="sb-sidenav-menu-heading">SISTEMA</div>
                            <a class="nav-link" href="/php/solicitarcita_paciente.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-plus"></i></div>
                                <span>Solicitar Cita</span>
                            </a>
                            <!--<<a class="nav-link" href="/php/registrarpaciente.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                                <span>Registrar Paciente</span>
                            </a>-->
                            <!--<<a class="nav-link" href="/php/registrarpsicologo.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-md"></i></div>
                                <span>Registrar Psicólogo</span>
                            </a>-->
                            <div class="sb-sidenav-menu-heading">GESTIÓN</div>
                            <a class="nav-link" href="/php/consultarcitas_paciente.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                                <span>Citas Agendadas</span>
                            </a>
                            <!--<<a class="nav-link" href="/php/gestionregistros.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                                <span>Gestionar Registros</span>
                            </a>-->
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Sesión iniciada como:</div>
                        <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">INICIO</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Pagina de inicio</li>
                        </ol>
                        <?php

?>
<style>

.dashboard-center-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    margin-top: 30px;
    margin-bottom: 40px;
    width: 100%;
}

.dashboard-stats,
.dashboard-access {
    justify-content: center !important;
    margin-left: 0 !important;
}

@media (max-width: 900px) {
    .dashboard-stats {
        flex-direction: column;
        gap: 20px;
        margin-left: 0;
    }
    .dashboard-stats .stat-box {
        max-width: 100%;
        min-width: 0;
    }
}
</style>
<div class="dashboard-center-container">

    <div class="row" style="margin-left:0; margin-right:0; gap:30px; margin-bottom:40px; display:flex; flex-wrap:wrap;">
        <div class="col-xl-3 col-md-6" style="min-width:270px; flex:1 1 270px; max-width:350px;">
            <div class="card bg-primary text-white mb-4" style="border-radius:10px;">
                <div class="card-body" style="font-size:20px;">SOLICITAR CITA</div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.07); border-radius:0 0 10px 10px;">
                    <a class="small text-white stretched-link" href="/php/solicitarcita_paciente.php" onclick="mostrarFormularioCita();return false;">Ir a solicitar cita...</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6" style="min-width:270px; flex:1 1 270px; max-width:350px;">
            <div class="card bg-warning text-white mb-4" style="border-radius:10px;">
                <div class="card-body" style="font-size:20px;">CITAS AGENDADAS</div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.07); border-radius:0 0 10px 10px;">
                    <a class="small text-white stretched-link" href="/php/consultarcitas_paciente.php">Ir a citas agendadas...</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
                        
                        
                     </div>
                </main>
                <!-- Modal Perfil de Usuario -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="perfilModalLabel">Perfil de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="perfilModalBody">
        <!-- Aquí se cargará el perfil vía AJAX -->
        <div class="text-center"><div class="spinner-border text-primary"></div></div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('btnPerfilUsuario').addEventListener('click', function(e) {
    var modalBody = document.getElementById('perfilModalBody');
    modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary"></div></div>';
    fetch('/php/perfil_modal.php')
        .then(response => response.text())
        .then(html => { modalBody.innerHTML = html; });
});
</script>
                <div id="layoutSidenav_footer">
                    <footer class="papa2">
                        <!-- Section: Social media -->
                        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
                            <!-- Left -->
                            <div class="me-5 d-none d-lg-block">
                                <span>Conéctate con nosotros en las redes sociales:</span>
                            </div>
                            <!-- Left -->

                            <!-- Right -->
                            <div>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="" class="me-4 text-reset">
                                    <i class="fab fa-github"></i>
                                </a>
                            </div>
                            <!-- Right -->
                        </section>
                        <!-- Section: Social media -->

                        <!-- Section: Links  -->
                        <section class="papa">
                            <div class="row text-left">
                                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                                    <h5 class="text-uppercase">Enlaces útiles</h5>

                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="#!" class="text-reset">Inicio</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Solicitar Cita</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Registrar Paciente</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Registrar Psicólogo</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                                    <h5 class="text-uppercase">Servicios</h5>

                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="#!" class="text-reset">Terapia Psicológica</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Evaluaciones Psicológicas</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Asesoramiento</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Coaching</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                                    <h5 class="text-uppercase">Contacto</h5>

                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="#!" class="text-reset">Teléfono</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Email</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Dirección</a>
                                        </li>
                                        <li>
                                            <a href="#!" class="text-reset">Horario</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                        <!-- Section: Links  -->

                        <!-- Copyright -->
                        <div class="text-center p-4" style="background-color: rgb(255, 255, 255);">
                            © 2025 EMOCIÓN VITAL. Todos los derechos reservados.
                        </div>
                        <!-- Copyright -->
                    </footer>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
        <script src="/js/scripts.js"></script>
    </body>
</html>
