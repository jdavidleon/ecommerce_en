<?php 
	
	$events = [
		[
			'date' => 'OCTUBRE 29',
			'title' => 'Feria navideña',
			'desciption' => 'Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis 
							voluptatibus.',
			'brr' => 'Galerias',
			'address' => '1355 Market Street, Suite 900',
			'city' => ' San Francisco, CA 94103',
			'hour' => '8:00 am a 6:00pm',
		],
		[
			'date' => 'OCTUBRE 30',
			'title' => 'Feria navideña',
			'desciption' => 'Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis 
							voluptatibus.',
			'brr' => 'Galerias',
			'address' => '1355 Market Street, Suite 900',
			'city' => ' San Francisco, CA 94103',
			'hour' => '8:00 am a 6:00pm',
		],
	];

?>

<div class="w3l_banner_nav_right">
<!-- events -->
		<div class="events">
			<h3>Eventos</h3>
			<div class="w3agile_event_grids">

				<?php foreach ($events as $event): ?>
					<div class="col-md-12 w3agile_event_grid">
						<div class="col-md-3 col-sm-12 w3agile_event_grid_left text-center">
							<i class="fa fa-calendar" aria-hidden="true"></i>
							<p><b><?php echo $event['date']; ?></b></p>
						</div>
						<div class="col-md-9 col-sm-12 w3agile_event_grid_right">
							<h4><?php echo $event['title']; ?></h4>
							<p><?php echo $event['desciption']; ?>
							<address>
							  	<strong><?php echo $event['brr']; ?></strong><br>
							  	<?php echo $event['address']; ?><br>
							 	<?php echo $event['city']; ?><br>
							  	Hora: <?php echo $event['hour']; ?>
							</address></p>
						</div>
						<div class="clearfix"> </div>
					</div>
				<?php endforeach ?>

				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //events -->
		</div>
		<div class="clearfix"></div>