<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA ALMACEN - Alberto</h1>
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

	
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Almacen</div>
<div class="card-body">

		<div class="form-group">
        Localidad  &nbsp <input type="text" name="localidad" class="form-control">
        </div>
		</br>
<?php
	echo '<div><input type="submit" value="Alta Almacen"></div>
	</form>';
} else { 

	// Aquí va el código al pulsar submit
   crearAlmacen($conn);
	
}
?>

<?php
// Funciones utilizadas en el programa

function crearAlmacen($conn) {

	if (empty($_POST["localidad"])) {
		trigger_error("La localidad no puede estar vacia");
	}
	else {
	  $localidad=$_POST['localidad'];
	  limpiar_campos($localidad);
	}

$num="";
$sqlCod= "select max(num_almacen) from almacen";
$resultado= mysqli_query($conn, $sqlCod);
if ($resultado) {
	if (mysqli_num_rows($resultado)>0) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$num=$row["max(num_almacen)"];
			settype($num,'integer');
			$num=$num+10;
		}
	}
 
} else {
    $num="10";
	
}


	$sql = "INSERT INTO almacen (num_almacen, localidad) values ('$num','$localidad')";

	if (mysqli_query($conn, $sql)) {
		echo "El almacen se ha creado correctamente<br>";
	} else {
		trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
	} 

}

?>



</body>

</html>