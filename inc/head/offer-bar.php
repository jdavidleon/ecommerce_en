	
<!-- Modal -->
	<div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
		    <div class="modal-content" style="border-radius: 0;">
		      	<div class="modal-body" style="padding: 0;">
		       		<div class="row" style="padding: 0; margin: 0;">
		       			<div class="col-sm-6" style="padding: 0;">
		      				<img style="width: 100%; height: 100%;" src="<?php echo URL_BASE; ?>images/ennavidad-modal.png" >
		      			</div>
		      			<div class="col-sm-6 text-center container-form-newletter" style="">
		      				<h4 class="text-center" style="margin-top: 80px; color: #86c336;">
			      				<b>
			      					SUBSCRÍBETE A NUESTRO BOLETÍN
			      				</b>
			      			</h4>
		      				<hr style="margin: 20px 0 10px 0;">
		      				<small class="text-center text-uppercase" style="color: #86c336;">
		      					<b>
		      						te informaremos de nuevos productos, ofertas, eventos y productos especiales.
		      					</b>
		      				</small>
		      				<hr style="margin: 10px 0 20px 0;">

		      				<!-- FORM -->
		      				<form action="<?php echo URL_BASE ?>bd/newsletter/register.php" method="POST" role="form">
		      					<input type="hidden" name="empt_val">
			      				<div class="form-group">
			      					<input style="padding: 10px; height: 45px;" type="mail" class="form-control text-center text-uppercase" name="correo_news" placeholder="Tu correo" required>
			      				</div>
					       		<input type="submit" style="border-radius: 0; height: 45px; background-color: #8DC455; border-color: none !important;" class="btn btn-success btn-block" value="REGISTRARME">
		      				</form>
		      				<!-- FORM -->


				       		<br>
				       		<div class="row" style="padding-bottom: 30px; margin-top: 20px;">
				       			<div class="col-sm-12 text-center">
				       				<small class="text-center">
				       					<a href="" style="font-size: 89%; color: black; opacity: .6; float: none;  text-decoration: underline;" class="close text-center" data-dismiss="modal" aria-label="Close">
				       						NO DESEO SUBSCIBIRME AÚN
				       					</a>
				       				</small>
				       			</div>
				       		</div>
		      			</div>
		       		</div>

		      	</div>
		    </div>
	  	</div>
	</div>
<!-- #Modal -->
<div class="container-fluid offer-bar">
	<div class="row">
		<div class="col-sm-7">
			<div class="w3l_offers text-center">					
				<a href="<?php echo URL_BASE.'page/coleccion/ofertas' ?>" style="">
					<u>
						Descuentos de hasta el 30%
					</u>
				</a>
			</div>
		</div>
		<div class="col-sm-5">
			<ul class="list-inline list-contact-offer">
				<li>
					<a href="https://api.whatsapp.com/send?l=es&phone=57<?php echo $whatsapp; ?>&text=<?php echo $wappTxt; ?>" class="link-white link-underline" target="_blank">
						<i class="fa fa-whatsapp" aria-hidden="true"></i> <?php echo $whatsapp; ?>
					</a>
				</li>
				<li>
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<a class="link-white" href="mailto:adornos@ennavidad.com"> adornos@ennavidad.com</a>
				</li>
			</ul>
		</div>
	</div>
</div>

