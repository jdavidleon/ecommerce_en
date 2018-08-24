<?php $productos = CRUD::all('productos','*','tm_delete IS NULL'); ?>

<!-- ADD PRODUCT -->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Agregar Producto</h4>
            </div>
            <div class="modal-body">
            
          <form role="form" method="post" action="<?php echo URL_BASE.'admin/bd/productos/nuevo.php'; ?>" enctype="multipart/form-data">
              
            <?php include DIRECTORIO_ROOT.'admin/inc/form/producto.php'; ?>

            <div class="form-group">
              <label for="cantidad_entrada">Cantidad</label>
              <input type="number" class="form-control" name="cantidad_entrada" id="cantidad_entrada" placeholder="Cantidad" min="1" value="1">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Imagenes</label>
              <input type="file" class="btn" id="img_lg" name="img_lg[]" multiple>
            </div>
            <div class="form-group text-center">
              <label for="publicacion">Publicar </label>
              <input style="width: 80px;" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI" name="publicacion" id="publicacion">
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-success pull-right" style="margin: 0 10px;">Guardar</button>
            <button type="button" class="btn btn-sm pull-right" data-dismiss="modal">Cerrar</button>
          </form><br><br>
        </div>
      </div>
      </div>
</div>
<!-- END ADD PRODUCT -->

<!-- DISCOUNT PRODUCT -->
<div class="modal fade" id="discountProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Descuento a Producto</h4>
            </div>
            <div class="modal-body">
            
          <form role="form" method="post" action="<?php echo URL_BASE.'admin/bd/productos/descuento/new.php'; ?>" enctype="multipart/form-data">
              
            <label> Producto</label>
            <select class="form-control text-capitalized" id="product_discount" name="id_producto" required>

              <option></option>
              <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id_producto']; ?>">
                  <?php echo ucfirst($producto['nombre_producto']); ?>
                </option>
              <?php endforeach ?>

            </select>
            <br>
            <div class="text-center" id="precioProducto"></div>
            <br>
            <div class="form-group">
              <label for="cantidad_entrada">Porcentaje</label>
              <input type="number" class="form-control" name="porcentaje" id="porcentaje_descuento" placeholder="%" min="1" max="100" required>
            </div>

            <div class="form-group">
              <label for="cantidad_entrada">Valor a descontar</label>
              <input type="number" class="form-control" name="valor_descontado" id="valor_descontado" placeholder="Valor Descontado" min="1" required>
            </div>

            <div class="form-group">
              <label for="cantidad_entrada">Fecha inicial</label>
              <input type="date" class="form-control" name="fecha_inicial_dia" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
              <label for="cantidad_entrada">Hora inicial</label>
              <input type="time" class="form-control" name="fecha_inicial_hora" value="00:00" required>
            </div>

            <div class="form-group">
              <label for="cantidad_entrada">Fecha Final</label>
              <input type="date" class="form-control" name="fecha_final_dia" value="" required>
            </div>

            <div class="form-group">
              <label for="cantidad_entrada">Hora Final</label>
              <input type="time" class="form-control" name="fecha_final_hora" value="23:59" required>
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-success pull-right" style="margin: 0 10px;">
              Guardar
            </button>
            <button type="button" class="btn btn-sm pull-right" data-dismiss="modal">Cerrar</button>
          </form><br><br>
        </div>
      </div>
      </div>
</div>
<!-- END DISCOUNT PRODUCT -->


<!-- ADD USER -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Nuevo usuario</h4>
            </div>
            <div class="modal-body">
              <form action="<?php echo URL_BASE.'admin/bd/usuarios/save/nuevo.php' ?>" method="POST" role="form">
                <?php include DIRECTORIO_ROOT.'admin/inc/form/usuario.php'; ?>
                <br>
                <button type="submit" class="btn btn-sm btn-success pull-right" style="margin: 0 10px;">Guardar</button>
                <button type="button" class="btn btn-sm pull-right" data-dismiss="modal">Cerrar</button>
              </form>
            </div>
            <br>
        </div>
      </div>
</div>
<!-- END ADD USER -->

<!-- EDIT USER -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Usuario</h4>
            </div>
            <div class="modal-body" id="dataEditUser">
            </div>
            <br>
            
        </div>
      </div>
</div>
<!-- END EDIT USER -->

<!-- ADD ORDER -->
<div class="modal fade" id="addOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Nuevo usuario</h4>
            </div>
            <div class="modal-body">
            </div>
            <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-sm btn-success">Guardar</button>
            </div>
        </div>
      </div>
</div>
<!-- END ADD ORDER -->

<!-- ADD ITEM PRODUCT -->
<div class="modal fade" id="addItemProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">ITEMS DE PRODUCTO</h4>
            </div><br>
              <h4 class="text-center">Asignar Item a Producto</h4>
              <div class="modal-body">  
                <label> Producto</label>
                <select class="form-control text-capitalized" id="product_to_item" name="id_producto" required>

                  <option></option>
                  <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto['id_producto']; ?>">
                      <?php echo ucfirst($producto['nombre_producto']); ?>
                    </option>
                  <?php endforeach ?>

                </select>
                <br>
              <div class="row">
                <div class="col-sm-12" id="container_list_items"></div>
              </div> 
              <hr>

              <!-- AGREGAR NUEVO ITEM -->
              <h4 class="text-center">Agregar nuevo Item</h4>
            <form role="form" id="agregarItems" action="<?php echo URL_BASE.'admin/bd/productos/items/new.php' ?>" method="POST">
              
              <div class="form-group">  
                <label> Item (Español)</label>           
                <input type="list" name="item_es" class="form-control" required list="datalist_item_product" required>
                <datalist id="datalist_item_product">         
                </datalist>
              </div>
              <div class="form-group">  
                <label> Item (Inglés)</label>              
                <input type="list" name="item_en" class="form-control" required list="datalist_item_product_en" required>
                <datalist id="datalist_item_product_en">         
                </datalist>
              </div>
              <div class="form-group">  
                <label> Tipo </label>
                <?php 
                  $where = 'tm_delete IS NULL';
                  $tipos = CRUD::all('productos_items_tipos','*',$where);
                ?>
                <select class="form-control" name="id_tipo_item" required>
                  <option></option>
                  <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo $tipo['id_tipo_item']; ?>">
                      <?php echo $tipo['tipo_item']; ?>
                    </option>
                  <?php endforeach ?>
                </select>  
              </div>
              <input type="submit" class="btn btn-success pull-right" value="Añadir">
              <br>
            </form>
            <!-- #AGREGAR NUEVO ITEM -->

            </div>
            <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
      </div>
</div>
<!-- END ADD ITEM PRODUCT -->

<!-- ADD CATACTERISTIC -->
<div class="modal fade" id="addCaracteristic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header bg-success" style="background-color: #449D44; color: white;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title text-center text-uppercase">Agregar característica</h4>
          	</div>
          	<div class="modal-body">
              <div class="form-group">
                <label for="selectForm">Selecciona una opción</label>
                <select class="form-control" id="selectForm" onchange="cargarForm()">
                  <option disabled selected>Selecciona</option>
                  <optgroup label="Aumentar Stock">
                    <option value="num">Ingreso de productos</option>
                  </optgroup>
                  <optgroup label="Categorias">
                    <option value="cat">Categoria</option>
                    <option value="sub">Sub-categoria</option>
                  </optgroup>
                  <optgroup label="Cupones">
                    <option value="basico">Cupón básico</option>
                    <option value="minima">Cupón compra mínima</option>
                    <option value="producto">Cupón por producto</option>
                  </optgroup>


                  
                  
                  

                </select>
              </div>

              <!-- CANTIDAD -->
                <form action="<?php echo URL_BASE.'admin/bd/caracteristicas/cantidad_productos.php'; ?>" method="POST" class="hide carac-form" id="cantidadForm">
                  <input type="hidden" name="empt_val">
                  <div class="form-group">
                    <label for="id_producto">Selecciona un producto</label>
                    <select class="form-control" name="id_producto" id="id_producto">
                      <option disabled selected>Producto</option>
                      
                      <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['id_producto']; ?>"><?php echo $producto['nombre_producto']; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="cantidad_entrada">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad_entrada" id="cantidad_entrada" value="1" min="1">
                  </div>
                  
                  <input type="submit" value="Guardar" class="btn btn-success btn-md">
                </form>
              <!-- CANTIDAD -->

              <!-- CATEGORIA -->
                <form action="<?php echo URL_BASE.'admin/bd/caracteristicas/agregar_categoria.php'; ?>" method="POST" class="hide carac-form" id="catForm">
                  <input type="hidden" name="empt_val">
                  <div class="form-group">
                    <label for="categoria">Categoria (Español)</label>
                    <input type="text" class="form-control" placeholder="Categoria (Español)" name="categoria" id="categoria">
                  </div>
                  <div class="form-group">
                    <label for="categoria">Categoria (Inglés)</label>
                    <input type="text" class="form-control" placeholder="Categoria (Inglés)" name="categoria">                    
                  </div>
                  <div class="form-group">
                    <label for="identificador">Asigna un Identificador</label>                    
                    <input type="text" class="form-control" placeholder="Identificador" name="identificador" id="identificador">
                  </div>
                  <input type="submit" value="Guardar" class="btn btn-success">
                </form>
              <!-- CATEGORIA -->

              <!-- SUB-CATEGORIA -->
                <form action="<?php echo URL_BASE.'admin/bd/caracteristicas/agregar_sub_categoria.php'; ?>" method="POST" class="hide carac-form" id="subCatForm">
                  <input type="hidden" name="empt_val">
                  <div class="form-group">
                    <label for="id_categoria">Selecciona Categoria</label>   
                    <select class="form-control" name="id_categoria" id="id_categoria">
                      <option disabled selected>Categoria</option>
                      <?php $categorias = CRUD::all('categorias'); ?>
                      <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['categoria'].' - '.$categoria['categoria']; ?></option>
                      <?php endforeach ?>
                    </select>                             
                  </div>
                  <div class="form-group">
                    <label for="nombre_sub_categoria">Nombre Sub-categoria (Español)</label>
                    <input type="text" class="form-control" name="nombre_sub_categoria" id="nombre_sub_categoria" placeholder="Sub-categoria (Español)">
                  </div>                  
                  <div class="form-group">
                    <label for="nombre_sub_categoria">Nombre Sub-categoria (Español)</label>
                    <input type="text" class="form-control" name="nombre_sub_categoria" placeholder="Sub-categoria (Inglés)" id="nombre_sub_categoria">
                  </div>
                  <input type="submit" value="Guardar" class="btn btn-success">
                </form>
              <!-- SUB-CATEGORIA -->

              <!-- CUPON BASICO -->
                <form action="<?php echo URL_BASE.'admin/bd/productos/cupones/create.php'; ?>" method="POST" class="hide carac-form" id="cuponBasico">
                  <input type="hidden" name="empt_val">
                  <input type="hidden" name="id_tipo_cupon" value="1">

                  <p>Aplica porcentaje de descuento para cualquier tipo de compra sin importar producto o valor de la compra.</p>

                  <div class="form-group">
                    <label for="clave_cupon">Cupón</label>
                    <input type="text" class="form-control" placeholder="" name="clave_cupon" id="clave_cupon" required>
                  </div>

                  <div class="form-group">
                    <label for="metodoDescuento">Método de descuento</label>   
                    <select class="form-control" id="metodoDescuento" onchange="showMethod()" required>
                      <option></option>
                      <option value="porcentaje">Porcentaje de la compra</option>
                      <option value="valor">Valor exacto</option>
                    </select>                             
                  </div>

                  <div class="form-group hide input-methods" id="input_porcentaje">
                    <label for="porcentaje">% descontado</label>
                    <input type="number" min="1" max="100" class="form-control" placeholder="%" name="porcentaje" id="porcentaje">
                  </div>

                  <div class="form-group hide input-methods" id="input_valor">
                    <label for="valor_descontado">Valor exacto</label>
                    <input type="number" min="1" class="form-control" placeholder="$" name="valor_descontado" id="valor_descontado">
                  </div>

                  <div class="form-group">
                    <label for="fecha_limite">Fecha final</label>
                    <input type="date" class="form-control" name="fecha_limite" id="fecha_limite">
                  </div>

                  <div class="form-group">
                    <label for="cupones_disponibles"># Cupones disponibles</label>
                    <input type="number" class="form-control" name="cupones_disponibles" id="cupones_disponibles" required value="1">
                  </div>

                  <div class="form-group">
                    <label for="maximo_usuario">Max. por usuario</label>
                    <input type="number" class="form-control" name="maximo_usuario" id="maximo_usuario" value="1" required>
                  </div>
                  
                  <div class="text-center">
                    <input type="submit" value="Guardar" class="btn btn-success btn-md">
                  </div>
                  
                  
                </form>
              <!-- CUPON BASICO -->



              <!-- CUPON COMPRA MINIMA -->
                <form action="<?php echo URL_BASE.'admin/bd/productos/cupones/create.php'; ?>" method="POST" class="hide carac-form" id="cuponCompraMinima">
                  <input type="hidden" name="empt_val">
                  <input type="hidden" name="id_tipo_cupon" value="2">

                  <p>
                    Aplica cupón solo si el valor de la compra supera un monto mánimo.
                  </p>

                  <div class="form-group">
                    <label for="clave_cupon">Cupón</label>
                    <input type="text" class="form-control" placeholder="" name="clave_cupon" id="clave_cupon" required>
                  </div>

                  <div class="form-group">
                    <label for="metodoDescuento2">Método de descuento</label>   
                    <select class="form-control" id="metodoDescuento2" onchange="showMethod2()" required>
                      <option></option>
                      <option value="porcentaje">Porcentaje de la compra</option>
                      <option value="valor">Valor exacto</option>
                    </select>                             
                  </div>

                  <div class="form-group hide input-methods" id="input_porcentaje2">
                    <label for="porcentaje">% descontado</label>
                    <input type="number" min="1" max="100" class="form-control" placeholder="%" name="porcentaje" id="porcentaje2">
                  </div>

                  <div class="form-group hide input-methods" id="input_valor2">
                    <label for="valor_descontado">Valor exacto</label>
                    <input type="number" min="1" class="form-control" placeholder="$" name="valor_descontado" id="valor_descontado2">
                  </div>

                  <div class="form-group">
                    <label for="fecha_limite">Fecha final</label>
                    <input type="date" class="form-control" name="fecha_limite" id="fecha_limite">
                  </div>

                  <div class="form-group">
                    <label for="valor_compra_minima">Para compras superiores a:</label>
                    <input type="number" min="1" class="form-control" placeholder="$" name="valor_compra_minima" id="valor_compra_minima">
                  </div>

                  <div class="form-group">
                    <label for="cupones_disponibles"># Cupones disponibles</label>
                    <input type="number" min="1" class="form-control" name="cupones_disponibles" id="cupones_disponibles" required value="1">
                  </div>

                  <div class="form-group">
                    <label for="maximo_usuario">Max. por usuario</label>
                    <input type="number" class="form-control" name="maximo_usuario" id="maximo_usuario" value="1" required>
                  </div>
                  
                  <div class="text-center">
                    <input type="submit" value="Guardar" class="btn btn-success btn-md">
                  </div>
                  
                  
                </form>
              <!-- CUPON COMPRA MINIMA -->



              <!-- CUPON POR PRODUCTO -->
                <form action="<?php echo URL_BASE.'admin/bd/productos/cupones/create.php'; ?>" method="POST" class="hide carac-form" id="cuponPorProducto">
                  <input type="hidden" name="empt_val">
                  <input type="hidden" name="id_tipo_cupon" value="3">

                  <p>
                    Este aplicará un cupón a un produto en especifico unicamente.
                  </p>

                  <div class="form-group">
                    <label for="clave_cupon">Cupón</label>
                    <input type="text" class="form-control" placeholder="" name="clave_cupon" id="clave_cupon" required>
                  </div>

                  <?php
                    $productos = CRUD::all('productos','*','tm_delete IS NULL');
                  ?>

                  <div class="form-group">
                    <label for="id_producto">Producto</label>   
                    <select class="form-control" id="id_producto" name="id_producto" required>
                      <option></option>
                      <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['id_producto'] ?>">
                          <?php echo $producto['nombre_producto']; ?> -
                          <?php echo '$ '.$producto['precio'] ?>
                        </option>
                      <?php endforeach ?>
                    </select>                             
                  </div>

                  <div class="form-group">
                    <label for="metodoDescuento2">Método de descuento</label>   
                    <select class="form-control" id="metodoDescuento3" onchange="showMethod3()" required>
                      <option></option>
                      <option value="porcentaje">Porcentaje de la compra</option>
                      <option value="valor">Valor exacto</option>
                    </select>                             
                  </div>

                  <div class="form-group hide input-methods" id="input_porcentaje3">
                    <label for="porcentaje">% descontado</label>
                    <input type="number" min="1" max="100" class="form-control" placeholder="%" name="porcentaje" id="porcentaje3">
                  </div>

                  <div class="form-group hide input-methods" id="input_valor3">
                    <label for="valor_descontado">Valor exacto</label>
                    <input type="number" min="1" class="form-control" placeholder="$" name="valor_descontado" id="valor_descontado3">
                  </div>

                  <div class="form-group">
                    <label for="fecha_limite">Fecha final</label>
                    <input type="date" class="form-control" name="fecha_limite" id="fecha_limite">
                  </div>

                  <div class="form-group">
                    <label for="cupones_disponibles"># Cupones disponibles</label>
                    <input type="number" min="1" class="form-control" name="cupones_disponibles" id="cupones_disponibles" required value="1">
                  </div>

                  <div class="form-group">
                    <label for="maximo_usuario">Max. por usuario</label>
                    <input type="number" class="form-control" name="maximo_usuario" id="maximo_usuario" value="1" required>
                  </div>
                  
                  <div class="text-center">
                    <input type="submit" value="Guardar" class="btn btn-success btn-md">
                  </div>
                  
                  
                </form>
              <!-- CUPON POR PRODUCTO -->

          	</div>
          	<br>
        </div>
      </div>
</div>
<!-- END ADD CATACTERISTIC -->

<!-- ADD CATACTERISTIC -->
<div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header bg-success" style="background-color: #449D44; color: white;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title text-center text-uppercase">Agregar cupón</h4>
          	</div>
          	<div class="modal-body">
          	</div>
          	<br>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
            	<button type="button" class="btn btn-sm btn-success">Guardar</button>
          	</div>
        </div>
      </div>
</div>
<!-- END ADD CATACTERISTIC -->

<!-- CHECK ORDER -->
<div class="modal fade" id="checkOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Detalles del pedido</h4>
            </div>
            <div class="modal-body" id="specificOrder">
            </div>
            <br>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-sm btn-success">Guardar</button>
            </div> -->
        </div>
      </div>
</div>
<!-- END CHECK ORDER -->

<!-- CHECK ORDER -->
<div class="modal fade" id="checkProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Detalles del producto</h4>
            </div>
            <div class="modal-body" id="specificProduct">
            </div>
            <br>
        </div>
      </div>
</div>
<!-- END CHECK ORDER -->


<!-- CHECK ORDER -->
<div class="modal fade" id="addTestimonial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success" style="background-color: #449D44; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center text-uppercase">Agregar Testimonio</h4>
            </div>
            <div class="modal-body" id="">
              <div class="form-group">
                <label>Selecciona</label>
                <select class="c-select form-control" id="select_testimonials">
                  <option selected></option>
                  <option value="1">Agregar Imagen de cliente</option>
                  <option value="2">Agregar testimonio escrito</option>
                </select>
                <br>
                <br>

                <!-- Add image testimonial -->
                  <form class="hide" id="imgTestimonialForm" action="<?php echo ADMIN.'bd/testimonial/addImage.php'; ?>" method="POST" enctype="multipart/form-data">
                    <div class="">
                      <label>Selecciona la Imagen</label>
                      <input type="file" class="btn" id="img_cliente" name="img_cliente[]">
                    </div>
                    <input type="submit" class="btn btn-success pull-right" Value="Cargar">
                  </form>
                <!-- #Add image testimonial -->
                 
                <!-- Add text testimonial -->
                  <form class="hide" id="txtTestimonialForm" action="<?php echo ADMIN.'/bd/testimonial/addTxt.php'; ?>" method="POST" role="form">

                    <label>Ingresa el Testimonio escrito</label>
                    <div class="">
                      <label>Mensaje</label>
                      <textarea name="message" class="form-control"></textarea>
                    </div>
                    <div class="">
                      <label>Autor</label>
                      <input type="text" name="author" class="form-control" style="">
                    </div>
                    <input type="submit" class="btn btn-success pull-right" Value="Guardar">
                  </form>
                <!-- Add text testimonial -->
              </div>
            </div>
            <br>
        </div>
      </div>
</div>
<!-- END CHECK ORDER -->