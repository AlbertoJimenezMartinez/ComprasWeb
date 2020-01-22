<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>CONSULTAR STOCK PRODUCTOS - Alberto</h1>
<?php
require "conexion.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	$productos = obtenerProductos($conn);
	
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
</div>
		</br>
<?php
	echo '<div><input type="submit" value="Ver Stock"></div>
	</form>';
} else { 

	$producto = $_POST['productos'];
	stock($conn, $producto);	
}
?>

<?php
// Funciones utilizadas en el programa

function stock($conn, $producto) {
	
	$idProducto=obtenerIdProducto($conn, $producto);

	$sql = "select almacen.num_almacen, localidad, cantidad from almacen, almacena where almacena.num_almacen=almacen.num_almacen and id_producto='$idProducto'";
	
	$resultado= mysqli_query($conn, $sql);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			echo "<table border='1'>";
			echo "Estos son todos los almacenes donde esta el producto ".$producto."<br><br>";
			echo "<tr>";
				echo "<td>Numero de Almacen</td>";
				echo "<td>Localidad del Almacen</td>";
				echo "<td>Cantidad</td>";
				echo "</tr>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
				echo "<td>".$row['num_almacen']."</td>";
				echo "<td>".$row['localidad']."</td>";
				echo "<td>".$row['cantidad']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "El producto no tiene asignado ningun almacen";
		}
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	

}

?>



</body>

</html>