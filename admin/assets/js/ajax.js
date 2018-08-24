$(document).ready(start);

function start() {
	/*-----*/
	base = $('#urlBase').val();
	/*-----*/
    $(".publicacion").change(publicacion);/*Plubic product*/
	$(".soldout").change(soldOut);/*soldout btn*/
    // $(':input[name=item_es]').keyup(searchItems);/*Autocomplete input (add Item)*/
    // $(':input[name=item_es]').blur(searchEnItemsBasedEs);Autocomplete input (add Item)
    // $(':input[name=item_en]').keyup(searchItemsEn);/*Autocomplete input (add Item)*/
    $('#product_to_item').change(showItemsProduct);/*List of items for product*/
    $('#agregarItems').submit(agregarItems);
    $("#select_testimonials").change(showFormTestimonial);
    $('#product_discount').change(buscarPrecio);
    $('#porcentaje_descuento').keyup(changePercentaje);
    $('#valor_descontado').keyup(changeValue);

}


/*AGREGAR PRODUCTOS*/
	function searchSubC() {
		$datos  = {
            'id_categoria': $('.id_categoria').val()
        }
		$.ajax({
			type: 'POST',
			data: $datos,
			url: base+'admin/bd/productos/subcategorias.php',
			success: function (data) {
				$('.id_sub_categoria').html(data);
			}
		})
	}

    function publicacion() {
        if ($(this).prop('checked') == true) {
            var estado = "SI";
        }
        if ($(this).prop('checked') == false) {
            var estado = "NO";
        }
        var producto = $(this).val();

        $datos = {
            'id_producto': producto,
            'estado_publicado': estado
        }

        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/publicar.php',
            success: function (data) {
                // alert(data);
            }
        })
        return false;

    }

    function soldOut() {
        if ($(this).prop('checked') == true) {
            var estado = "NO";
        }
        if ($(this).prop('checked') == false) {
            var estado = "SI";
        }
        var producto = $(this).val();

        $datos = {
            'id_producto': producto,
            'estado_agotado': estado
        }

        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/agotados.php',
            success: function (data) {
                // alert(data);
            }
        })
        return false;

    }

    function cargarInfoOrden(serial) {
        $datos = {
            'serial_venta': serial
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/pedidos/verorden.php',
            success: function (data) {
                $('#specificOrder').html(data);
            }
        })
    }

    function cargarInfoProducto(productoID) {
        $datos = {
            'id_producto': productoID
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/editar.php',
            success: function (data) {
                $('#specificProduct').html(data);
            }
        })
    }


    /*Promociones*/

    function buscarPrecio() {
         $datos = {
            'id_producto': $(this).val(),
            'empt_val': ''
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/descuento/encontrar_producto.php',
            success: function (data) {
                $('#precioProducto').html(data);
                $('#porcentaje_descuento').val('');
                $('#valor_descontado').val('');
            }
        })
    }

    function changePercentaje() {
        var porcentaje = $(this).val();
        var valor = (porcentaje * precio) / 100;
        $('#valor_descontado').val(Math.round(valor));
    }
    function changeValue() {
        var valor_decuento = $(this).val();
        var valor = (valor_decuento * 100) / precio;
        $('#porcentaje_descuento').val(Math.round(valor));
    }


/*USER FUNCTIONS*/
    function editarUsuario(usuarioID) {
        $datos = {
            'id_usuario': usuarioID
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/usuarios/editar.php',
            success: function (data) {
                $('#dataEditUser').html(data);
            }
        })
    }

    function eliminarUsuario(usuarioID) {
        $datos = {
            'id_usuario': usuarioID
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/usuarios/eliminar.php',
            success: function (data) {
                alert(data);
            }
        })
    }

    function darAltaUsuario(usuarioID) {
        $datos = {
            'id_usuario': usuarioID
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/usuarios/alta.php',
            success: function (data) {
                alert(data);
            }
        })
    }

    function cargarForm() {
        var form = $("#selectForm").val();
        $(".carac-form").addClass('hide');
        showForm(form);
    }

    function showForm(form) {
        if (form === 'num') {
            $('#cantidadForm').removeClass('hide');
        }
        if (form === 'cat') {
            $('#catForm').removeClass('hide');
        }
        if (form === 'sub') {
            $('#subCatForm').removeClass('hide');
        }
        if (form === 'basico') {
            $('#cuponBasico').removeClass('hide');
        }
        if (form === 'minima') {
            $('#cuponCompraMinima').removeClass('hide');
        }
        if (form === 'producto') {
            $('#cuponPorProducto').removeClass('hide');
        }
    }

    function showMethod() {
       var metodo = $('#metodoDescuento').val();       
       $('.input-methods').addClass('hide');

       if (metodo === 'porcentaje') {
            $('#input_porcentaje').removeClass('hide');
            $('#porcentaje').prop("required", true);
            $('#valor_descontado').removeAttr("required");
       }

       if (metodo === 'valor') {
            $('#input_valor').removeClass('hide');
            $('#porcentaje').removeAttr("required");
            $('#valor_descontado').prop("required", true);
       }
    }

    function showMethod2() {
       var metodo = $('#metodoDescuento2').val();       
       $('.input-methods').addClass('hide');

       if (metodo === 'porcentaje') {
            $('#input_porcentaje2').removeClass('hide');
            $('#porcentaje2').prop("required", true);
            $('#valor_descontado2').removeAttr("required");
       }

       if (metodo === 'valor') {
            $('#input_valor2').removeClass('hide');
            $('#porcentaje2').removeAttr("required");
            $('#valor_descontado2').prop("required", true);
       }
    }

    function showMethod3() {
       var metodo = $('#metodoDescuento3').val();       
       $('.input-methods').addClass('hide');

       if (metodo === 'porcentaje') {
            $('#input_porcentaje3').removeClass('hide');
            $('#porcentaje3').prop("required", true);
            $('#valor_descontado3').removeAttr("required");
       }

       if (metodo === 'valor') {
            $('#input_valor3').removeClass('hide');
            $('#porcentaje3').removeAttr("required");
            $('#valor_descontado3').prop("required", true);
       }
    }

    function showFormTestimonial() {
        var form = $(this).val();
        if (form == 1) {
            $('#imgTestimonialForm').removeClass('hide');
            $('#txtTestimonialForm').addClass('hide');
        } 
        if(form == 2) {
            $('#txtTestimonialForm').removeClass('hide');
            $('#imgTestimonialForm').addClass('hide');
        }
    }

    /*Alerts*/
    function showAlert(type,txt) {
        if (type === 'success') {
            $('#successAlertTxt').html(txt);
            $('.container-alert-success').css({'opacity':'0.95','display':'block'});
            $('.alert-success-mifu').addClass('animated bounceInRight');

            setTimeout(function () {
                $('.alert-success-mifu').removeClass('animated bounceInRight');
                $('.container-alert-success').animate({
                    opacity: '0',
                },'slow').delay(500).css('display','none');
            }, 12000);
        }

        if (type === 'error') {
            $('#wrongAlertTxt').html(txt);
            $('.container-alert-wrong').css({'opacity':'0.95','display':'block'});
            $('.alert-wrong-mifu').addClass('animated bounceInRight');

            setTimeout(function () {
                $('.alert-wrong-mifu').removeClass('animated bounceInRight');
                $('.container-alert-wrong').animate({
                    opacity: '0',
                },'slow').delay(500).css('display','none');
            }, 12000);
        }
    }

    $('.alert-success-mifu').on('closed.bs.alert', function () {
        $('.alert-success-mifu').removeClass('animated bounceInRight');
        $('.container-alert-success').css({'display':'none', 'opacity' : '0'});
    })

    $('.alert-wrong-mifu').on('closed.bs.alert', function () {
        $('.alert-wrong-mifu').removeClass('animated bounceInRight');
        $('.container-alert-wrong').css({'display':'none', 'opacity' : '0'});
    })

    function agregarItems() {     
        $.ajax({
            type: 'POST',
            data: $(this).serialize(),
            url: $(this).attr('action'),
            success: function (data) {
                $('#container_list_items').html(data);
            }
        })
        return false;
    }

    function eliminarItems($itemID) {
        $datos = {
            'id_prod_item': $itemID,
            'empt_val': ''
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/delete.php',
            success: function (data) {
                $('#container_list_items').html(data);
            }
        })
        return false;
    }

    function searchItems() {
        var item = $(this).val();
        $datos = {
            'item_es': item,
            'empt_val': ''
        }
        $(':input[name=item_en]').val('');
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/find.php',
            success: function (data) {
                $('#datalist_item_product').html(data);
            }
        })
    }

    function searchEnItemsBasedEs() {  
        var itemES = $(':input[name=item_es]').val();
        $datos = {
            'item_es': itemES,
            'empt_val': ''
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/findEqual.php',
            success: function (data) {
                $('#datalist_item_product_en').html(data);
            }
        })
    }

    function searchItemsEn() {
        var itemEN = $(this).val();
        var itemES = $(':input[name=item_es]').val();
        $datos = {
            'item_en': itemEN,
            'item_es': itemES,
            'empt_val': ''
        }
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/find_en.php',
            success: function (data) {
                $('#datalist_item_product_en').html(data);
            }
        })
    }

    function showItemsProduct() {
        var productoID = $(this).val();       
            $datos = {
                'id_producto': productoID,
                'empt_val': ''
        } 
                
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/items_products.php',
            success: function (data) {
                $('#container_list_items').html(data);
                $('#form_asign_item').submit(updateItemsProduct);
            }
        })
    }

    function showItemsProductUpdate(id_producto,actualizado) {
        var productoID = id_producto;       
        $datos = {
            'id_producto': productoID,
            'actualizado': actualizado,
            'empt_val': ''
        }     
        $.ajax({
            type: 'POST',
            data: $datos,
            url: base+'admin/bd/productos/items/items_products.php',
            success: function (data) {
                $('#container_list_items').html(data);
                $('#labelSuccessIteUpdate').delay(4000).fadeOut(2000);
                $('#form_asign_item').submit(updateItemsProduct);
            }
        })
    }

    function updateItemsProduct() {
        $.ajax({
            type: 'POST',
            data: $(this).serialize(),
            url: $(this).attr('action'),
            success: function (data) {
                showItemsProductUpdate($('#form_asign_item').attr('id-producto'),data);
            }
        })
        return false;
    }