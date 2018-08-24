<?php require '../config/config.php'; ?>

<?php 
	switch ($_GET['pagina']) {
        case 'coleccion':
            $pageRequire = 'coleccion/';
			$url_base = URL_BASE.'page/coleccion/';

            if (isset($_GET['special']) && $_GET['special'] === 'oferta') {
            	$pageRequire = 'coleccion/ofertas.php';
            	$titlePage = ucwords('ofertas');
            	$breadcrumb = [[$titlePage,$url_base.'ofertas']];
            	break;
            }

            if ( isset($_GET['id_producto']) AND isset($_GET['producto']) ) {
            	$pageRequire = 'coleccion/producto.php';
            	$titlePage = strtoupper($_GET['producto']);
            	$breadcrumb = [
            		[$_GET['categoria'],$url_base.$_GET['id_categoria'].'/'.$_GET['categoria']],
            		[$_GET['producto'],$url_base.$_GET['id_categoria'].'/'.$_GET['categoria'].'/'.$_GET['id_producto'].'/'.$_GET['producto']]
            	];
            }elseif (isset($_GET['categoria'])) {
            	$pageRequire = 'coleccion/categoria.php';
            	$titlePage = strtoupper($_GET['categoria']);
            	$breadcrumb = [
            		[$_GET['categoria'],$url_base.$_GET['id_categoria'].'/'.$_GET['categoria']]
            	];
            }else{
            	$pageRequire = 'coleccion/index.php';
            	$titlePage = 'CATEGORIAS';
            	$breadcrumb = [[$titlePage,$url_base]];
            }
            break;
        
        case 'politicas':
			$url_base = URL_BASE.'page/politicas/';

        	if ($_GET['politica'] === 'terminos-y-condiciones') {
	            $pageRequire = 'politicas/terms.php';
	            $titlePage = strtoupper($_GET['politica']);
        	}elseif ($_GET['politica'] === 'politica-de-cookies') {
	            $pageRequire = 'politicas/cookies.php';
	            $titlePage = strtoupper($_GET['politica']);
        	}elseif ($_GET['politica'] === 'preguntas-frecuentes') {
	            $pageRequire = 'politicas/faq.php';
	            $titlePage = strtoupper($_GET['politica']);
        	}else{        		
	            $pageRequire = 'politicas/terms.php';
	            $titlePage = strtoupper('terminos y condiciones');
        	}
        	$breadcrumb = [
            		[$_GET['politica'],$url_base.$_GET['politica']]
            	];
            break;

        case 'empresa':
			$url_base = URL_BASE.'page/empresa/';

        	if ($_GET['empresa'] === 'conocenos') {        		
	            $pageRequire = 'empresa/conocenos.php';
	            $titlePage = strtoupper('conocenos');
        	}
        	if ($_GET['empresa'] === 'eventos') {        		
	            $pageRequire = 'empresa/eventos.php';
	            $titlePage = strtoupper('eventos');
        	}
        	$breadcrumb = [
            		[$_GET['empresa'],$url_base.$_GET['empresa']]
            	];
            break;
        
        case 'usuarios':
			$url_base = URL_BASE.'page/usuarios/';
        	if ($_GET['usuario'] === 'iniciar-sesion' && !$session) {
        		$p = 'login';
	            $pageRequire = 'usuarios/iniciar_sesion.php';
	            $titlePage = strtoupper('iniciar sesión');   
	        }elseif ($_GET['usuario'] === 'registrarse' && !$session) {
        		$p = 'signup';
	            $pageRequire = 'usuarios/iniciar_sesion.php';
	            $titlePage = strtoupper('registro de usuario');  
	        }elseif ($_GET['usuario'] === 'recuperar-clave' && !$session) {	        	
	            $pageRequire = 'usuarios/recuperar_clave.php';
	            $titlePage = strtoupper('recuperar contraseña');
	        }else{
	        	if ($session) {
	        		if ($_GET['usuario'] === 'informacion-personal') {     		
			            $pageRequire = 'usuarios/informacion.php';
			            $titlePage = strtoupper('informacion personal');        		
		        	}elseif ($_GET['usuario'] === 'compras') { 			
			            $pageRequire = 'usuarios/compras.php';
			            $titlePage = strtoupper('compras');          		
		        	}elseif ($_GET['usuario'] === 'direcciones') { 		
			            $pageRequire = 'usuarios/direccion.php';
			            $titlePage = strtoupper('direcciones');          		
		        	}else{ 		
			            $pageRequire = 'usuarios/informacion.php';
			            $titlePage = strtoupper('informacion personal');  		        		
		        	}
	        	}else{ 		
	        		$p = 'login';
		            $pageRequire = 'usuarios/iniciar_sesion.php';
		            $titlePage = strtoupper('iniciar sesión');  
	          	}
        	}
        	$breadcrumb = [
            		[$_GET['usuario'],$url_base.$_GET['usuario']]
            	];
            break;

        case 'caja':
			$url_base = URL_BASE.'page/caja/';
            $pageRequire = 'checkout/caja.php';
            $titlePage = 'Caja'; 
        	$breadcrumb = [
            		['caja',$url_base]
            	];       	
        	break;
                
        case 'contactanos':
			$url_base = URL_BASE.'page/contactanos/';
            $pageRequire = 'contactanos.php';
            $titlePage = 'Contáctanos'; 
        	$breadcrumb = [
            		['contactanos',$url_base]
            	];     
            break;

        default:
            header('Location: '.URL_BASE.'/page_not_found');
    }

?>
<?php require DIRECTORIO_ROOT.'inc/header.php'; ?>
	
<!-- products-breadcrumb -->
	<div class="products-breadcrumb">
		<div class="container">
			<ul>
				<li>
					<i class="fa fa-home" aria-hidden="true" style="color: white;"></i>
					<a href="<?php echo URL_BASE; ?>">Inicio</a>
					<span>|</span>
				</li>

				<?php foreach ($breadcrumb as $link): ?>
					<li>
						<a href="<?php echo $link[1]; ?>">
							<?php echo ucwords(str_replace('-', ' ', $link[0])); ?>
						</a>
						<span>|</span>
					</li>
				<?php endforeach ?>

			</ul>
		</div>
	</div>
<!-- //products-breadcrumb -->
<!-- banner -->
	<div class="banner">	
		<?php include DIRECTORIO_ROOT.'inc/head/side-nav.php'; ?>
	</div>
	

		<?php require DIRECTORIO_ROOT.'page/includes/'.$pageRequire; ?>

<!-- # -->


<?php require DIRECTORIO_ROOT.'inc/footer.php'; ?>