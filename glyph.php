<?php
header("Content-type: text/html; charset=utf-8"); // UTF 8
include('_functions.php');
include('fonts_list.php');

$nombre = $_GET['nombre'];
$glifo = $signo[$nombre];
$char = uni($glifo['char']);
$fonts = array_merge($fuentes2, $fuentes);

// Empty variables to start
$thumbsBig = '';
$thumbsWord = '';
$textoPrueba = '';

foreach ($fonts as $fuente){
	$nombre_fuente=substr($fuente, 0, -4);
	$thumbsBig.='<div class="thumbBig" style="font-family:\''.$nombre_fuente.'\', AdobeBlank">'.$char.'<label>'.$nombre_fuente.'</label></div>'."\n";
	$thumbsWord.='<div class="thumbWord" style="font-family:\''.$nombre_fuente.'\', AdobeBlank">'.'<span class="dyntext">'.$char.'αεηιμρagnv</span><label>'.$nombre_fuente.'</label></div>'."\n";
}

#Array of words from dictionary
$words = explode(PHP_EOL, file_get_contents("$script-dictionary.txt"));

#busca signo
$wordlist=array();
$uppercase = ($glifo['subcategoria'] == 'Uppercase') ? true : false;
if ($uppercase) {
		$char = mb_convert_case($char, MB_CASE_LOWER, 'UTF-8');
	}

foreach($words as $word){
	$pos = strpos($word, strtolower($char));
	if ($pos == true) {
		if ($uppercase) {
			array_push($wordlist, $word);
		}
		array_push($wordlist, $word);
	}
}

#arma palabras aleatorias hasta 50
for($i=0;$i<10;$i++){
	$index=rand(0,(count($wordlist)-1));
	$textoPrueba.=$wordlist[$index].' ';
}
// $textoPrueba='NaN';

if ($uppercase) {
		$textoPrueba = mb_convert_case($textoPrueba, MB_CASE_UPPER, 'UTF-8');
	}

?>
<!DOCTYPE html>
<html>
<head>
<?php include 'meta.php'; ?>
<title>GreekGuide- <?php echo $glifo['nombre'] ?></title>
<style>
<?php echo $css?>
</style>
<link type="text/css" href="css/estilos.css" rel="stylesheet" charset="utf-8">
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script>
$(function() {
    var fSizeArray = new Array('48', '72', '90', '100', '125', '150', '175', '200', '250', '300');
    $('#slider').slider({
        value: 4,
        min: 0,
        max: 9,
        step: 1,
        slide: function(event, ui) {
            var vfSizeArray = fSizeArray[ui.value];
            $('#font_size').val(vfSizeArray + ' px');
            $('.thumbWord').css('font-size', vfSizeArray + 'px' );
        }
    });
    $('#font_size').val((fSizeArray[$('#slider').slider('value')]) + ' px');
});
$(function() {
    var fSizeArray = new Array('18', '24', '36', '40', '50', '64', '72');
    $('#sliderb').slider({
        value: 4,
        min: 0,
        max: 6,
        step: 1,
        slide: function(event, ui) {
            var vfSizeArray = fSizeArray[ui.value];
            $('#font_sizeb').val(vfSizeArray + ' px');
            $('#contexto').css('font-size', vfSizeArray + 'px' );
        }
    });
    $('#font_sizeb').val((fSizeArray[$('#slider').slider('value')]) + ' px');
});
</script>
</head>

<body>
	<div id="left">
		<div class="container">

			<a href="index.php" class="button">« back</a><br /><br />
			<table id="data" cellpading=0 cellspacing=0>
				<tr><th>Category</th><td><?php echo $glifo['categoria']?></td></tr>
				<tr><th>Subcategory</th><td><?php echo $glifo['subcategoria']?></td></tr>
				<tr><th>Name</th><td><?php echo $glifo['nombre']?></td></tr>
				<tr><th>Character</th><td><?php echo uni($glifo['char'])?></td></tr>
				<tr><th>Unicode</th><td><?php echo $glifo['char']?></td></tr>

				<tr><th colspan="2">Description</th></tr>
				<tr><td colspan="2"><?php echo $glifo['descripcion']?></td></tr>
			</table>


		</div>
	</div>

	<div id="main">
		<div class="container">

			<h2><?php echo $glifo['nombre'] ?></h2>

			<div class="thumbs">
				<?php echo $thumbsBig ?>
			</div>

			<div id="inputtext">
				Change preview: <input id="slide" type="text" value="<?php echo $char.'αεηιμρagnv' ?>"
				onchange="updateText(this.value);" />
			</div>

			<div id="slider" style="width: 200px; display: inline-block; margin: 0 7px 7px 0;"></div>
			<input type="text" id="font_size" style="border:0; color:#222; font-weight:bold; vertical-align: top">

			<div class="thumbs">
				<?php echo $thumbsWord ?>
			</div>

			<h2>Words containing <?php echo $glifo['nombre'] ?></h2>
			<p><?php echo 'Mostrando 100 de '.count($wordlist).' palabras encontradas. ('.count($words).' total)'?></p>

			<select id="preview_font" onchange="setfont();">
				<option value="">Default</option>
				<?php
				foreach ($fonts as $fuente) {
					$nombre_fuente=substr($fuente, 0, -4);
					echo '<option value="\''.$nombre_fuente.'\',UnicodeFallback">'.$nombre_fuente.'</option>';
				}
				?>
			</select>

			<div id="sliderb" style="width: 200px; display: inline-block; margin: 0 7px 0; vertical-align: middle"></div>
			<input type="text" id="font_sizeb" style="border:0; color:#222; font-weight:bold;">

			<div class="contexto" id="contexto" contenteditable="true">
				<?php echo $textoPrueba?>
			</div>

		</div>
	</div>

<script type="text/javascript">
	function setfont() {
		var e = document.getElementById("preview_font");
		var myfont = e.options[e.selectedIndex].value;

		var texto_ejemplo = document.querySelector('#contexto');
		texto_ejemplo.setAttribute("style","font-family: " + myfont);
	}
	// Text input for change texts
	function updateText(inputtext) {
		var tipos = document.getElementsByClassName('dyntext'),
		i = tipos.length;

		while(i--) {
			tipos[i].innerHTML =inputtext;
		}
	}
	// Drag boxes
	$(function() {
		$( ".thumbs" ).sortable();
		$( ".thumbs" ).disableSelection();
	});
</script>
</body>
</html>