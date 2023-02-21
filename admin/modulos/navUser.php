<nav class="navbar navbar-expand-lg main-navbar sticky">
            <div class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="menu"></i></a></li>
                </ul>
            </div>
            <ul class="navbar-nav navbar-right">
                <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"><i data-feather="maximize"></i></a></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="<?php echo $fPerfil; ?>" class="user-img-radious-style">
                        <span class="d-sm-none d-lg-inline-block"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pullDown">
                        <div class="dropdown-title">Hola <?php echo ($UserData['nombre']);?></div>
                        <a href="/admin/perfil" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil </a>
                        <a href="/cerrar" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>Salir </a>
                    </div>
                </li>
            </ul>
        </nav>