<?php  
  
  $where = 'id_venta_detalle = ?';
  $params = ['i',$_REQUEST['id_venta_detalle']];
  $join = [
    ['INNER','usuarios_direcciones','usuarios_direcciones.id_direcciones = venta_detalle.id_direccion_envio'],
    ['INNER','estados','estados.id_estado_eu = usuarios_direcciones.id_estado_eu'],
    ['INNER','ciudades','ciudades.id_ciudad = usuarios_direcciones.id_ciudad'],
  ];
  $pedido = CRUD::all('venta_detalle','*',$where,$params,$join);
  $infoPedido = (object) $pedido[0];

  // var_dump($usuarios);

  $dia = substr($infoPedido->fecha_entrega,-2);
  $mesNum = substr($infoPedido->fecha_entrega,5,2);
  
  switch ($mesNum) {
    case '01':
      $mes_es = 'Enero';
      $mes_en = 'January';
      break;
    case '02':
      $mes_es = 'Febrero';
      $mes_en = 'February';
      break;
    case '03':
      $mes_es = 'Marzo';
      $mes_en = 'March';
      break;
    case '04':
      $mes_es = 'Abril';
      $mes_en = 'April';
      break;
    case '05':
      $mes_es = 'Mayo';
      $mes_en = 'May';
      break;
    case '06':
      $mes_es = 'Junio';
      $mes_en = 'June';
      break;
    case '07':
      $mes_es = 'Julio';
      $mes_en = 'July';
      break;
    case '08':
      $mes_es = 'Agosto';
      $mes_en = 'August';
      break;
    case '09':
      $mes_es = 'Septiembre';
      $mes_en = 'September';
      break;
    case '10':
      $mes_es = 'Octubre';
      $mes_en = 'October';
      break;
    case '11':
      $mes_es = 'Noviembre';
      $mes_en = 'November';
      break;
    case '12':
      $mes_es = 'Diciembre';
      $mes_en = 'December';
      break;
  }

  $where = 'serial_venta = ?';
  $params = ['s',$pedido[0]['serial_venta']];
  $join = [
    ['INNER','productos','productos.id_producto = ventas.id_producto']
  ];
  $productos = CRUD::all('ventas','*',$where,$params,$join);
  
  $infoProducto = [];
  foreach ($productos as $producto) {
     $infoProducto[] = Products::find($producto['serie']);
  }

  $search_lang = CRUD::all('usuarios_lang','lang','id_usuario = ?',['i',$_REQUEST['id_usuario']]);
  $lang = 'en';
  if (count($search_lang) > 0) {
      $lang = $search_lang[0]['lang'];
  }
  $mes_lang = 'mes_'.$lang;

  if ($lang === 'es') {
    $content = (object) [
      'title_head' => 'Resumen de la compra',
      'title' => 'RESUMEN DE LA COMPRA',
      'prf_1' => 'Hemos recibido el pago de tu pedido, en este momento se encuentra en alistamiento para ser entregado el dia '.$dia.' de '.$$mes_lang.' de 2017, los siguientes productos',
      'prf_2' => 'Tu pedido será entregado en',
      'phone' => 'Teléfono ',
      'prf_3' => 'Si tienes alguna duda puedes escribirnos a ',
    ];
  }else{
    $content = (object) [
      'title_head' => 'Summary of purchase',
      'title' => 'SUMARY OF PURCHASE',
      'prf_1' => 'We have received the payment of your order, this time is in enlistment to be delivered on '.$$mes_lang.' '.$dia.', 2017, the following products',
      'prf_2' => 'Your order will be delivered include',
      'phone' => 'Phone: ',
      'prf_3' => 'If you have any questions you can write to us to ',
    ];
  }

  $message = '';
  $message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
  $message .= '<html xmlns="http://www.w3.org/1999/xhtml">';
  $message .= '<head>';
  $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
  $message .= '<title>'.$content->title_head.'</title>';
  $message .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
  $message .= '</head>';
  $message .= '<body style="margin: 0; padding: 0;">';
  $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
  $message .= '<tr>';
  $message .= '<td style="padding: 20px 0 30px 0;">';
  $message .= '<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: none; border-collapse: collapse;">';
  $message .= '<tr align="center">';
  $message .= '<td bgcolor="" style="padding: 20px 0 20px 0;">';
  $message .= '<img src="'.URL_PAGE.'/./img/logo/logo-green.png" width="150px" style="display: block;" />';                       
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td bgcolor="#ffffff" style="padding: 0px 30px 40px 30px;">';
  $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
  $message .= '<tr>';
  $message .= '<td align="center" style="color: #189b7f; font-family: Arial, sans-serif; font-size: 18px;">';
  $message .= '<b>';
  $message .= $content->title;
  $message .= '</b>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="justify" style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 16px;">';
  $message .= $content->prf_1.':';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center" style="padding: 10px 10px 20px 10px; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">';
  $message .= '<table style="">';

  /*Listado de productos del pedido*/
  $contar = 0;
  foreach ($infoProducto as $pd){

    $url = URL_PAGE.'/img_productos/'.$pd->serie.'/thumbnail/'.$pd->ruta_img_tn;
    $precio = $productos[$contar]['precio_total_producto'];
    $cantidad = $productos[$contar]['cantidad'];
    $contar++;
    $name = 'nombre_producto_'.$lang;

    $message .= '<tr>';
    $message .= '<td style="border: 2px solid #189b7f;">';
    $message .= '<img src="'.$url.'" width="80px;" style="display: block;" />';
    $message .= '</td>';
    $message .= '<td align="center" style="padding: 20px; padding-right: 20px; border: 2px solid #189b7f;">';
    $message .= '<p align="center" style="color: #153643; font-size: 14px; margin: 0;">';
    $message .= $pd->$name.'('.$cantidad.')';
    $message .= '</p>';
    $message .= '</td>';
    $message .= '<td align="right" style="border: 2px solid #189b7f; padding: 10px;">';
    $message .= '<p style="color: #153643; font-size: 14px; margin: 0;">';
    $message .= $precio.' USD';
    $message .= '</p>';
    $message .= '</td>';
    $message .= '</tr>';

  }
  /*#Listado de productos del pedido*/

  $message .= '</table>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td  style="padding: 10px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">';
  $message .= $content->prf_2.':';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center">';
  $message .= $infoPedido->nombre_direccion.' '.$infoPedido->apellido_direccion;
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center">';
  $message .= $infoPedido->direccion;
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center">';
  $message .= $infoPedido->nombre_estado.', ';
  $message .= $infoPedido->nombre_ciudad;
  $message .= $infoPedido->zip_code;
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center">';
  $message .= $content->phone.': ';
  $message .= $infoPedido->telefono;
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td style="padding-top: 30px; color: #153643;">';
  $message .= $content->prf_3;
  $message .= '<a style="color: #189b7f;"  href="mailto:gifts@madeitforu.com">gifts@madeitforu.com</a>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '</table>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td bgcolor="" style="padding: 0px 30px 30px 30px;">';
  $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
  $message .= '<tr>';
  $message .= '<hr style="border-top: 1px solid #189b7f;">';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center" style="font-family: Arial, sans-serif; font-size: 14px;">';
  $message .= '<b><a style="color: #189b7f;" href="http://www.madeitforu.com">';
  $message .= 'WWW.MADEITFORU.COM';
  $message .= '</a></b>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '<tr>';
  $message .= '<td align="center" style="padding: 10px;">                     ';
  $message .= '<table border="0" cellpadding="0" cellspacing="0">';
  $message .= '<tr>';
  $message .= '<td>';
  $message .= '<a href="http://www.facebook.com/madeitforu.usa">';
  $message .= '<img src="'.URL_PAGE.'/img/icons/facebook.gif" alt="Facebook" width="30" height="30" style="display: block;" border="0" />';
  $message .= '</a>';
  $message .= '</td>';
  $message .= '<td style="font-size: 0; line-height: 0;" width="20"></td>';
  $message .= '<td>';
  $message .= '<a href="http://www.instagram.com/madeitforu.usa">';
  $message .= '<img src="'.URL_PAGE.'/img/icons/instagram.png" alt="Instagram" width="30" height="30" style="display: block;" border="0" />';
  $message .= '</a>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '</table>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '</table>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '</table>';
  $message .= '</td>';
  $message .= '</tr>';
  $message .= '</table>';
  $message .= '</body>';
  $message .= '</html>';
