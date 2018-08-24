<?php 


/**
* Plugging Coupon generate and calculate
*/
class Coupon extends Secure
{
	
	private $_datos = [];
	private $_coupon;

	private function recieveData($type = null)
	{	
		if ($type === null) {
			return false;
		}

		$data = parent::recibirRequest();
		if (!$data) {
			return false;
		}	

		if ( $type === 1 ) {
			$permitidas = ['clave_cupon','id_tipo_cupon','cupones_disponibles','maximo_usuario'];
		}

		if ( $type === 2 ) {
			$permitidas = ['clave_cupon','id_tipo_cupon','cupones_disponibles','maximo_usuario','valor_compra_minima'];
		}

		if ( $type === 3 ) {
			$permitidas = ['clave_cupon','id_tipo_cupon','cupones_disponibles','maximo_usuario','id_producto'];
		}

		$datos = parent::parametros_permitidos($permitidas,$data);


		if (isset($data['fecha_limite']) AND $data['fecha_limite'] !== '') {
			$datos['fecha_limite'] = $data['fecha_limite'].' 23:59:59';
		}

		if (isset($data['porcentaje']) AND $data['porcentaje'] !== '') {
			$datos['porcentaje'] = $data['porcentaje'];
		}

		if (isset($data['valor_descontado']) AND $data['valor_descontado'] !== '') {
			$datos['valor_descontado'] = $data['valor_descontado'];
		}

		$this->_datos = $datos;
		$this->_coupon = $datos['clave_cupon'];

		return true;
	}

	public function create($type = null)
	{
		if ($this->recieveData($type)) {			
			if ($this->exist($this->_coupon)) {
				return false;
			}else{
				$unique = [
					'conditional' => 'clave_cupon = ?',
					'params' => ['s',$this->_coupon]
				];
				$create = CRUD::insert('productos_cupones',$this->_datos,$unique);

				if ($create[0]->affected_rows === 1) {
					return true;
				}
			}
		}
		return false;
	}

	public function update($data)
	{	
		$this->_coupon = $data['clave_cupon'];

		$this->_datos = parent::parametros_permitidos('fecha_limite',$data);

		if ($this->recieveData($type)) {
			if (!$this->exist($this->_coupon)) {
				echo 'No existe el cupon';
				return false;
			}else{
				$where = 'clave_cupon = ?';
				$params = ['s',$this->_coupon];
				$update = CRUD::update('productos_cupones',$this->_datos,$where,$params);

				if ($update[0]->affected_rows === 1) {
					echo "Cupon modificado exitosamente";
					return true;
				}
			}
		}
		return false;
	}

	public function delete($coupon)
	{	
		$where = 'clave_cupon = ?';
		$params = ['s',$coupon];
		return CRUD::falseDelete('productos_cupones',$where,$params);
	}

	public function all($where=null,$params=[],$rows='*, productos_cupones.tm_delete',$join=null,$order=null,$limit=null)
	{	
		if ($join === null) {
			$join = [
				['LEFT','tipos_cupones','tipos_cupones.id_tipo_cupon = productos_cupones.id_tipo_cupon'],
				['LEFT','productos','productos.id_producto = productos_cupones.id_producto'],
			];
		}
		return CRUD::all('productos_cupones',$rows,$where,$params,$join,$order,$limit);
	}

	public function find($coupon,$rows='*')
	{	
		$where = 'clave_cupon = ?';
		$params = ['s',$coupon];
		$cupon = CRUD::all('productos_cupones',$rows,$where,$params);

		if (count($cupon) <= 0) {
			return [];
		}else{
			return $cupon[0];
		}
	}

	public function exist($coupon)
	{	
		$where = 'clave_cupon = ? AND tm_delete IS NULL';
		$params = ['s',$coupon];
		if (CRUD::numRows('productos_cupones','*',$where,$params) > 0) {
			return true;
		}
		return false;
	}

	public $cuponUsuarioID = 0;
	public function findUserCoupon()
	{
		if (isset($_SESSION['id_usuario'])) {
			$where = 'usuario_cupon.id_usuario = ? AND usuario_cupon.tm_delete IS NULL AND usuario_cupon.tm_expire IS NULL AND usuario_cupon.tm_used IS NULL';
			$params = ['i',$_SESSION['id_usuario']];
			$join = [
				['INNER','productos_cupones','productos_cupones.id_producto_cupon = usuario_cupon.id_producto_cupon'],
			];
			$cupon = CRUD::all('usuario_cupon','productos_cupones.clave_cupon, usuario_cupon.id_usuario_cupon',$where,$params,$join);
			if (count($cupon) === 1) {
				$this->cuponUsuarioID = $cupon[0]['id_usuario_cupon']; 
				return $cupon[0]['clave_cupon'];			
			}
			return false;
		}

		if (isset($_COOKIE['coupon'])) {
			$cupon = Cookie::readCookie('coupon');
			return $cupon['clave_cupon'];
		}
		return false;
	}

	public function newUserCoupon($coupon)
	{	
		if (!$this->validate($coupon)) {
			return false;
		}

		$cupon = $this->find($coupon);

		if (isset($_SESSION['id_usuario'])) {

			$where = 'id_producto_cupon = ? AND tm_delete IS NULL AND tm_used IS NULL';
			$params = ['i',$cupon['id_producto_cupon']];
			$verificar = CRUD::numRows('usuario_cupon','*',$where,$params);

			if ($verificar === 1) {
				return true;
			}

			/*Borrar cupones de cliente diferentes al aplicado*/
			$where = 'id_usuario = ? AND tm_delete IS NULL AND tm_used IS NULL';
			$params = ['i',$_SESSION['id_usuario']];
			CRUD::falseDelete('usuario_cupon',$where,$params);
			/*#Borrar cupones de cliente diferentes al aplicado*/


			$set = [
				'id_producto_cupon' => $cupon['id_producto_cupon'],
				'id_usuario' => $_SESSION['id_usuario']
			];
			$unique = [
				'conditional' => 'id_producto_cupon = ? AND tm_delete IS NULL AND tm_used IS NULL',
				'params' => ['i',$cupon['id_producto_cupon']]
			];
			CRUD::insert('usuario_cupon',$set,$unique);

			$set = [
				'id_producto_cupon' => $cupon['id_producto_cupon'],
				'clave_cupon' => $coupon,
				'tm_create' => date('Y-m-d H:i:s')
			];
			Cookie::createCookie('coupon',$set,60*60*24*5);
		}else{
			$set = [
				'id_producto_cupon' => $cupon['id_producto_cupon'],
				'clave_cupon' => $coupon,
				'tm_create' => date('Y-m-d H:i:s')
			];
			Cookie::createCookie('coupon',$set,60*60*24*5);
		}
		return true;
	}

	public function calculateCoupon($coupon)
	{	
		// Validaciones del cupon
		if (!$this->validate($coupon)) {
			return 0;
		}

		$cupon = $this->find($coupon);
		$carritoParaCupon = new Checkout;
		$bolsaParaCupon = $carritoParaCupon->productosBolsa;

		if ( $cupon['id_tipo_cupon'] === 1 ) {
			$total = 0;
			foreach ($bolsaParaCupon as $producto) {
				$total = $total + $producto['precio_total'];
			}
			$valor = $total;
		}

		if ( $cupon['id_tipo_cupon'] === 2 ) {
			
			$total = 0;
			foreach ($bolsaParaCupon as $producto) {
				$total = $total + $producto['precio_total'];
			}
			$valor = $total;
		}

		if ( $cupon['id_tipo_cupon'] === 3 ) {
			$buscar = array_search($cupon['id_producto'], array_column($bolsaParaCupon, 'id_producto')); 
			$valor = $bolsaParaCupon[$buscar]['precio'];
		}

		if ( $cupon['porcentaje'] !== null ) {
			$descuento = ($cupon['porcentaje'] * $valor)/100;
		}

		if ( $cupon['valor_descontado'] !== null ) {
			$descuento = $cupon['valor_descontado'];
		}

		return $descuento;
	}

	public function validate($coupon)
	{
		//Exista
		if (!$this->exist($coupon)) {
			return false;
		}

		$cupon = $this->find($coupon);

		// disponibilidad Coupon
		if ($cupon['cupones_disponibles'] - $cupon['cupones_usados'] === 0) {
			return false;
		}

		//Vigencia del cupón
		if ($cupon['fecha_limite'] != null) {
			$ahora = date('Y-m-d H:i:s');
			if ($ahora < $cupon['fecha_inicial'] OR $ahora > $cupon['fecha_limite'] ) {
				return false;
			}
		}else{		
			$ahora = date('Y-m-d H:i:s');
			if ($ahora < $cupon['fecha_inicial'] ) {
				return false;
			}
		}

		// Cupones maximos usados por el usuario
		if (isset($_SESSION['id_usuario'])) {
			// #max por usuario
			$maximo_por_usuario = $cupon['maximo_usuario'];
			$where = 'id_producto_cupon = ? AND tm_used IS NOT NULL';
			$params = ['i',$cupon['id_producto_cupon']];
			$usados_por_usuario = CRUD::numRows('usuario_cupon','*',$where,$params);

			if ($usados_por_usuario >= $maximo_por_usuario) {
				return false;
			}
		}

		// Aplicacion del cupon básico
		$carritoParaCupon = new Checkout;
		$bolsaParaCupon = $carritoParaCupon->productosBolsa;
		$countCartCupon = count($bolsaParaCupon);
		$bolsaCupon  = Secure::decodeArray($bolsaParaCupon);/*array*/

		if ($countCartCupon === 0) {
			return false;
		}

		// Aplicacion del cupon compra mínima
		$total = 0;
		foreach ($bolsaParaCupon as $producto) {
			$total = $total + $producto['precio_total'];
		}
		if ($cupon['id_tipo_cupon'] === 2) {
			if ($total < $cupon['valor_compra_minima']) {
				return false;
			}
		}

		// Aplicacion del cupon por producto		
		if ($cupon['id_tipo_cupon'] === 3) {
			$buscar = array_search($cupon['id_producto'], array_column($bolsaParaCupon, 'id_producto')); 
			if ($buscar === false) {
				return false;
			}
		}
		
		return true;

	}


}