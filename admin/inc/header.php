<?php 
	spl_autoload_register( function ($nombre_clase) {
		include DIRECTORIO_ROOT.'class/class.'.$nombre_clase.".php";
	});

	$admin = new Admin;
	$administrador = $admin->adminData;
  
	Login::validarPermisos();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Administrador | ENNAVIDAD.COM</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo URL_BASE; ?>images/favicon/favicon.png" />

  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/theme/yellow.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>assets/css/animate.css">
  <!-- Datatables -->
  <link href="<?php echo URL_BASE; ?>admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo URL_BASE; ?>admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo URL_BASE; ?>admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo URL_BASE; ?>admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>assets/css/custom.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>admin/assets/css/custom.css">

</head>

  <?php require DIRECTORIO_ROOT.'admin/inc/float/modals.php'; ?>
  <?php require DIRECTORIO_ROOT.'admin/inc/float/alerts.php'; ?>

<body>
  <input type="hidden" id="urlBase" value="<?php echo URL_BASE; ?>">
  <div class="app app-default">

<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="#"><span class="highlight">Admin v1</span> </a>
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <div class="sidebar-menu" style="min-height: 630px;">
    <ul class="sidebar-nav">
      <li class="<?php if ($pag == 'panel'): ?>
          <?php echo 'active'; ?>
      <?php endif ?>">
        <a href="<?php echo URL_BASE.'admin/' ?>">
          <div class="icon">
            <i class="fa fa-tasks" aria-hidden="true"></i>
          </div>
          <div class="title">Panel</div>
        </a>
      </li>
      <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-truck" aria-hidden="true"></i>
          </div>
          <div class="title">Pedidos</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> UI Kits</li>
            <li><a href="./uikits/customize.html">Customize</a></li>
            <li><a href="./uikits/components.html">Components</a></li>
            <li><a href="./uikits/card.html">Card</a></li>
            <li><a href="./uikits/form.html">Form</a></li>
            <li><a href="./uikits/table.html">Table</a></li>
            <li><a href="./uikits/icons.html">Icons</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Advanced Components</li>
            <li><a href="./uikits/pricing-table.html">Pricing Table</a></li>
            <li><a href="./uikits/timeline.html">Timeline</a></li> -->
            <!-- <li><a href="./uikits/chart.html">Chart</a></li>
          </ul>
        </div>
      </li> -->
      <li class="<?php if ($pag == 'pedidos'): ?>
          <?php echo 'active'; ?>
      <?php endif ?>">
        <a href="<?php echo URL_BASE.'admin/pages/pedidos.php' ?>">
          <div class="icon">
            <i class="fa fa-truck" aria-hidden="true"></i>
          </div>
          <div class="title">Pedidos</div>
        </a>
      </li>
      <li class="<?php if ($pag == 'productos'): ?>
          <?php echo 'active'; ?>
      <?php endif ?>">
        <a href="<?php echo URL_BASE.'admin/pages/productos.php' ?>">
          <div class="icon">
            <i class="fa fa-cube" aria-hidden="true"></i>
          </div>
          <div class="title">Productos</div>
        </a>
      </li>
      <li class="<?php if ($pag == 'cupones'): ?>
          <?php echo 'active'; ?>
      <?php endif ?>">
        <a href="<?php echo URL_BASE.'admin/pages/cupones.php' ?>">
          <div class="icon">
            <i class="fa fa-gift" aria-hidden="true"></i>
          </div>
          <div class="title">Cupones</div>
        </a>
      </li>
      <li class="<?php if ($pag == 'usuarios'): ?>
          <?php echo 'active'; ?>
      <?php endif ?>">
        <a href="<?php echo URL_BASE.'admin/pages/usuarios.php' ?>">
          <div class="icon">
            <i class="fa fa-user-o" aria-hidden="true"></i>
          </div>
          <div class="title">Usuarios</div>
        </a>
        <!-- <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Admin</li>
            <li><a href="./pages/form.html">Form</a></li>
            <li><a href="./pages/profile.html">Profile</a></li>
            <li><a href="./pages/search.html">Search</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Landing</li>
            <li><a href="./pages/landing.html">Landing</a></li>
            <li><a href="./pages/login.html">Login</a></li>
            <li><a href="./pages/register.html">Register</a></li>
            <li><a href="./pages/404.html">404</a></li>
          </ul>
        </div> -->
      </li>
    </ul>
  </div>
  <div class="sidebar-footer">
    <ul class="menu" style="background-color: #29C75F;">
      <li >
        <a  href="<?php echo URL_BASE; ?>" target="_blank">
          <i class="fa fa-cogs" aria-hidden="true" style="color: white;"> Ir a la tienda</i>
        </a>
      </li>
      <li><a href="#" style="display: none;"><span class="flag-icon flag-icon-th flag-icon-squared"></span></a></li>
    </ul>
  </div>
</aside>


<script type="text/ng-template" id="sidebar-dropdown.tpl.html">
  <div class="dropdown-background">
    <div class="bg"></div>
  </div>
  <div class="dropdown-container">
    {{list}}
  </div>
</script>
<div class="app-container" style="padding-top: 0;">

  <nav class="navbar navbar-default" id="navbar" style="">
  <div class="container-fluid" style="">
    <div class="navbar-collapse collapse in" style="overflow: hidden;">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="#"><span class="highlight">MIFU v1</span> Admin</a>
        </li>
        <li>
          <button type="button" class="navbar-toggle">
            <img class="profile-img" src="<?php echo URL_BASE; ?>admin/assets/images/profile.png">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title"><?php echo $titlePage; ?></li>
        <!-- <li class="navbar-search hidden-sm">
          <input id="search" type="text" placeholder="Search..">
          <button class="btn-search"><i class="fa fa-search"></i></button>
        </li> -->
      </ul>
      <?php $numeroPedidos = CRUD::numRows('venta_detalle','*','id_estado IN (2,3)'); ?>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown notification">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
            <div class="title">Nuevos Pedidos</div>
            <div class="count"><?php echo $numeroPedidos; ?></div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Pedidos</li>
              <?php if ($numeroPedidos == 0): ?>
                <li class="dropdown-empty">Sin nuevos pedidos</li>
              <?php else: ?>
                <?php 
                  $where = 'venta_detalle.id_estado IN (2,3)';
                  $order = 'venta_detalle.fecha_venta DESC';
                ?>
              <?php $pedidos = Orders::orderList($where,[],'*',$order,6); ?>
              <?php foreach ($pedidos as $pedido): ?>
              <?php $cantidadPedido = count(Orders::orderDetail($pedido['serial_venta'])); ?>
                <li>
                  <a href="#" class="verOrdenBtn" data-toggle="modal" data-target="#checkOrder" onclick="cargarInfoOrden('<?php echo $pedido['serial_venta']; ?>')"">
                    <span class="badge badge-warning pull-right">
                      <?php echo $cantidadPedido; ?>
                    </span>
                    <div class="message">
                      <img class="profile" src="https://placehold.it/100x100">
                      <div class="content">
                        <div class="title">"<?php echo $pedido['estado_es']; ?>"</div>
                        <div class="description"><?php echo $pedido['nombre']; ?></div>
                      </div>
                    </div>
                  </a>
                </li>
              <?php endforeach ?>               
              <?php endif ?>          
              
              <li class="dropdown-footer">
                <a href="<?php echo URL_BASE.'admin/pages/pedidos.php'; ?>">Ver Todos <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown notification warning hide">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
            <div class="title">Unread Messages</div>
            <div class="count">99</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Message</li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">10</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Payment Confirmation.."</div>
                      <div class="description">Alan Anderson</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">5</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Hello World"</div>
                      <div class="description">Marco  Harmon</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">2</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Order Confirmation.."</div>
                      <div class="description">Brenda Lawson</div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <?php 
            $where = '(cantidad_entrada - cantidad_salida) = ?';
            $params = ['i',0];
            $alerta = CRUD::all('productos_cantidad','id_producto',$where,$params,null,null,7);
        ?>
        <li class="dropdown notification danger">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
            <div class="title">Notificaciones del sistema</div>
            <div class="count"><?php echo count($alerta); ?></div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Notification</li>
              <?php if (count($alerta) == 0): ?>
                <li class="dropdown-empty">Sin Notificaciones</li>
              <?php endif ?>
              <?php foreach ($alerta as $alert): ?>
                <?php $producto = CRUD::all('productos','*','id_producto = ?',['i',$alert['id_producto']]); ?>
                <li>
                  <a href="#">
                    <span class="badge badge-danger pull-right">0</span>
                    <div class="message">
                      <div class="content">
                        <div class="title"><?php echo $producto[0]['nombre_producto_es']; ?></div>
                        <div class="description text-danger">AGOTADO</div>
                      </div>
                    </div>
                  </a>
                </li>
              <?php endforeach ?>
              <li class="dropdown-footer">
                <a href="<?php echo URL_BASE.'admin/pages/productos.php'; ?>">Ver todo <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown profile">
          <a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown" style="padding: 15px !important;">
            <img class="profile-img" src="<?php echo URL_BASE; ?>admin/assets/images/profile.png">
            <div class="title">Perfil</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username text-capitalize"><?php echo strtolower($_SESSION['user']); ?></h4>
            </div>
            <ul class="action">
              <!-- <li>
                <a href="#">
                  Profile
                </a>
              </li> -->
              <!-- <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">5</span>
                  My Inbox
                </a>
              </li> -->
              <li>
                <a href="#">
                  Configuración
                </a>
              </li>
              <li>
                <a href="<?php echo URL_BASE.'bd/users/logout.php?csrf='.$_SESSION['csrf_token']; ?>">
                  Salir
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="btn-floating" id="help-actions">
  <div class="btn-bg"></div>
  <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
    <i class="icon fa fa-plus"></i>
    <span class="help-text">Agregar</span>
  </button>
  <div class="toggle-content">
    <ul class="actions">
      <li>
        <a href="#" data-toggle="modal" data-target="#addProduct">
          Nuevo Producto
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#discountProduct">
          Nuevo Descuento
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#addCaracteristic">
          Nueva Característica
        </a>
      </li>
      <li class="hide">
        <a href="#" data-toggle="modal" data-target="#addOrder">
          Nuevo Pedido
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#addUser">
          Nuevo Usuario
        </a>
      </li>
      <li class="hide">
        <a href="#" data-toggle="modal" data-target="#addCoupon">
          Agregar cupón
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#addItemProduct">
          Nuevo Item de producto
        </a>
      </li>
      <li>
        <a href="#" data-toggle="modal" data-target="#addTestimonial">
          Agregar testimonio
        </a>
      </li>
    </ul>
  </div>
</div>