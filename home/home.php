<?php
session_start();
require '../utilities/check_session.php';
check_session();
require '../utilities/form_error_msg.php';
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' />
        <title>Sistema de registro perruno</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css' rel='stylesheet' />
        <link href='../styles/style_home.css' rel='stylesheet' />
    </head>
    <body>
        <?php
            require '../snippets/navbar.php';
            echo go_back(true, "");
        ?>

        <!-- Header-->
        <header class='py-5'>
            <div class='container px-lg-5'>
                <div class='p-4 p-lg-5 bg-light rounded-3 text-center'>
                    <div class='m-4 m-lg-5'>
                        <?php
                            $name = "visitante";
                            if (isset($_SESSION['name'])) {
                                $name = $_SESSION['name'];
                            }
                            echo "<h1 class='display-5 fw-bold'>¡Bienvenido {$name}! </h1>";
                        ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class='pt-4'>
            <div class='container px-lg-5'>
                <!-- Page Features-->
                <div class='row gx-lg-5'>
                    <?php
                    if ($_SESSION['user_type'] == 'admin'){
                        echo "<div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../admin/form_registrar_usuario.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-collection'></i></div>
                                        <h2 class='fs-4 fw-bold'>Registrar usuarios</h2>
                                        <p class='mb-0'>Crea cuentas para nuevos veterinarios</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../admin/form_eliminar_usuario.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-collection'></i></div>
                                        <h2 class='fs-4 fw-bold'>Eliminar usuarios</h2>
                                        <p class='mb-0'>Desactiva cuentas de veterinarios que ya no trabajan con nosotros</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../admin/form_crear_producto.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-collection'></i></div>
                                        <h2 class='fs-4 fw-bold'>Agregar producto</h2>
                                        <p class='mb-0'>Añade productos a la tienda</p>
                                    </div>
                                </a>
                            </div>
                        </div>";
                    }
                    
                    
                    if ($_SESSION['user_type'] == 'user'){
                        echo "<div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../pets/form_find_pet.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-collection'></i></div>
                                        <h2 class='fs-4 fw-bold'>Buscar mascotas</h2>
                                        <p class='mb-0'>Busca macotas por su nombre</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../pets/form_register_pet.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-life-preserver'></i></div>
                                        <h2 class='fs-4 fw-bold'>Registrar mascotas</h2>
                                        <p class='mb-0'>Ingresa una nueva mascota al sistema</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../pets/form_register_consultation.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-folder-fill'></i></div>
                                        <h2 class='fs-4 fw-bold'>Registrar consulta</h2>
                                        <p class='mb-0'>Registra una nueva consulta médica para una mascota</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-6 col-xxl-4 mb-5'>
                            <div class='card bg-light border-0 h-100'>
                                <a href='../clientes/form_register_client.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                    <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                        <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-person-bounding-box'></i></div>
                                        <h2 class='fs-4 fw-bold'>Registrar cliente</h2>
                                        <p class='mb-0'>Crea una cuenta al cliente para que pueda revisar las consultas de su mascota</p>
                                    </div>
                                </a>
                            </div>
                        </div>";
                    }
                    if ($_SESSION['user_type'] == 'user' or $_SESSION['user_type'] == 'client'){
                    echo "<div class='col-lg-6 col-xxl-4 mb-5'>
                        <div class='card bg-light border-0 h-100'>
                            <a href='../pets/form_find_consultation.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                    <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-search'></i></div>
                                    <h2 class='fs-4 fw-bold'>Buscar consulta</h2>
                                    <p class='mb-0'>Revisa los síntomas y diagnósticos de las mascotas</p>
                                </div>
                            </a>
                        </div>
                    </div>";
                    }

                    if ($_SESSION['user_type'] == 'client'){
                    echo "<div class='col-lg-6 col-xxl-4 mb-5'>
                        <div class='card bg-light border-0 h-100'>
                            <a href='../clientes/tienda_mascota.php' style='text-decoration: none; color:rgb(22, 22, 22)'>
                                <div class='card-body text-center p-4 p-lg-5 pt-0 pt-lg-0'>
                                    <div class='feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4'><i class='bi bi-bag'></i></div>
                                    <h2 class='fs-4 fw-bold'>Para tu mascota</h2>
                                    <p class='mb-0'>¡Compra los mejores productos para alimentar y jugar con tu mascota!</p>
                                </div>
                            </a>
                        </div>
                    </div>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </body>
</html>
