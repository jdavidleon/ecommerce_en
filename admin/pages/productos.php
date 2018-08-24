<?php $web = true; ?>
<?php require '../../config/config.php'; ?>
<?php $titlePage = 'Productos'; ?>
<?php $pag = 'productos'; ?>
<?php require DIRECTORIO_ROOT.'admin/inc/header.php'; ?>
	
	<div class="container">	
		<h3 class="text-center" style="">Listado de Productos</h3>	
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
	      <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#addProduct">
	      <i class="fa fa-plus-circle" aria-hidden="true"> Agregar Producto</i>
	      </button>
	    </div> -->
	</div>
	<br><br>
	<div class="container" style="margin-bottom: 200px;">
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
      		<thead>
        		<tr>
                  	<th>Serie</th>
                   	<th>Publicado</th>       
                   	<th>Nombre</th> 
                   	<th>Vendidos</th>
                   	<th>Disponibles</th>      
                   	<th>Precio</th>
                   	<th>Comision PayU</th>                         
                   	<th>Categoria</th>
                   	<th>Sub-categoria</th>  
                   	<th>Bolsa</th>
                   	<th>Acciones</th>
		        </tr>
		    </thead>
      		<tbody>  
      			<?php $productos = Products::cargarProductos('*, productos.id_producto, categorias.id_categoria','productos.tm_delete IS NULL'); ?>      
      			<?php foreach ($productos as $prod): ?>
      				<?php 
      					// var_dump($prod);
      					$bolsa = CRUD::numRows('bolsa_compras','*','id_producto = ?',['i',$prod['id_producto']]);
      				?>
      				<?php $comision = 0; ?>
      				<tr>     
      					<td><?php echo $prod['serie']; ?></td>
			            <td>
			            	<input style="margin: 0 auto;" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger"  id="publicacion" class="publicacion" name="publicacion" data-size="mini" <?php echo 'value="'.$prod['id_producto'].'"'; ?> <?php if ($prod['estado_publicado'] == 'SI'): ?>
                                checked
                            <?php endif ?>>
			            	<input type="checkbox" data-toggle="toggle" data-on="STOCK " data-off="SOLDOUT" data-onstyle="success" data-offstyle="danger"  id="soldout" class="soldout" name="soldout" data-size="mini" <?php echo 'value="'.$prod['id_producto'].'"'; ?> <?php if ($prod['estado_agotado'] === 'NO' || $prod['estado_agotado'] == null): ?>
                                checked
                            <?php endif ?>>
                        </td>
			            <td><?php echo $prod['nombre_producto']; ?></td>
			            <td><?php echo $prod['cantidad_salida']; ?></td>
			            <td><?php echo $prod['cantidad_entrada'] - $prod['cantidad_salida']; ?></td>
			            <td>
			            	<?php if ($prod['descuentoPorProducto'] === 0): ?>
			            		<?php echo $prod['precio']; ?>
			            	<?php else: ?>
			            		<?php echo $prod['precio']; ?> 
			            		<br>
			            		<strike><?php echo $prod['precioAntesDescuento']; ?></strike>
			            	<?php endif ?>
						</td>
			            <td><?php echo $comision; ?></td>
			            <td><?php echo $prod['categoria']; ?></td>
			            <td><?php echo $prod['sub-categoria']; ?></td>
			            <td><?php echo $bolsa; ?></td>
			            <td>
			            	<a href="" onclick="cargarInfoProducto(<?php echo $prod['id_producto']; ?>)" data-toggle="modal" data-target="#checkProduct" class="verProductoBtn btn btn-success btn-xs">
			            		EDITAR
			            	</a>
			            	<a class="btn btn-warning btn-xs" href="<?php echo ADMIN; ?>pages/detalle_producto.php?id_producto=<?php echo $prod['id_producto']; ?>">Ver</a>
			            	<a class="btn btn-danger btn-xs" href="<?php echo ADMIN.'bd/productos/delete.php?id_producto='.$prod['id_producto']; ?>">ELIMINAR</a>
			            </td>
			        </tr> 
      			<?php endforeach ?>
	      </tbody>
    </table>
	</div>





<?php include DIRECTORIO_ROOT.'admin/inc/footer.php'; ?>
