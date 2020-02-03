<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>COMPRAR PRODUCTOS - Alberto</h1>
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

	$productos = obtenerProductos($conn);
	$clientes = obtenerClientes($conn);

	
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
		<label for="clientes">Clientes:</label>
		<select name="clientes">
			<?php foreach($clientes as $cliente) : ?>
				<option> <?php echo $cliente['nif'] ?> </option>
			<?php endforeach; ?>
		</select>
		<br><br>
		<div class="form-group">
        Cantidad  &nbsp <input type="number" name="cantidad" class="form-control">
        </div>
</div>
		</br>
<?php
	echo '<div><input type="submit" value="Comprar"></div>
	</form>';
} else { 

	$cliente = $_POST['clientes'];
	$producto = $_POST['productos'];
	comprar($conn, $cliente, $producto);	
}
?>

<?php
// Funciones utilizadas en el programa

function comprar($conn, $nif, $producto) {
	$cantidad;
	if (empty($_POST["cantidad"])) {
		trigger_error("La cantidad no puede estar vacia");
	}
	else {
	  $cantidad=$_POST['cantidad'];
	  limpiar_campos($cantidad);
	}
	
	$idProducto=obtenerIdProducto($conn, $producto);

	$sqlCantidad = "select sum(cantidad) from almacena where id_producto='$idProducto'";
	$resultado=mysqli_query($conn, $sqlCantidad);
	if ($resultado) {
		$row=mysqli_fetch_assoc($resultado);
		$resultadoCantidad=$row['sum(cantidad)'];
		if ($cantidad>$resultadoCantidad) {
			echo "La cantidad del producto solicitado no esta disponible<br>";
		} else {
			$sql = "insert into compra (nif, id_producto, fecha_compra, unidades) values ('$nif','$idProducto',date_format(sysdate(), '%Y-%m-%d %H:%i:%s'),'$cantidad')";
			if (mysqli_query($conn, $sql)) {
				echo "La compra se ha realizado con exito";					
			} else {
				trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
			}
			
            $cont=0;
            $almacen=10;
            while($cantidad>$cont){
                $sql="select cantidad from almacena where id_producto='$idProducto' and num_almacen='$almacen'";
                $resultado=mysqli_query($conn, $sql); 
                $row=mysqli_fetch_assoc($resultado);
                $unidades=$row['cantidad'];
                if($unidades>0){ 
                    $sql="update almacena set cantidad=cantidad-1 where id_producto='$idProducto' and num_almacen='$almacen'";
                    
					if (mysqli_query($conn, $sql)) {
						$cont++;					
					} else {
						trigger_error("Error: " . $sql . "<br>" . mysqli_error($conn));
					}
                   
                }
                else{ 
                    $almacen+=10;
                }
            }
			
			
		}
		
		
	} else {
		trigger_error("Error: " . $sqlCantidad . "<br>" . mysqli_error($conn));
	}


}

?>



</body>

</html>