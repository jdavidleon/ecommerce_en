<?php $web = true; ?>
<?php require '../../config/config.php'; ?>
<?php $titlePage = 'Cupones'; ?>
<?php $pag = 'cupones'; ?>
<?php require DIRECTORIO_ROOT.'admin/inc/header.php'; ?>

	
	<div class="container">	
		<h3 class="text-center" style="">Listado de Cupones</h3>	
	</div>
	<br><br>
	<div class="container" style="margin-bottom: 200px;">
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
      		<thead>
        		<tr>
                  	<th>Cupón</th>
                   	<th class="text-center">Tipo Cupón</th>       
                   	<th>Estado</th>
                   	<th>Producto aplicable</th> 
                   	<th>% descuento</th>
                   	<th>Valor de descuento</th>      
                   	<th>Valor compra mínima</th>
                   	<th>Inicio</th>                         
                   	<th>Fin</th>
                   	<th># Cupones</th>  
                   	<th># Cupones Usados</th>
                   	<th># Cupones disponibles</th>
                   	<th># Max. por usuario</th>
                   	<th>Acción</th>
		        </tr>
		    </thead>
      		<tbody>  
      			<?php $listaCupones = new Coupon; ?>
      			<?php $cupones = Secure::decodeArray($listaCupones->all()); ?>

      			<?php $productos = Products::cargarProductos('*, productos.id_producto'); ?>      
      			<?php foreach ($cupones as $cupon): ?>
      				<tr class="text-center">     
      					<td><?php echo $cupon->clave_cupon; ?></td>
			            <td style="cursor: pointer;" title="<?php echo $cupon->descripcion_cupon; ?>">
			            	<?php echo $cupon->tipo_cupon; ?>
			            </td>
			            <?php 
			            	$estadoDef = false;
			            	if ($cupon->tm_delete !== null) {
			            		$estado = 'ELIMINADO';
			            		$estadoDef = true;
			            	}

			            	if (!$estadoDef) {
			            		if ($cupon->fecha_limite == null) {
			            			$estado = 'ACTIVO';
				            		$estadoDef = true;
			            		}else{
			            			$ahora = date('Y-m-d H:i:s');
				            		$inicio = $cupon->fecha_inicial;
				            		$fin = $cupon->fecha_limite;
				            		if ($ahora > $inicio AND $ahora < $fin) {
				            			$estado = 'ACTIVO';
				            			$estadoDef = true;
				            		}else{			            			
				            			$estado = 'VENCIDO';
				            			$estadoDef = true;
				            		}
			            		}
			            	}

			            	if (($cupon->cupones_disponibles - $cupon->cupones_usados) > 0) {
			            		$estado2 = 'DISPONIBLE';
			            	}else{
			            		$estado2 = 'AGOTADO';
			            	}
			            ?>

			            <td><?php echo $estado.' - '.$estado2; ?></td>
			            <td>
			            	<?php echo $cupon->id_producto == null  ? "N/A" : $cupon->serie.' - '.strtoupper($cupon->nombre_producto_es); ?>
			            </td>
			            <td>
			            	<?php echo $cupon->porcentaje == null ? 'N/A': $cupon->porcentaje.' %'; ?>
			            </td>
			            <td>
			            	<?php echo $cupon->valor_descontado == null ? 'N/A': $cupon->valor_descontado.' USD'; ?>
			            </td>
			            <td>
			           		<?php echo $cupon->valor_compra_minima == null ? 'N/A': $cupon->valor_compra_minima.' USD'; ?>
			            </td>
			            <td><?php echo $cupon->fecha_inicial; ?></td>
			            <td><?php echo $cupon->fecha_limite == null ? 'Tiempo Ilimitado' : $cupon->fecha_limite; ?></td>

			            <td><?php echo $cupon->cupones_disponibles; ?></td>
			            <td><?php echo $cupon->cupones_usados; ?></td>
			            <td><?php echo $cupon->cupones_disponibles - $cupon->cupones_usados; ?></td>
			            <td><?php echo $cupon->maximo_usuario; ?></td>
			            <td>
			            <?php if ($cupon->tm_delete == null): ?>
			            	<a href="<?php echo ADMIN.'/bd/productos/cupones/delete.php?clave_cupon='.$cupon->clave_cupon.'&empt_val='; ?>" class="btn btn-danger">Eliminar</a>
			            <?php endif ?>
			            </td>
			        </tr> 
      			<?php endforeach ?>
	      </tbody>
    </table>
	</div>





<?php include DIRECTORIO_ROOT.'admin/inc/footer.php'; ?>
