<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$barraUbi = [
    [
        "TEXTO"=>"Inicio",
        "ENLACE" =>"/index.php"
    ],
    [
        "TEXTO"=>"Formulario Relacion 6",
        "ENLACE" =>"/aplicacion/index.php"
    ],
    ["TEXTO" => "Modificar"]
   
];

//variable para los erroes
$errores = [];

$muebleSeleccionado = null;

$id = -1;

//Recojo el id que le pase en el index
//compruebo que exista y que no sea cadena vacia
if(isset($_GET["id"]) && $_GET["id"]!== ""){

    //le resto 1 porque lo pase sin restarlo
    $id = intval($_GET["id"])-1;

    //vuelvo a comprobar que el id este dentro de lo que ya tengo en el array
    if ($id < 0 || $id >= count($arrayMuebles)) {
        $errores["ErrorId"] = "<p id='mensajeError'>El mueble seleccionado no existe.</p>";
    } else {
        //le asigno el mueble del array
        $muebleSeleccionado = $arrayMuebles[$id];
    }
//si hay algun error (no deveria porque tambien hago lo mismo en el index) muestro los errores
}else {
    $errores["ErrorId"] = "<p id='mensajeError'>No se ha recibido ningún id.</p>";
}

//miramos si se pulsa el boton de modifcar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //a la variable accion le asigno el boton que se pulsa
    $accion = $_POST["accion"] ?? "";

    //Si es modificar
    if($accion == "ModificarDatos"){
        //empiezo a validar los datos


    }
}




$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Formulario Relación 6", $barraUbi);
cuerpo($arrayMuebles, $errores, $id, $muebleSeleccionado);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
   
}

//vista
function cuerpo(array $arrayMuebles, array $errores, int $id, MuebleBase $muebleSeleccionado)
{

//por si acaso existises algun error 

if (count($errores) > 0) {
        foreach ($errores as $error) {
            echo $error;
        }
        return;
    }

    echo "<div>" . PHP_EOL;
                echo "<h2>DATOS DEL MUEBLE ELEGIDO</h2>" . PHP_EOL;
                echo "<p><b>ID: </b></p>".($id+1).PHP_EOL;
                echo "<p><b>Nombre: </b> ". $muebleSeleccionado->getNombre()."</p><br>".PHP_EOL;
                echo "<p><b>Fabricante: </b> ". $muebleSeleccionado->getFabricante()."</p><br>".PHP_EOL;
                echo "<p><b>Pais: </b> ". $muebleSeleccionado->getPais()."</p><br>".PHP_EOL;
                echo "<p><b>Año de Fabricación: </b> ". $muebleSeleccionado->getAnio()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha de Inicio de la venta: </b> ". $muebleSeleccionado->getFechaIniVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha del Fin de la venta: </b> ". $muebleSeleccionado->getFechaFinVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Precio: </b> ". $muebleSeleccionado->getPrecio()."</p><br>".PHP_EOL;
                echo "<p><b>Caracteristicas adicionales: </b> ". $muebleSeleccionado->getCaracteristicas()."</p><br>".PHP_EOL;

    echo "</div>" . PHP_EOL;

    $nombreMueble = $muebleSeleccionado->getNombre();

    echo "<h2>NUEVOS DATOS PARA EL MUEBLE '$nombreMueble' </h2>".PHP_EOL;
?>

    <form id="modificaMueble" method="POST">
        
        <label>Nombre</label>
        <input id="nombre" type="string" name="nombre">
        <br>
        <br>
        <label>Fabricante</label>
        <input id="fabri" type="string" name="fabri" >
        <br>
        <br>
        <label>Pais</label>
        <input id="pais" type="string" name="pais">
        <br>
        <br>
        <label>Año Fabricacion</label>
        <input id="anFabri" type="string" name="anFabri" >
        <br>
        <br>
        <label>Fecha de Inicio</label>
        <input id="fecIni" type="string" name="fecIni" >
        <br>
        <br>
        <label>Fecha de Venta</label>
        <input id="fecVen" type="string" name="fecVen" >
        <br>
        <br>
        <label>Precio</label>
        <input id="precio" type="int" name="precio" >
        <br>
        
        <br>
        <input id="btnCambiarDatos" type="submit" name = "accion" value = "ModificarDatos">
      </form>

      <br>
      <hr>
      <br>
<?php

}