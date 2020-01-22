<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <h1>CONSULTA DE COMPRAS - RUBEN FEITO</h1>
<?php
require "funciones.php";
include "conexion.php";

set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores

$conn=conectarBD(); //conexion

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 
    /* Se inicializa la lista valores*/
    $clientes = obtenerClientes($conn);

	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos</div>
<div class="card-body">
<div class="form-group">
	<div class="form-group">
	<label for="cliente">NIF CLIENTE:</label>
	<select name="cliente">
	<?php foreach($clientes as $cliente) : ?>
    		<option> <?php echo $cliente ?> </option>
    	<?php endforeach; ?>
	</select>
	</div>
    <div class="form-group">
        FECHA DESDE<input type="date" name="fecha_ini"" class="form-control">
    </div>
    <div class="form-group">
        FECHA HASTA<input type="date" name="fecha_fin" class="form-control">
    </div>
		</BR>
<?php
	echo '<div><input type="submit" value="Consultar Compras"></div>
	</form>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") { //comprobacion de request_method para el submit (valdria con un else)
	//recogida de datos 

	// Aquí va el código al pulsar submit
    $cliente=$_REQUEST["cliente"]; //el del selector

    $fecha_ini=strtotime($_REQUEST["fecha_ini"]);
    $fecha_ini=date("Y-m-d", $fecha_ini);
    if($fecha_ini==''){ 
		trigger_error('La Fecha de inico no puede estar en blanco');
    }
    
    $fecha_fin=strtotime($_REQUEST["fecha_fin"]);
    $fecha_fin=date("Y-m-d", $fecha_fin);
    if($fecha_fin==''){ 
		trigger_error('La Fecha de fin no puede estar en blanco');
    }

    if($fecha_ini>$fecha_fin){
        trigger_error('La Fecha de fin debe ser mayor que la Fecha inicio y viceversa');
    }

    query($conn, $cliente, $fecha_ini, $fecha_fin);
}

desconectarBD($conn); //desconexion

?>

<?php
// Funciones utilizadas en el programa
function obtenerClientes($dbname) {
	$clientes = array();
	
	$sql = "SELECT nif FROM CLIENTE";
	
	$resultado = mysqli_query($dbname, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$clientes[] = $row['nif'];
		}
	}
	return $clientes;
}

function query($conn, $cliente, $fecha_ini, $fecha_fin){
    $compras = array();
    $sql="SELECT fecha_compra FROM COMPRA WHERE DATE_FORMAT(fecha_compra,'%Y-%m-%d')>='$fecha_ini' AND DATE_FORMAT(fecha_compra,'%Y-%m-%d')<='$fecha_fin'";
    $resultado=mysqli_query($conn, $sql);
    if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
            $compras[] = $row['fecha_compra'];
		}
    }

    if(count($compras)==0){
        echo "El Cliente no realizo compras entre esas fechas";
    }
    else{
        $total=0;
        foreach ($compras as $compra){
            $sql="SELECT COMPRA.id_producto, COMPRA.unidades, PRODUCTO.nombre, PRODUCTO.precio FROM COMPRA, PRODUCTO WHERE COMPRA.id_producto=PRODUCTO.id_producto AND COMPRA.fecha_compra='$compra'";
            $resultado=mysqli_query($conn, $sql);
            $row=mysqli_fetch_assoc($resultado);
            $id_producto=$row['id_producto'];
            $nombre=$row['nombre'];
            $precio=$row['precio'];
            $unidades=$row['unidades'];
            $total=$total+($precio*$unidades);
            ?><pre><?php
            echo "Producto: ".$id_producto." ".$nombre.", Precio: ".$precio."€, Unidades: ".$unidades."</br>";
            ?></pre><?php
        }
        ?><pre><?php
        echo "Total ".$total."€</br>";
        ?></pre><?php
    }
}

?>

</body>

</html>