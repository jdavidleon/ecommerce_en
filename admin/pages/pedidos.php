<?php $web = true; ?>
<?php require '../../config/config.php'; ?>
<?php $titlePage = 'Pedidos'; ?>
<?php $pag = 'pedidos'; ?>
<?php require DIRECTORIO_ROOT.'admin/inc/header.php'; ?>

	
<?php $ordenes = Orders::orderList(); /*var_dump($ordenes);*/ ?>

	<div class="container">	
	    <!-- <div class="btn-group pull-right" style="margin-right: 30px;">
	      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdown <span class="caret"></span></button>
	      <ul class="dropdown-menu" role="menu">
	        <li><a href="#">Action</a></li>
	        <li><a href="#">Another action</a></li>
	        <li><a href="#">Something else here</a></li>
	        <li class="divider"></li>
	        <li><a href="#">Separated link</a></li>
	      </ul>
	    </div>
	    <div class="pull-right" style="margin-right: 1%;">
	      <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#addordenuct">
	      <i class="fa fa-plus-circle" aria-hidden="true"> Agregar ordenucto</i>
	      </button>
	    </div> -->
	</div>
	<a class="btn btn-danger pull-right btn-xs" style="margin-right: 37px" href="<?php echo ADMIN ?>pages/pedidos_eliminados.php">Ver pedidos eliminados</a>
	<br><br>
	<div class="container" style="margin-bottom: 200px;">
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
      		<thead>
        		<tr>
                   	<th>Nombre</th> 
                   	<th>Cupón</th> 
                   	<th>Precio</th>      
                   	<th style="padding-right: 0;">Estado</th>
                   	<th>Detalles</th>   
                </tr>   
		    </thead>
      		<tbody>   
      			<?php foreach ($ordenes as $orden): ?>      				
      			<?php 
      				switch ($orden['id_estado']) {
	                    case 1:
	                    case 9:
	                      $label = 'label-warning';
	                      $bg = 'bg-warning';
	                      break;
	                    case 2:
	                      $label = 'label-info';
	                      $bg = 'bg-info';
	                      break;
	                    case 3:
	                    case 4:
	                      $label = 'label-primary';
	                      $bg = 'bg-primary';
	                      break;
	                    case 5:
	                      $label = 'label-success';
	                      $bg = 'bg-success';
	                      break;
	                    case 6:
	                    case 7:
	                    case 8:
	                    case 10:
	                      $label = 'label-danger';
	                      $bg = 'bg-danger';
	                      break;
                  	}
      			 ?>
      				<tr>     
      					<td><?php echo $orden['nombre'].' ('.$orden['serial_venta'].')'; ?></td>      					
      					<td><?php echo $orden['clave_cupon']; ?></td>
      					
      					<td><?php echo $orden['precio_total']; ?></td>
      					<td>
      						<span style="font-size: 12px;" class="text-uppercase label <?php echo $label; ?>">
      							<?php echo $orden['estado_pedido']; ?>
      						</span>
      					</td>

      					<td>
      						<a class="btn btn-xs btn-success btn-block verOrdenBtn" onclick="cargarInfoOrden('<?php echo $orden['serial_venta']; ?>')" data-toggle="modal" data-target="#checkOrder" href="">Ver</a>
      						
      						<?php 
      							$estados = [5,6,7,8,10];
      						?>
      						<?php if (in_array($orden['id_estado'], $estados)): ?>
      							<form action="<?php echo ADMIN; ?>bd/pedidos/eliminar.php" method="POST">
      								<input type="hidden" name="empt_val">
      								<input type="hidden" name="id_venta_detalle" value="<?php echo $orden['id_venta_detalle'] ?>">
      								<input type="hidden" name="serial_venta" value="<?php echo $orden['serial_venta']; ?>">
      								<input type="submit" class="btn btn-xs btn-danger btn-block" value="ELIMINAR">
      							</form>
      						<?php endif ?>
      					</td>
			        </tr> 
      			<?php endforeach ?>
	      </tbody>
    </table>
	</div>





<?php include DIRECTORIO_ROOT.'admin/inc/footer.php'; ?>
