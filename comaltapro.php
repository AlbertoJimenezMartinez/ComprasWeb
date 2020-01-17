<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA PRODUCTOS - Alberto</h1>
<?php
require "conexion.php";

	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	/*Función que obtiene los departamentos de la empresa*/
	$categorias = obtenerCategorias($conn);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Producto</div>
<div class="card-body">
		<div class="form-group">
        ID PRODUCTO <input type="text" name="idproducto" placeholder="idproducto" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE PRODUCTO <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>
		<div class="form-group">
        PRECIO PRODUCTO <input type="number" name="precio" placeholder="precio" class="form-control">
        </div>
	<div class="form-group">
	<label for="categoria">Categorías:</label>
	<select name="categoria">
		<?php foreach($categorias as $categoria) : ?>
			<option> <?php echo $categoria['nombre'] ?> </option>
		<?php endforeach; ?>
	</select>
	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Alta Producto"></div>
	</form>';
} else { 

	$categoria = $_POST['categoria'];
	insertarProducto($conn, $categoria);
	
}
?>

<?php

function insertarProducto($conn, $nombrecat) {

	// Aquí va el código al pulsar submit

	// Definicion funcion error_function
	if (empty($_POST["idproducto"])) {
		trigger_error("La id del producto no puede estar vacia");
	}
	else {
	  $idproducto=$_POST['idproducto'];
	  limpiar_campos($idproducto);
	}
	if (empty($_POST["nombre"])) {
		trigger_error("El nombre no puede estar vacio");
	}
	else {
	  $nombre=$_POST['nombre'];
	  limpiar_campos($nombre);
	}
	if (empty($_POST["precio"])) {
		trigger_error("El precio no puede estar vacio");
	}
	else {
	  $precio=$_POST['precio'];
	  limpiar_campos($precio);
	}

	$id_cat=obtenerCodigoCategoria($conn, $nombrecat);

	$sql = "INSERT INTO producto (id_producto, nombre, precio, id_categoria) values ('$idproducto','$nombre','$precio','$id_cat')";
	
	if (mysqli_query($conn, $sql)) {
		echo "El producto se ha creado correctamente<br>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}



	




?>



</body>

</html>