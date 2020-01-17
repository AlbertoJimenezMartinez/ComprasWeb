<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CATEGORÍAS - Alberto</h1>
<?php
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
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Categoría</div>
<div class="card-body">
		<div class="form-group">
        ID CATEGORIA <input type="text" name="idcategoria" placeholder="idcategoria" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE CATEGORIA <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>

		</BR>
<?php
	echo '<div><input type="submit" value="Alta Categoría"></div>
	</form>';
} else { 

	// Aquí va el código al pulsar submit
   crearCategoria($conn);
	
}
?>

<?php
// Funciones utilizadas en el programa

function crearCategoria($conn) {

	// Definicion funcion error_function
	if (empty($_POST["idcategoria"])) {
		trigger_error("La id no puede estar vacia");
	}
	else {
	  $id=$_POST['idcategoria'];
	  limpiar_campos($id);
	}
	if (empty($_POST["nombre"])) {
		trigger_error("El nombre no puede estar vacio");
	}
	else {
	  $nombre=$_POST['nombre'];
	  limpiar_campos($nombre);
	}

	$sql = "INSERT INTO categoria (id_categoria, nombre) values ('$id','$nombre')";


	//insertamos el empleado
	if (mysqli_query($conn, $sql)) {
		echo "La categoria se ha creado correctamente<br>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}


	




?>



</body>

</html>