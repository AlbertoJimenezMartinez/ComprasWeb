<?php

function conectarBD() {
	/* Conexión BD */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootroot');
define('DB_DATABASE', 'COMPRASWEB');
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   if (!$conn) {
		die("Error conexión: " . mysqli_connect_error());
	}
	
	return $conn;
}

function limpiar_campos($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Definicion funcion error_function
function errores ($error_level,$error_message,$error_file, $error_line, $error_context) {
  echo "<b> Codigo error: </b> $error_level  <br><b> Mensaje: </b> $error_message  <br><b> Fichero: </b> $error_file <br><b> Linea: </b>$error_line<br> ";
  //echo "<b>Array--> </b> <br>";
  //var_dump($error_context);
  echo "<br>";
  die();  

}

function obtenerCategorias($conn) {
	$categorias = array();
	
	$sql = "SELECT nombre FROM categoria";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$categorias[] = $row;
		}
	}
	
	return $categorias;
}

function obtenerCodigoCategoria($conn, $nombrecat) {
	$idCategoria = null;
	
	$sql = "SELECT id_categoria FROM categoria WHERE nombre = '$nombrecat'";
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$idCategoria = $row['id_categoria'];
		}
	}
	
	return $idCategoria;
	
}

function obtenerAlmacenes($conn) {
	$almacenes = array();
	
	$sql = "SELECT num_almacen FROM almacen";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$almacenes[] = $row;
		}
	}
	
	return $almacenes;
}

function obtenerProductos($conn) {
	$productos = array();
	
	$sql = "SELECT nombre FROM producto";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$productos[] = $row;
		}
	}
	
	return $productos;
}

function obtenerIdProducto($conn, $nombreProducto) {
	$idProducto = null;
	
	$sql = "SELECT id_producto FROM producto WHERE nombre = '$nombreProducto'";
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$idProducto = $row['id_producto'];
		}
	}
	
	return $idProducto;
	
}

function obtenerClientes($conn) {
	$clientes = array();
	
	$sql = "SELECT nif FROM cliente";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$clientes[] = $row;
		}
	}
	
	return $clientes;
}



?>
