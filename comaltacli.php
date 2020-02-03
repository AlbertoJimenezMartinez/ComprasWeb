<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CLIENTES - Alberto</h1>
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
<div class="card-header">Datos Cliente</div>
<div class="card-body">
		<div class="form-group">
        DNI &nbsp <input type="text" name="dni" class="form-control">
        </div>
		<div class="form-group">
        Nombre  &nbsp <input type="text" name="nombre" class="form-control">
        </div>
		<div class="form-group">
        Apellidos &nbsp <input type="text" name="apellidos" class="form-control">
        </div>
		<div class="form-group">
       Codigo Postal &nbsp <input type="text" name="cp" class="form-control">
        </div>
		<div class="form-group">
        Ciudad &nbsp <input type="text" name="ciudad" class="form-control">
        </div>
		<div class="form-group">
        Direccion &nbsp <input type="text" name="direccion" class="form-control">
        </div>
		

		</br>
<?php
	echo '<div><input type="submit" value="Alta Cliente"></div>
	</form>';
} else { 

	// Aquí va el código al pulsar submit
   crearCliente($conn);
	
}
?>

<?php
// Funciones utilizadas en el programa

function crearCliente($conn) {

	// Definicion funcion error_function
	if (empty($_POST["dni"])) {
		trigger_error("El dni no puede estar vacio");
	}
	else if (strlen($_POST["dni"])==9){
		
		$dni=$_POST['dni'];
		$formato=preg_match('/[0-9]{8}[A-Za-z]/', $dni);
		if($formato!=1){//devulve 1 si es correcto
			trigger_error("El dni no es correcto");
		}
		else {
		  limpiar_campos($dni);
		}
		
	} else {
		trigger_error("El dni no tiene 8 caracteres");
	}
	
	if (empty($_POST["nombre"])) {
		trigger_error("El nombre no puede estar vacio");
	}
	else {
	  $nombre=$_POST['nombre'];
	  limpiar_campos($nombre);
	}
	
	if (empty($_POST["apellidos"])) {
		trigger_error("Los apellidos no pueden estar vacios");
	}
	else {
	  $apellidos=$_POST['apellidos'];
	  limpiar_campos($apellidos);
	}
	
	if (empty($_POST["cp"])) {
		trigger_error("El codigo postal no puede estar vacio");
	}
	else {
	  $cp=$_POST['cp'];
	  limpiar_campos($cp);
	}
	
	if (empty($_POST["ciudad"])) {
		trigger_error("La ciudad no puede estar vacia");
	}
	else {
	  $ciudad=$_POST['ciudad'];
	  limpiar_campos($ciudad);
	}
	
	if (empty($_POST["direccion"])) {
		trigger_error("La direccion no puede estar vacia");
	}
	else {
	  $direccion=$_POST['direccion'];
	  limpiar_campos($direccion);
	}

	$sql = "INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad) values ('$dni','$nombre','$apellidos','$cp','$direccion','$ciudad')";


	//insertamos el empleado
	if (mysqli_query($conn, $sql)) {
		echo "El cliente se ha creado correctamente<br>";
	} else {
		trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
	}

}

?>



</body>

</html>