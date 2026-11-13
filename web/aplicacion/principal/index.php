<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$barraUbi = [
    [
        "TEXTO"=>"Inicio",
        "ENLACE" =>"/index.php"
    ],
    [
        "TEXTO"=>"Index Relacion 6",
        "ENLACE" =>"/aplicacion/index.php"
    ]
   
];

//variable para los erroes
$errores = [];



$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Pruebas Relación 6", $barraUbi);
cuerpo($arrayMuebles, $errores);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
   
}

//vista
function cuerpo(array $arrayMuebles, array $errores)
{
?>
<!--Pruebas de muebles-->  

<br>
<hr>
<br>

<table id = "tablaMuebles">
    <tr>
        <th>Indice</th>
        <th>Nombre</th>
        <th>Fabricante</th>
        <th>Pais</th>
        <th>Año Fabricacion</th>
        <th>Fecha Inicio de Venta</th>
        <th>Fecha Fin de Venta</th>
        <th>Precio</th>
        <th>Caracteristica Adicionales</th>
    </tr>


<?php
//Con un for recorro el array muebles
    for ($i = 0; $i < count($arrayMuebles); $i++){
            echo "<tr>";
                echo "<td>" . ($i+1)."</td>";
                echo "<td>" . $arrayMuebles[$i]->getNombre() . "</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getFabricante() . "</td>".PHP_EOL; 
                echo "<td>" . $arrayMuebles[$i]->getPais() . "</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getAnio() . "</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getFechaIniVenta() . "</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getFechaFinVenta() . "</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getPrecio() . " €</td>".PHP_EOL;
                echo "<td>" . $arrayMuebles[$i]->getCaracteristicas() . "</td>".PHP_EOL;
            echo "</tr>".PHP_EOL;
        }
?>
</table>

    <br>
    <hr>
    <br>

    <form id="muestraMueble" method="POST">
        <label>Ingresa el ID del mueble a mostrar</label>
        <input id="datosIDmueble" type="number" name="datosIDmueble" placeholder="1, 2, 3 ...">
        <br>
        <br>
        <input id="btnMostrar" type="submit" name="accion" value = "Mostrar">
        <input id="btnModificar" type="submit" name = "accion" value = "Modificar">
      </form>

      <br>
      <hr>
      <br>
<?php

//miramos se a pulsado el boton
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    // reincio el array de erroes cuando le doy al boton
    $errores = [];

    // Comprobamos que el campo no esté vacío
    if (isset($_POST["datosIDmueble"]) && $_POST["datosIDmueble"] !== "") {
        
        // Saco el id que se ha pasado y le resto 1 para ajustarlo al índice del array
        $id = intval($_POST["datosIDmueble"]) - 1; 

        // Validamos dinámicamente si el índice existe en el array de muebles
        if ($id < 0 || $id >= count($arrayMuebles)) {
            $errores["ErrorId"] = "<p id='mensajeError'>ID INCORRECTO: El mueble seleccionado no existe.</p>";
        } else {
            // Si no hay error, inicializamos el mueble seleccionado
            $muebleSeleccionado = $arrayMuebles[$id];
        }

    } else {
        $errores["ErrorId"] = "<p id='mensajeError'>ID INCORRECTO: Debes introducir un número.</p>";
    }

    if(count($errores)==0){
        if($_POST["accion"] == "Mostrar"){
            echo "<div>".PHP_EOL;
            echo "<h2>DATOS DEL MUEBLE ELEGIDO</h2>".PHP_EOL;

            echo "<p><b>Nombre: </b> ". $muebleSeleccionado->getNombre()."</p><br>".PHP_EOL;
            echo "<p><b>Fabricante: </b> ". $muebleSeleccionado->getFabricante()."</p><br>".PHP_EOL;
            echo "<p><b>Pais: </b> ". $muebleSeleccionado->getPais()."</p><br>".PHP_EOL;
            echo "<p><b>Año de Fabricación: </b> ". $muebleSeleccionado->getAnio()."</p><br>".PHP_EOL;
            echo "<p><b>Fecha de Inicio de la venta: </b> ". $muebleSeleccionado->getFechaIniVenta()."</p><br>".PHP_EOL;
            echo "<p><b>Fecha del Fin de la venta: </b> ". $muebleSeleccionado->getFechaFinVenta()."</p><br>".PHP_EOL;
            echo "<p><b>Precio: </b> ". $muebleSeleccionado->getPrecio()."</p><br>".PHP_EOL;
            echo "<p><b>Caracteristicas adicionales: </b> ". $muebleSeleccionado->getCaracteristicas()."</p><br>".PHP_EOL;
        }
    }else{
        echo "<h2>ERRORES ENCONTRADOS</h2>".PHP_EOL;

        foreach ($errores as $error){

            echo $error;

        }
    }
}





}
