<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$barraUbi = [
    ["TEXTO" => "Inicio", "ENLACE" => "/index.php"],
    ["TEXTO" => "Index Relacion 6", "ENLACE" => "/aplicacion/index.php"]
];

$errores = [];
$muebleSeleccionado = null;
$accion = "";

// ---- Logica para comprobar los datos ----

//miramos si se pulsa el boton
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //a la variable accion le asigno el boton que se pulsa
    $accion = $_POST["accion"] ?? "";

  //miro si a sido e boton de mostrar
    if ($accion == "Mostrar" || $accion == "Modificar") {
        //Compruebo que existe algo dentro del input datosIDmueble y si existe saea diferente de cadena vacia
        if (isset($_POST["datosIDmueble"]) && $_POST["datosIDmueble"] !== "") {
            //el id es lo que haya dentro del input y le resto 1 para que coincida con el index del array
            $id = intval($_POST["datosIDmueble"]) - 1;

            //Miro que esté entre 0 y 1, si no esta es porque es un erro al meter el id
            if ($id < 0 || $id >= count($arrayMuebles)) {
                $errores["ErrorId"] = "<p id='mensajeError'>ID INCORRECTO: El mueble seleccionado no existe.</p>";
            } else {
                //si el id es correcto pues le asigno a mueble seleccionado el mueble del array
                $muebleSeleccionado = $arrayMuebles[$id];
                //Creo otra varaibable para el id para enviar al formulario
                $idRealParaEnviar = intval($_POST["datosIDmueble"]);
            }
        } else {
            //si por lo que sea hay un error en el id, pues pongo un erro de que hay que introducir el numero (estaba vacio)
            $errores["ErrorId"] = "<p id='mensajeError'>ID INCORRECTO: Debes introducir un número.</p>";
        }
    }

    // Si no hay errores y se pulso el botón Modificar, hacemos la redirección aquí arriba
    if (count($errores) == 0 && $accion == "Modificar") {
        header("Location: /aplicacion/principal/formulario.php?id=" . $idRealParaEnviar);
        exit();
    }

   
}

// ---- DIBUJO DE LA PÁGINA ----
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Index Relación 6", $barraUbi);
cuerpo($arrayMuebles, $errores, $muebleSeleccionado, $accion);
finCuerpo();

// vista
function cabecera() {}

function cuerpo(array $arrayMuebles, array $errores, $muebleSeleccionado, string $accion)
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
    //Muestro los resultados
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (count($errores) > 0) {//si el array errores tien algo lo muestro
            echo "<h2>ERRORES ENCONTRADOS</h2>" . PHP_EOL;
            foreach ($errores as $error) {
                echo $error;
            }
        //si no existen erroes y accion es mostrar pues muestro los datos del mueble seleccionado
        } elseif ($accion == "Mostrar") {
            echo "<div>" . PHP_EOL;
                echo "<h2>DATOS DEL MUEBLE ELEGIDO</h2>" . PHP_EOL;
                
                echo "<p><b>Nombre: </b> ". $muebleSeleccionado->getNombre()."</p><br>".PHP_EOL;
                echo "<p><b>Fabricante: </b> ". $muebleSeleccionado->getFabricante()."</p><br>".PHP_EOL;
                echo "<p><b>Pais: </b> ". $muebleSeleccionado->getPais()."</p><br>".PHP_EOL;
                echo "<p><b>Año de Fabricación: </b> ". $muebleSeleccionado->getAnio()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha de Inicio de la venta: </b> ". $muebleSeleccionado->getFechaIniVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha del Fin de la venta: </b> ". $muebleSeleccionado->getFechaFinVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Precio: </b> ". $muebleSeleccionado->getPrecio()."</p><br>".PHP_EOL;
                echo "<p><b>Caracteristicas adicionales: </b> ". $muebleSeleccionado->getCaracteristicas()."</p><br>".PHP_EOL;

            echo "</div>" . PHP_EOL;
        }
        
    }
}
