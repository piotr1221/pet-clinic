<?php
function go_back($home, $back){
    $result = "";
    $result .= "<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
        <div class='container px-lg-5'>";

            if (!$home){
                $class = "navbar-brand";
                $result .= "<a href={$back} class='btn {$class}'>Regresar</a>";
            }
    
    $result .= "<a class='navbar-brand' href='#!'>Sistema de Registro Perruno</a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav ms-auto mb-2 mb-lg-0'>
                    <li class='nav-item'><a class='nav-link active' aria-current='page' href='../home/home.php'>Home</a></li>
                    <li class='nav-item'><a class='nav-link active' href='../home/form_change_password.php'>Cuenta</a></li>
                    <li class='nav-item'><a class='nav-link active' href='../logout.php'>Cerrar sesion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
    <script src='js/scripts.js'></script>";

    return $result;
}

?>
