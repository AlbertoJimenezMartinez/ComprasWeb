<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>LOGIN - Alberto</h1>
<?php
session_start();
if (!isset($_POST) || empty($_POST)){
	session_unset();
	session_destroy(); 
}
require "conexion.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST) /* || $_SESSION['nombre']!="" */) { 
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-body">
		<div class="form-group">
        Nombre Usuario &nbsp <input type="text" name="nombre" class="form-control" required>
        </div>
		<div class="form-group">
        Contraseña  &nbsp <input type="text" name="contraseña" class="form-control" required>
        </div>
		</br>
<?php
	echo '<div><input type="submit" value="Inicio de Sesion"></div>
	</form>';
	 echo " o <a href='comaltacli2.php'>Registrate</a>";
} else { 

	// Aquí va el código al pulsar submit
   iniciosesion($conn);
	
}
?>

<?php
// Funciones utilizadas en el programa

function iniciosesion($conn) {

	// Definicion funcion error_function	
	$nombre=$_POST['nombre'];
	limpiar_campos($nombre); 
	$contraseña=strrev($_POST['contraseña']);

	$sql = "select nif from cliente where nombre='$nombre' and apellido='$contraseña'";
	//insertamos el empleado
	$resultado= mysqli_query($conn, $sql);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			$row = mysqli_fetch_assoc($resultado);
			$_SESSION['nombre'] = $nombre;
			$_SESSION['nif'] = $row['nif'];
			$_SESSION['cesta'] = array();
		/* 	$cookie_name = "usuario";
			$cookie_value = $nombre. " ".$contraseña;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); */
			
			echo "Has iniciado Sesion: ".$_SESSION['nombre'];
			echo "<br><br><a href='cominicio.php'>Ir a los distintos metodos</a>";
			echo "<br><br><a href='logout.php'>Cerrar Sesion</a>";
			
		} else {
			echo "Los datos introducidos no son correctos";
			echo "<br><br><a href='index.php'>Volver</a>";
		}
	} else {
		trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
	}
	
	

}
/* 
function sesioniniciada($conn) {

	// Definicion funcion error_function	
	  $nombre=$_POST['nombre'];
	  limpiar_campos($nombre); 
	  $contraseña=strrev($_POST['contraseña']);

	$sql = "select nif from cliente where nombre='$nombre' and apellido='$contraseña'";

	// insertamos el empleado
	$resultado= mysqli_query($conn, $sql);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			$row = mysqli_fetch_assoc($resultado);
			$_SESSION['nombre'] = $nombre;
			$cookie_name = "usuario";
			$cookie_value = $nombre. " ".$contraseña;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
			
			echo "Has iniciado Sesion: ".$_SESSION['nombre'];
			echo "<br><br><a href='cominicio.html'>Ir a los distintos metodos</a>";
			echo "<br><br><a href='logout.php'>Cerrar Sesion</a>";
			
		} else {
			echo "Los datos introducidos no son correctos";
			echo "<br><br><a href='login.php'>Volver</a>";
		}
	} else {
		trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
	}
	
	

} */

?>



</body>

</html>