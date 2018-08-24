<?php $title = 'Adornos Navideños para cada ambiente en el hogar y más.'; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gte IE 9]>         <html class="no-js gte-ie9"> <![endif]-->
<!--[if gt IE 99]><!-->
<html lang="es"> 
<!-- Head -->
<head>
<!-- =======================================================
    Theme Name: ENNAVIDAD ECOMMERCE
    Author: jwebdev.com
    Author URL: https://jdevweb.com
======================================================= -->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo 'EnNavidad: '.$title; ?></title>
<meta name="description" content="Adornos y muñecos navideños, diseños exclusivos elaborados 100% a mano. Envíos a toda Colombia." />
<meta name="keywords" content="" />


<!-- Twitter Card data -->
<meta name="twitter:card" value="summary">

<!-- Open Graph data -->
<meta property="og:title" content="ADORNOS Y MUÑECOS NAVIDEÑOS." />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="ENNAVIDAD" />
<meta property="og:url" content="https://www.ennavidad.com/" />
<meta property="og:image" content="https://ennavidad.com/images/1.jpg" />
<meta property="og:description" content="Diseños exclusivos elaborados 100% a mano. Envíos a toda Colombia." />
<meta property="fb:app_id" content="711272785733854"/>
<!-- <meta property="og:title" content="<?php echo $og_tittle; ?>" />
<meta property="og:type" content="<?php echo $og_type; ?>" />
<meta property="og:site_name" content="ENNAVIDAD" />
<meta property="og:url" content="https://www.ennavidad.com/" />
<meta property="og:image" content="https://ennavidad.com/images/<?php echo $og_img; ?>" />
<meta property="og:description" content="<?php echo $og_description; ?>" />
<meta property="fb:app_id" content="711272785733854"/> -->
<base href="<?php echo URL_BASE; ?>" target="">

<!-- Styles -->
<link rel="icon" type="image/png" href="<?php echo URL_BASE; ?>images/favicon/favicon.png" />
<?php 
	$css = ['bootstrap.min','font-awesome.min','custom-min'];
	cssRequired($css);	
?>
<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- #Styles -->

	
<!-- javascript -->
<script  async  src="<?php echo ASSETS ?>js/jquery-1.11.1.min.js"></script>
<script type="text/javascript"> var base = '<?php echo URL_BASE; ?>'; </script>
<!-- <script type="text/javascript" src="<?php echo ASSETS ?>js/move-top.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>js/easing.js"></script> -->
<!-- #javascript -->

<!--  -->
<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false): ?>
	<?php require DIRECTORIO_ROOT.'inc/complements/analitycs.php'; ?>
	<?php require DIRECTORIO_ROOT.'inc/complements/facebook_sdk.php'; ?>
<?php endif; ?>


<?php include DIRECTORIO_ROOT.'inc/head/offer-bar.php'; ?>
<?php include DIRECTORIO_ROOT.'inc/head/principal-nav.php'; ?>

