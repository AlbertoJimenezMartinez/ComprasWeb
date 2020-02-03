<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
 <h1>CONSULTA DE COMPRAS ENTRE DOS FECHAS - ALBERTO</h1>
<?php
session_start();

require "conexion.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div align="left">
		<label for="fechaIni">Introduzca la fecha desde la que empezar a buscar:&nbsp &nbsp  </label><input type='date' name='fechaIni'><br>
		<label for="fechaFin">Introduzca la fecha para terminar de buscar:&nbsp &nbsp </label><input type='date' name='fechaFin'><br>
</div>
		</br>
<?php
	echo '<div><input type="submit" value="Buscar Compras"></div>
	</form>';
} else { 

	$cliente = $_SESSION["nif"];
	buscarCompras($conn, $cliente);	
}
?>

<?php
// Funciones utilizadas en el programa

function buscarCompras($conn, $nif) {
	
	if (empty($_POST["fechaIni"])) {
		trigger_error("La fecha de inicio no puede estar vacia");
	}
	else {
	  $fecha=strtotime($_REQUEST['fechaIni']);
	  $fechaInicio=date("Y-m-d",$fecha);
	} 
	if (empty($_POST["fechaFin"])) {
		trigger_error("La fecha de fin no puede estar vacia");
	}
	else {
	  $fecha=strtotime($_REQUEST['fechaFin']);
	  $fechaFin=date("Y-m-d",$fecha);
	} 
	
	$sql = "select compra.id_producto, nombre, precio, fecha_compra, unidades from producto, compra where compra.id_producto=producto.id_producto
	and nif='$nif' and (fecha_compra>='$fechaInicio' and fecha_compra<='$fechaFin')";
	$resultado= mysqli_query($conn, $sql);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			echo "<table border='1'>";
			echo "Estos son todos los productos del cliente ".$nif."<br><br>";
			echo "<tr>";
				echo "<td>Id del producto</td>";
				echo "<td>Nombre del producto</td>";
				echo "<td>Precio del producto</td>";
				echo "<td>Fecha de compra del producto</td>";
				echo "<td>Unidades</td>";
				echo "</tr>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
				echo "<td>".$row['id_producto']."</td>";
				echo "<td>".$row['nombre']."</td>";
				echo "<td>".$row['precio']."</td>";
				echo "<td>".$row['fecha_compra']."</td>";
				echo "<td>".$row['unidades']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "El cliente no hizo ninguna compra entre esas fechas";
		}
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}

?>



</body>

</html>