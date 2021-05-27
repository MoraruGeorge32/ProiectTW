<?php
include 'info_tara.php';
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="styles.css">
        <script src="./script.js"></script>
</head>

<body>
	<!--De inserat si alte chestii mai atractive vizual cum ar fi un steag al tarii sau o harta geografica a tarii-->
	<div class="info_generl">
		<h1 id="nume_tara"></h1>
		<h2>Info general: <?php echo tara_detalii("Rusia"); ?> </h2>
		<p>[@descriere]</p>
	</div>
	<h2>Incidente teroriste:</h2>
	<ol>
		<li>Afisat pentru fiecare incident inregistrat detalii</li>
	</ol>
</body>

</html>