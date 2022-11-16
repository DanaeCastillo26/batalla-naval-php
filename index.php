<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

	<h1>BATALLA NAVAL</h1>

	<form action="tablero.php" method="post">
		<label>
			Nombre del jugador 1
			<input type="text" class="caja" name="nombre1" required>
		</label>
		<label>
			Nombre del jugador 2
			<input type="text" class="caja" name="nombre2" required>
		</label>
		<button type="submit" class="btn">Iniciar juego</button>
	</form>

</body>
</html>