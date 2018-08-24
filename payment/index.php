<?php require '../config/config.php'; ?>
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
				<li>
					Respuesta de Pago
					<span>|</span>
				</li>

			</ul>
		</div>
	</div>
<!-- //products-breadcrumb -->
<!-- banner -->

	<div class="banner">	
		<?php include DIRECTORIO_ROOT.'inc/head/side-nav.php'; ?>
	</div>
	
		<?php require DIRECTORIO_ROOT.'payment/includes/response.php'; ?>

<!-- # -->


<?php require DIRECTORIO_ROOT.'inc/footer.php'; ?>