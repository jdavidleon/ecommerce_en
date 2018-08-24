<?php 

	$faq = [
		[
			'pregunta' => 'Puedo usar mi cupón de bienvenida en productos de descuento?',
			'respuesta' => 'El cupón que obsequiamos al registrarse en nuestro sitio, puede usarse en cualquier producto y puede acumularse con las promociones actuales del producto. Este es un regalo que hacemos a nuestros nuevos clientes para que conozcan la calidad de nuestros productos, pero ocasionalmente podemos ofrecer más promociones de nuestros productos, esto sin afectar el cupón obsequiado de primera compra.',
		],
		[
			'pregunta' => 'Como se realiza el pago de los productos?',
			'respuesta' => 'ENNAVIDAD para asegurar el dinero de nuestros clientes realiza una alianza con la plataforma de pagos PayU Latam la cual al momento de que estés seguro/a de los artículos que deseas adquirir enviaremos esta información a la plataforma de pagos y serás redireccionado/a a su página la cual realiza el cobro de forma segura. Si desea podrá elegir otros medios de pagos tales como efectivo el cual será a través de recaudación en entidad bancaria o recaudadoras como Efecty o Baloto. Éste le generará un recibo de pago el cual tendrá un plazo máximo de 24 horas antes de caducar para poder realizar el pago.',
		],
	];
	$contar = 1;
?>

<div class="w3l_banner_nav_right">
<!-- faq -->
		<div class="faq">
			<h3 class="text-uppercase">preguntas frecuentes</h3>
			<div class="panel-group w3l_panel_group_faq" id="accordion" role="tablist" aria-multiselectable="true">

				<?php foreach ($faq as $q): ?>
					<?php if ($contar === 1): ?>
						<?php $collapse = 'in'; ?>
					<?php else: ?>
						<?php $collapse = ''; ?>
					<?php endif ?>
				  	<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
						  	<h4 class="panel-title asd">
								<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $contar; ?>" aria-expanded="true" aria-controls="collapse<?php echo $contar; ?>">
							  		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							  		<i class="glyphicon glyphicon-minus" aria-hidden="true"></i>
							  		<?php echo $q['pregunta']; ?>
								</a>
						  	</h4>
						</div>
						<div id="collapse<?php echo $contar; ?>" class="panel-collapse collapse <?php echo $collapse; ?>" role="tabpanel" aria-labelledby="headingOne">
						  	<div class="panel-body panel_text">
							  		<?php echo $q['respuesta']; ?>
						  	</div>
						</div>
					</div>
					<?php $contar++; ?>
				<?php endforeach ?>

			</div>
		</div>
<!-- //faq -->
</div>
<div class="clearfix"></div>