<?php
session_start();
//si no has iniciado sesion, volvemos al login
if (!isset($_SESSION['nombre'])){
	header("Location: index.php");
}

	if ($_SESSION['nombre']!="admin") {
	
?>

<html>
	<meta charset="utf-8" />
	<head> <title> Menu Database COMPRASWEB </title>
	</head>
	<body>
		<h1>Menu Database COMPRASWEB - Alberto</h1>
		</br>
		<?php
			echo "Sesion Iniciada con el usuario: ".$_SESSION['nombre'];
		?>
		<br><br>
		<form action='compro2.php' method='post'><input type='submit' value='Comprar un producto'></form></br>		
		<form action='comconscom2.php' method='post'><input type='submit' value='Consultar Compras'></form></br>	
		
		<br><br><a href='logout.php'>Cerrar sesion</a>

	</body>
</html>
<?php
} else {
	
?>
<html>
	<meta charset="utf-8" />
	<head> <title> Menu Database COMPRASWEB </title>
	</head>
	<body>
		<h1>Menu Database COMPRASWEB - Alberto</h1>
		</br>
		<?php
			echo "Sesion Iniciada con el usuario: ".$_SESSION['nombre'];
		?>
		</br></br>
		<form action='compro2.php' method='post'><input type='submit' value='Comprar un producto'></form>	
		<form action='comconscom2.php' method='post'><input type='submit' value='Consultar Compras'></form>	
		<form action='comconstock.php' method='post'><input type='submit' value='Consultar Stock'></form>
		<form action='comconsalm.php' method='post'><input type='submit' value='Consultar Almacen'></form>
		<form action='comaprpro.php' method='post'><input type='submit' value='Aprovisionar Almacenes'></form>
		<form action='comaltapro.php' method='post'><input type='submit' value='Dar de alta un producto'></form>
		<form action='comaltaalm.php' method='post'><input type='submit' value='Dar de alta un almacen'></form>	
		<form action='comaltacat.php' method='post'><input type='submit' value='Dar de alta una categoria'></form>
		<form action='comaltacli2.php' method='post'><input type='submit' value='Registrar Cliente'></form>	
		<form action='compro.php' method='post'><input type='submit' value='Comprar Productos forma 1'></form>	
		
		<br><br><a href='logout.php'>Cerrar sesion</a>
	</body>
</html>
<?php
}
?>
