<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>CONSULTAR PRODUCTOS DE UN ALMACEN - Alberto</h1>
<?php
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

	$almacenes = obtenerAlmacenes($conn);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div align="left">
		<label for="almacenes">Almacenes:</label>
		<select name="almacenes">
			<?php foreach($almacenes as $almacen) : ?>
				<option> <?php echo $almacen['num_almacen'] ?> </option>
			<?php endforeach; ?>
		</select>
</div>
		</br>
<?php
	echo '<div><input type="submit" value="Ver Productos"></div>
	</form>';
} else { 

	$almacen = $_POST['almacenes'];
	datosAlmacenes($conn, $almacen);	
}
?>

<?php
// Funciones utilizadas en el programa

function datosAlmacenes($conn, $almacen) {
	
	$sql = "select almacena.id_producto, producto.nombre as Nombre_Producto, precio, categoria.nombre as Nombre_Categoria, cantidad from almacena, producto, categoria where almacena.id_producto=producto.id_producto
	and categoria.id_categoria=producto.id_categoria and num_almacen='$almacen'";
	
	$resultado= mysqli_query($conn, $sql);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			echo "<table border='1'>";
			echo "Estos son todos los productos que se encuentran en el amacen ".$almacen."<br><br>";
			echo "<tr>";
				echo "<td>Id del Producto</td>";
				echo "<td>Nombre del Producto</td>";
				echo "<td>Precio del Producto</td>";
				echo "<td>Categoria del Producto</td>";
				echo "<td>Cantidad</td>";
				echo "</tr>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
				echo "<td>".$row['id_producto']."</td>";
				echo "<td>".$row['Nombre_Producto']."</td>";
				echo "<td>".$row['precio']."</td>";
				echo "<td>".$row['Nombre_Categoria']."</td>";
				echo "<td>".$row['cantidad']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "El almacen no tiene asignado ningun producto";
		}
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	

}

?>



</body>

</html>