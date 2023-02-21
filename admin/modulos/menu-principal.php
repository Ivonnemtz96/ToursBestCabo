<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
              <a href="/admin"> <img alt="LOGO" src="/logo.png" class="header-logo" style="height: 150px;" /></a>
            </div>
            <div style="margin-top: 50px;" class="sidebar-user">
                <div class="sidebar-user-picture">
                    <img alt="foto-perfil" src="<?php echo $fPerfil; ?>">
                </div>
                <div class="sidebar-user-details">
                    <div class="user-name"><?php echo ($UserData['nombre']);?></div>
                    <div class="user-role"><?php echo $rol; ?></div>
                    
                </div>
            </div>
          
            <ul class="sidebar-menu">
            <li class="menu-header">Panel de control</li>
            <li class="dropdown"><a href="/admin" class="nav-link"><i data-feather="monitor"></i><span>Resumen</span></a></li>
            
            
            <li class="menu-header active">Tours</li>
            <li class="dropdown"><a href="/admin/nuevo/tour" class="nav-link"><i data-feather="plus-square"></i><span>Nuevo Tour</span></a></li>
            <li class="dropdown"><a href="/admin/tours" class="nav-link"><i data-feather="layers"></i><span>Todos los tours</span></a></li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="corner-right-down"></i><span>Más</span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/nuevo/categoria-tour">Categorías</a></li>
                    <li><a href="/admin/nuevo/incluye-tour">Que incluye</a></li>
                    <li><a href="/admin/nuevo/rest-tour">Restricciones</a></li>
                    <li><a href="/admin/nuevo/reco-tour">Recomendaciones</a></li>
                </ul>
            </li>
                  
            <li class="menu-header active">Pedidos</li>
            <li class="dropdown"><a href="/admin/pedidos" class="nav-link"><i data-feather="file-minus"></i><span>Todos los pedidos</span></a></li>
            
            <li class="menu-header active">Configuracion</li>
            <li class="dropdown"><a href="/admin/msg-estado" class="nav-link"><i data-feather="alert-octagon"></i><span>Mensajes de status</span></a></li>
            <li class="dropdown"><a target="_blank" href="/" class="nav-link"><i data-feather="globe"></i><span>Ver sitio</span></a></li>
            
          </ul>
        </aside>
    </div>