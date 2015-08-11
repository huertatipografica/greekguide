<?php
header("Content-type: text/html; charset=utf-8"); // UTF 8
include('_functions.php');
include('fonts_list.php');

?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="author" content="Deva">
	<title>GreekGuide</title>
	<link type="text/css" href="css/estilos.css" rel="stylesheet" charset="utf-8">
	<style>
	<? echo $css?>
	</style>
</head>

<body class="signos">

	<div class="header">
		<h1>GreekGuide</h1>
		<p>Huerta Tipográfica</p>
	</div>

	<div class="menu">
		<?
		foreach ($signo as $glifo){
			if($glifo['char']!='None'){
			echo '<a href="glyph.php?nombre='.$glifo['nombre'].'" title="'.$glifo['nombre'].'"><span class="char">'.uni($glifo['char']).'</span><span class="nombre">'.$glifo['nombre'].'</span></a>'."\n";
			#echo $glifo['nombre'];
			}
		};
		?>
	</div>

	<div class="header">
		<p><a href="http://greekguide.huertatipografica.com">GreekGuide</a> Vesion 0.1 | Desarrollado por Andrés Torresi | <a href="http://www.huertatipografica.com/">Huerta Tipográfica</a> | <a href="https://github.com/huertatipografica/greekguide">Contribute on Github</a></p>
		<p>Podés descargar y modificar este software | Feel free to modify this software</p>
		<h2>Ayuda / Help</h2>
		<p>Put your devanagari fonts in «fonts» folder</p>
		<p>Using glyphs info from <?php echo $script ?>-glyphs.txt file</p>
		<p>Dictionary words from <a target="_blank" href="https://github.com/titoBouzout/Dictionaries/">titoBouzout</a></p>
	</div>

</body>
</html>