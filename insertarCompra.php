<?php
session_start();
//si no has iniciado sesion, volvemos al login
if (!isset($_SESSION['nombre'])){
	header("Location: index.php");
}
include "conexion.php";

set_error_handler("errores"); 

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ESTADO DE LA COMPRA - Alberto</h1>

<?php

$conn=conectarBD();

	$nif=$_SESSION['nif'];
	foreach ($_SESSION['cesta'] as $idProducto => $cantidad){
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

	echo '<form action="cominicio.php" method="post"><input type="submit" value="Ir a metodos del cliente"></form><div>';
	
	echo "<br><br><a href='logout.php'>Cerrar sesion</a>";
	
	$_SESSION['cesta']=array(); 
?>
