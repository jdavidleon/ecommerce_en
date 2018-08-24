<?php $pedidos = Orders::ordersClient($_SESSION['id_usuario']); ?>




<div class="w3l_banner_nav_right text-center">
	<div class="w3ls_w3l_banner_nav_right_grid">
		<div class="privacy">
    <h3 class="text-center logo-name">
    	Historial de Compras
    </h3>
    <br>
    <br>
    <br>
    <?php if (count($pedidos) === 0): ?>
    <ul>
    	<li class="media">
			<div class="media-body text-center text-uppercase">
				<i class="fa fa-5x fa-shopping-cart" aria-hidden="true" style="color: #d5dadc;"></i>
				<br>
				<br>
					No has hecho ninguna compra aún	    				
				<br>
				<br>
			</div>
		</li>
    </ul>
    <?php elseif(count($pedidos) > 0): ?>
    	<p>
    		<?php echo $secUser->order_prf1; ?>
    	</p>
		<div class="panel-group accordion-orders" id="accordion" role="tablist" aria-multiselectable="true" >
			<?php foreach ($pedidos as $pedido): ?>
			<?php $fecha = explode(' ', $pedido['fecha_venta']); ?>
			<div class="panel panel-default">
			    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $pedido['id_venta_detalle']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $pedido['id_venta_detalle']; ?>">


			    	<?php 
			    	switch ($pedido['id_estado']) {
	                    case 1:
	                    case 9:
	                      $label = 'badge-warning';
	                      $fa = 'fa-credit-card';
	                      break;
	                    case 2:
	                      $label = 'badge-info';
	                      $fa = 'fa-credit-card';
	                      break;
	                    case 3:
	                    case 4:
	                      $label = 'badge-primary';
	                      $fa = 'fa-truck';
	                      break;
	                    case 5:
	                      $label = 'badge-success';
	                      $fa = 'fa-check';
	                      break;
	                    case 6:
	                    case 7:
	                    case 8:
	                    case 10:
	                      $label = 'badge-danger';
	                      $fa = 'fa-times';
	                      break;
                  	}
                  	?>

				    <div class="panel-heading" role="tab" id="headingOne">
				     	<span>
				          	#<?php echo $pedido['serial_venta']; ?> 
				          	<span class="hidden-xs">(<?php echo $fecha[0]; ?>)</span>
				      	</span>
			      		<span class="badge <?php echo $label; ?> badge-icon pull-right">
	                      <i class="fa <?php echo $fa; ?>" aria-hidden="true"  style="color: white !important;"></i>
	                      <span class="hidden-xs"><?php echo $pedido['estado_'.$lang]; ?></span>
	                    </span>
	                    <span class=" pull-right">
	                    	<?php echo $pedido['precio_total']; ?> USD
	                    </span>

				    </div>
				</a>
			    <div id="collapse<?php echo $pedido['id_venta_detalle']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			      	<div class="panel-body">
			      	<?php 
						$where = 'ventas.serial_venta = ?';
						$params = ['s',$pedido['serial_venta']];
						$join = [
						['INNER','productos','productos.id_producto = ventas.id_producto'],
						['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = ventas.id_producto']
						];
						$detalles = CRUD::all('ventas','*',$where,$params,$join);
					 ?>
					    <div class="row">
						       	<div class="col-sm-12">
						       		<table class="table table-responsive table-accordion-detail">
						       			<thead class="text-center">
						       				<tr>
						       					<td colspan="2"><small><b>
						       					<?php echo $secUser->order_tb_product; ?>
						       					</b></small></td>
						       					<td><small><b>
						       					<?php echo $secUser->order_tb_quanity; ?>
						       					</b></small></td>
						       					<td><small><b>
						       					<?php echo $secUser->order_tb_price; ?>
						       					</b></small></td>
						       				</tr>
						       			</thead>
						       			<tbody>
					       				<?php foreach ($detalles as $prd): ?>
					       					<?php 
					       					$img = URL_BASE.'img_productos/'.$prd['serie'].'/thumbnail/'.$prd['ruta_img_tn'];
					       					?>
						       				<tr class="text-center">
						       					<td>
						       					<img src="<?php echo $img; ?>" width="80px" height="80px"></td>
						       					<td><?php echo $prd['nombre_producto_'.$lang]; ?></td>
						       					<td><?php echo $prd['cantidad']; ?></td>
						       					<td><?php echo $prd['precio_total_producto']; ?> USD</td>
						       				</tr>			       					
					       				<?php endforeach ?>
					       					<tr>
					       						<td colspan="4">
					       							<h5 class="text-center">
					       								<b>
											       		<?php echo $secUser->order_tb_address; ?>
											       		</b>
											       	</h5>
					       						</td>
					       					</tr>
					       					<tr>
					       						<td colspan="4" style="padding-top: 20px;">
									       				<address class="text-center">
													 		<strong>
													 			<?php echo $pedido['nombre_direccion'].' '.$pedido['apellido_direccion']; ?>
													 		</strong>
													 		<br>
													  		<?php echo $pedido['direccion']; ?>
													  		<br>
													 		<?php echo $pedido['nombre_estado']; ?>, 
													 		<?php echo $pedido['nombre_ciudad']; ?> 
													 		<?php echo $pedido['zip_code']; ?>
													 		<br>
													  		<span title="">
													  			Phone: 
													  		</span> 
													  		<?php echo $pedido['telefono']; ?>
													</address>
					       						</td>
					       					</tr>
						       			</tbody>
						       		</table>
						       </div>
					       </div>
					    </div>
				    </div>
				</div>
			<?php endforeach ?>
		</div>
	<?php endif ?>
</div>

		</div>
	</div>    
</div>
<div class="clearfix"></div>
<br><br><br>