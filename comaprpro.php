<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ASIGNAR PRODUCTOS AL ALMACEN - Alberto</h1>
<?php
session_start();
require "conexion.php";
//si no has iniciado sesion, volvemos al login
if (!isset($_SESSION['nombre'])){
	header("Location: index.php");
}
	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	$productos = obtenerProductos($conn);
	$almacenes = obtenerAlmacenes($conn);

	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div align="left">
		<label for="productos">Productos:</label>
		<select name="productos">
			<?php foreach($productos as $producto) : ?>
				<option> <?php echo $producto['nombre'] ?> </option>
			<?php endforeach; ?>
		</select>
		<br><br>
		<label for="almacenes">Almacenes:</label>
		<select name="almacenes">
			<?php foreach($almacenes as $almacen) : ?>
				<option> <?php echo $almacen['num_almacen'] ?> </option>
			<?php endforeach; ?>
		</select>
		<br><br>
		<div class="form-group">
        Cantidad  &nbsp <input type="number" name="cantidad" class="form-control">
        </div>
</div>
		</br>
<?php
	echo '<div><input type="submit" value="Asignar Productos"></div>
	</form>';
	echo '<form action="cominicio.php" method="post"><input type="submit" value="Volver"></form><div>';

} else { 

	$almacen = $_POST['almacenes'];
	$producto = $_POST['productos'];
	hacerRelacion($conn, $almacen, $producto);	
}
?>

<?php
// Funciones utilizadas en el programa

function hacerRelacion($conn, $almacen, $producto) {
	
	if (!empty($_POST["cantidad"])) {
	  $cantidad=$_POST['cantidad'];
	  limpiar_campos($cantidad);
	} else {
		$cantidad="";
	}

	$idProducto=obtenerIdProducto($conn, $producto);
	$sql = "INSERT INTO almacena (num_almacen, id_producto, cantidad) values ('$almacen','$idProducto','$cantidad')";
	
	if (mysqli_query($conn, $sql)) {
		echo "La relacion entre producto y almacen se ha creado correctamente<br>";
	} else {
		trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
	}

}

?>



</body>

</html>