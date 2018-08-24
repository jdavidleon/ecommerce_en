<?php $web = true; ?>
<?php require '../config/config.php'; ?>
<?php $titlePage = 'Administrador'; ?>
<?php $pag = 'panel'; ?>
<?php require DIRECTORIO_ROOT.'admin/inc/header.php'; ?>
<?php 
  
  /*Información usuarios*/
    $usuarios = CRUD::numRows('usuarios','*','tm_delete IS NULL',[]);

  /*Usuarios Nuevos esta semana*/     
    $date = date( "Y/m/d" );
    $estaSemana = date( "Y/m/d", strtotime( "-8 days", strtotime( $date ) ) ); 
    $where = 'tm_delete IS NULL AND fecha_registro > ?';
    $params = ['s',$estaSemana];
    $ultimosUsuarios = CRUD::numRows('usuarios','*',$where,$params);

  /*Productos Vendidos*/
    $hoyInicio =  date( "Y-m-d 00:00:00" );
    $hoyFin =  date( "Y-m-d 23:59:59" );
    $rows = 'SUM(precio_productos) as suma';
    $where = 'fecha_venta BETWEEN ? AND ? AND id_estado IN ( 3, 4, 5 )';
    $params = ['ss',$hoyInicio,$hoyFin];
    $ventasHoy = CRUD::all('venta_detalle',$rows, $where,$params);
    $ventasDia = number_format($ventasHoy[0]['suma'],0,'.',',');

  /*Productos Vendidos este mes*/
    $mes_actual = date('m');
    $ano_actual = date('Y');
    $dia_uno = $ano_actual.'/'.$mes_actual.'/'.'1';
    $rows = 'SUM(precio_productos) as suma';
    $where = 'fecha_venta >= ? AND id_estado IN ( 3, 4, 5 )';
    $params = ['s',$dia_uno];
    $ventasMensual = CRUD::all('venta_detalle',$rows,$where,$params);
    $ventasMes = number_format($ventasMensual[0]['suma'],0,'.',',');
  
  /*Pedidos Activos*/
    $where = 'id_estado IN ( 1, 2, 3, 4, 9 )';
    $pedidosActivos = CRUD::numRows('venta_detalle','*',$where);
    
  /*Pedidos para envio*/
    $where = 'id_estado IN ( 2, 3 )';
    $pedidosAlerta = CRUD::numRows('venta_detalle','*',$where);

 ?>


<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <a class="card card-banner card-green-light">
  <div class="card-body">
    <i class="icon fa fa-money fa-4x"></i>
    <div class="content">
      <div class="title">Ventas Hoy</div>
      <div class="value" style="font-size: 60px;"><span class="sign" style="font-size: 30px;">$</span><?php echo $ventasDia; ?></div>
      <div style="color: black;"><span >$ </span><?php echo $ventasMes; ?> este mes </div>
    </div>
  </div>
</a>

  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <a class="card card-banner card-blue-light">
  <div class="card-body">
    <i class="icon fa fa-shopping-basket fa-4x"></i>
    <div class="content">
      <div class="title">Pedidos Activos</div>
      <div class="value"><span class="sign"></span><?php echo $pedidosActivos; ?></div>
      <div style="color: black;"><?php echo $pedidosAlerta; ?> Requiren Revisión o envío. </div>
    </div>
  </div>
</a>

  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <a class="card card-banner card-yellow-light">
  <div class="card-body">
    <i class="icon fa fa-user-plus fa-4x"></i>
    <div class="content">
      <div class="title">Usuarios</div>
      <div class="value"><span class="sign"></span><?php echo $usuarios; ?></div>
      <div style="color: black;"><?php echo $ultimosUsuarios; ?> nuevos esta semana </div>
    </div>
  </div>
</a>

  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Estado de pedidos</div>
        <ul class="card-action">
          <li>
            <a href="<?php echo URL_BASE; ?>admin/">
              <i class="fa fa-refresh"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th>Estado</th>
              <th class="right">Cantidad</th>
            </tr>
          </thead>
          <tbody>

            <?php $estados= CRUD::all('estados_pedido'); ?>
            <?php foreach ($estados as $estado): ?>
                <?php 

                  $cantidad = CRUD::numRows('venta_detalle','*','id_estado = ?',['i',$estado['id_estado']]);

                  switch ($estado['id_estado']) {
                    case 1:
                      $badge = 'badge-warning';
                      $icon = 'fa-clock-o';
                      break;
                    case 2:
                      $badge = 'badge-info';
                      $icon = 'fa-credit-card';
                      break;
                    case 3:
                      $badge = 'badge-primary';
                      $icon = 'fa-archive';
                      break;
                    case 4:
                      $badge = 'badge-primary';
                      $icon = 'fa-truck';
                      break;
                    case 5:
                      $badge = 'badge-success';
                      $icon = 'fa-check';
                      break;
                    case 6:
                      $badge = 'badge-danger';
                      $icon = 'fa-times';
                      break;
                    case 7:
                      $badge = 'badge-danger';
                      $icon = 'fa-truck';
                      break;
                    case 8:
                      $badge = 'badge-danger';
                      $icon = 'fa-credit-card';
                      break;
                    case 9:
                      $badge = 'badge-warning';
                      $icon = 'fa-credit-card';
                      break;
                    case 10:
                      $badge = 'badge-danger';
                      $icon = 'fa-credit-card';
                      break;  
                  } 
                ?>
                <tr>
                  <td>
                    <span class="badge <?php echo $badge; ?> badge-icon">
                      <i class="fa <?php echo $icon; ?>" aria-hidden="true"></i>
                      <span><?php echo $estado['estado_pedido']; ?></span>
                    </span>
                  </td>
                <td class="right"><?php echo $cantidad; ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-tab card-mini">
      <div class="card-header" style="overflow: hidden;">
        <ul class="nav nav-tabs tab-stats">
          <li role="tab1" class="active" style="width: 280px;">
            <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Productos más Vendidos</a>
          </li>
          <!-- <li role="tab2">
            <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">OS</a>
          </li>
          <li role="tab2">
            <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">More</a>
          </li> -->
        </ul>
      </div>

      <?php 
        $order = 'productos_cantidad.cantidad_salida DESC';
        $masVendidos = Products::cargarProductos('*, productos.id_producto',null,[],$order,8);
        $con = 1;
        // exit();
       ?>

      <input type="hidden" id="cantidadChart" value="<?php echo count($masVendidos); ?>">
      <div class="card-body tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab1">
          <div class="row">
            <div class="col-sm-8">
              <div class="chart ct-chart-browser ct-perfect-fourth"></div>
            </div>
            <div class="col-sm-4">
              <ul class="chart-label">
                <?php $letter = 'a'; ?>
                <?php foreach ($masVendidos as $prod): ?>
                    <input type="hidden"  id="producto<?php echo $con;?>" value="<?php echo $prod['cantidad_salida']; ?>">
                    <li class="ct-label ct-series-<?php echo $letter; ?>"><?php echo $prod['nombre_producto']; ?></li>
                <?php $letter++; $con++; endforeach ?>
              </ul>
            </div>
          </div>
        </div>
        <!-- <div role="tabpanel" class="tab-pane" id="tab2">
          <div class="row">
            <div class="col-sm-8">
              <div class="chart ct-chart-os ct-perfect-fourth"></div>
            </div>
            <div class="col-sm-4">
              <ul class="chart-label">
                <li class="ct-label ct-series-a">iOS</li>
                <li class="ct-label ct-series-b">Android</li>
                <li class="ct-label ct-series-c">Windows</li>
                <li class="ct-label ct-series-d">OSX</li>
                <li class="ct-label ct-series-e">Linux</li>
              </ul>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tab3">
        </div> -->
      </div>
    </div>
  </div>
</div>

<?php include 'inc/footer.php'; ?>