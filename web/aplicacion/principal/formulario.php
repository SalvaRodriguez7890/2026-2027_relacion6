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
        "ENLACE" =>"/aplicacion/principal/index.php" // [CAMBIO] ruta corregida
    ],
    ["TEXTO" => "Modificar"]
   
];
//variable para los erroes
$errores = [];
$muebleSeleccionado = null;
$resumen = false;   
$id = -1; // [CAMBIO] -1 para que no coincida con un mueble real si no llega id

//Recojo el id que le pase en el index
//compruebo que exista y que no sea cadena vacia
if(isset($_GET["id"]) && $_GET["id"]!== ""){

    //le resto 1 porque lo pase sin restarlo
    $id = intval($_GET["id"])-1;

    //vuelvo a comprobar que el id este dentro de lo que ya tengo en el array
    if ($id < 0 || $id >= count($arrayMuebles)) {
        $errores["ErrorId"] = "<p class='mensajeError'>El mueble seleccionado no existe.</p>"; // [CAMBIO] class en vez de id
    } else {
        //le asigno el mueble del array
        $muebleSeleccionado = $arrayMuebles[$id];
    }
//si hay algun error (no deveria porque tambien hago lo mismo en el index) muestro los errores
}else {
    $errores["ErrorId"] = "<p class='mensajeError'>No se ha recibido ningún id.</p>"; // [CAMBIO] class en vez de id
}




//miro si se pulsa el boton que modifica los datos del mueble
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST["accion"] ?? "";

    //si se pulsa el boton y el mueble no es null
    if ($accion == "ModificarDatos" && $muebleSeleccionado !== null) {

        //creo el mueble auxiliar con un clon
        $auxiliar = clone $muebleSeleccionado;

        //Primero voy a comprobar el nombre, fabricante, pais y el anio de fabricacion con el set de la instancia auxiliar 
        if (!$auxiliar->setNombre($_POST["nombre"] ?? "")) {
            //Si devuelñve false pues le meto el error porque el set no lo ha aceptado ni validado 
            $errores["nombre"] = "<p class='mensajeError'>Nombre incorrecto.</p>";
        }
        if (!$auxiliar->setFabricante($_POST["fabri"] ?? "")) {
            $errores["fabri"] = "<p class='mensajeError'>Fabricante incorrecto.</p>";
        }
        if (!$auxiliar->setPais($_POST["pais"] ?? "")) {
            $errores["pais"] = "<p class='mensajeError'>País incorrecto.</p>";
        }
        if (!$auxiliar->setAnio($_POST["anFabri"] ?? "")) {
            $errores["anFabri"] = "<p class='mensajeError'>Año incorrecto.</p>";
        }

        //Voy a usar condiciones para el precio, y fechas
        
        //Le meto al precio el nuevo del formulario
        $precio = $_POST["precio"] ?? "";
        //Compruebo que  exista y sea mayor a 30
        // [CAMBIO] is_numeric detecta textos como "abc" (todo lo de $_POST llega como texto)
        if (!is_numeric($precio) || $precio < 0 ) {
            $errores["precio"] = "<p class='mensajeError'>Precio incorrecto.</p>";
        }

        //comprueblo el material
        $materialNuevo = $_POST["material"] ?? "";

        //valido el material por si acaso, p
        if(!(\VALFINAL\validaEntero($materialNuevo, 0, 20,10)) || !($materialNuevo%5==0)){
            $errores["materialNuevo"] = "<p class='mensajeError'>Material incorrecto</p>";
        }
        


        //saco las fechas del formulario
        $fecIni = $_POST["fecIni"] ?? "";
        $fecFin = $_POST["fecVen"] ?? "";

        //uso mi libreria para validar las fechas
        if (!VALFINAL\validaFecha($fecIni,"")) {
            $errores["fecIni"] = "<p class='mensajeError'>Formato de la Fecha de inicio incorrecta.</p>";
        }
         if (!VALFINAL\validaFecha($fecFin,"")) {
            $errores["fecFin"] = "<p class='mensajeError'>Formato de la Fecha de Fin Fabricacion incorrecta.</p>"; // [CAMBIO] clave fecFin para no pisar la de fecIni
        }
     
        //
        //Validacion si el mueble es Reciclado
        //
        if ($auxiliar instanceof MuebleReciclado) {
            //Uso el auxiliar y set para el porcentaje
            if (!$auxiliar->setPorcentajeReciclado($_POST["porcentaje"] ?? "")) {
                $errores["porcentaje"] = "<p class='mensajeError'>Porcentaje incorrecto debe ser valor entero y estar entre 0 y 100.</p>";
            }
        } elseif ($auxiliar instanceof MuebleTradicional) {
            //Para el tradicional voy a usr ocndiciones para el peso
            $peso = $_POST["peso"] ?? "";
            if (!VALFINAL\validaReal($peso,15,300,0)) {
                $errores["peso"] = "<p class='mensajeError'>Peso incorrecto, minimo 15 kg y maximo 300kg.</p>";
            }
            // y por set para la serie
            if (!$auxiliar->setSerie($_POST["serie"] ?? "")) {
                $errores["serie"] = "<p class='mensajeError'>Serie incorrecta, no la dejes vacia.</p>";
            }
        }

        // Si todo mea  salido bien actualizo el muebleque seleccione
        if (count($errores) == 0) {
            $muebleSeleccionado->setNombre($_POST["nombre"]);
            $muebleSeleccionado->setFabricante($_POST["fabri"]);
            $muebleSeleccionado->setPais($_POST["pais"]);
            $muebleSeleccionado->setAnio($_POST["anFabri"]);
            $muebleSeleccionado->setFechaIniVenta($_POST["fecIni"]);
            $muebleSeleccionado->setFechaFinVenta($_POST["fecVen"]);
            $muebleSeleccionado->setPrecio($_POST["precio"]);
            $muebleSeleccionado->setMaterial($_POST["material"]);

            //si es reciclado
            if ($muebleSeleccionado instanceof MuebleReciclado) {
                $muebleSeleccionado->setPorcentajeReciclado($_POST["porcentaje"]);
            //o si es tradicional
            } else if ($muebleSeleccionado instanceof MuebleTradicional) {
                $muebleSeleccionado->setPeso($_POST["peso"]);
                $muebleSeleccionado->setSerie($_POST["serie"]);
            }
            //pongo resumen en true
            $resumen = true;
        }
    }
}






$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Formulario Relación 6", $barraUbi);
cuerpo($arrayMuebles, $errores, $id, $muebleSeleccionado, $resumen);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
   
}

//vista
// [CAMBIO] ?MuebleBase: acepta null cuando el id es incorrecto
function cuerpo(array $arrayMuebles, array $errores, int $id, ?MuebleBase $muebleSeleccionado, bool $resumen)
{

//por si acaso existises algun error 

if (isset($errores["ErrorId"])) {
    echo $errores["ErrorId"];
    echo "<a href='/aplicacion/principal/index.php'>Ir a Index</a>";
    return;
}

    // [CAMBIO] si se modificó bien, muestro solo el resumen (sin formulario)
    if ($resumen) {
        echo "<h2>MUEBLE MODIFICADO CORRECTAMENTE</h2>";

         echo "<div>" . PHP_EOL;
                echo "<p><b>ID: </b>".($id+1)."</p>".PHP_EOL; // [CAMBIO] el número ahora va dentro del <p>
                echo "<p><b>Nombre: </b> ". $muebleSeleccionado->getNombre()."</p><br>".PHP_EOL;
                echo "<p><b>Fabricante: </b> ". $muebleSeleccionado->getFabricante()."</p><br>".PHP_EOL;
                echo "<p><b>Pais: </b> ". $muebleSeleccionado->getPais()."</p><br>".PHP_EOL;
                echo "<p><b>Año de Fabricación: </b> ". $muebleSeleccionado->getAnio()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha de Inicio de la venta: </b> ". $muebleSeleccionado->getFechaIniVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Fecha del Fin de la venta: </b> ". $muebleSeleccionado->getFechaFinVenta()."</p><br>".PHP_EOL;
                echo "<p><b>Precio: </b> ". $muebleSeleccionado->getPrecio()."€</p><br>".PHP_EOL;
                echo "<p><b>Material: </b> ". $muebleSeleccionado->getMaterialDescripcion()."</p><br>".PHP_EOL;

    if ($muebleSeleccionado instanceof MuebleReciclado){
              echo "<p><b>Porcentaje Reciclado: </b> ". $muebleSeleccionado->getPorcentajeReciclado()."%</p><br>".PHP_EOL;
    }

     if ($muebleSeleccionado instanceof MuebleTradicional){
              echo "<p><b>Peso: </b> ". $muebleSeleccionado->getPeso()."kg</p><br>".PHP_EOL;
              echo "<p><b>Serie: </b> ". $muebleSeleccionado->getSerie()."</p><br>".PHP_EOL;
              
    }
                echo "<p><b>Caracteristicas adicionales: </b> ". $muebleSeleccionado->getCaracteristicas()."</p><br>".PHP_EOL;

    echo "</div>" . PHP_EOL;



        echo "<a href='/aplicacion/principal/index.php'>Ir a Index</a>";
        return;
    }

    $nombreMueble = $muebleSeleccionado->getNombre();

    echo "<h2>NUEVOS DATOS PARA EL MUEBLE '$nombreMueble' </h2>".PHP_EOL;
?>

    <form id="modificaMueble" method="POST">
        
        <label>Nombre</label>
        <input id="nombre" type="text" name="nombre" value="<?php echo htmlspecialchars((string)($_POST["nombre"] ?? $muebleSeleccionado->getNombre())); ?>">
        <br>
        <br>
        <label>Fabricante</label>
        <input id="fabri" type="text" name="fabri" value="<?php echo htmlspecialchars((string)($_POST["fabri"] ?? $muebleSeleccionado->getFabricante())); ?>">
        <br>
        <br>
        <label>Pais</label>
        <input id="pais" type="text" name="pais" value="<?php echo htmlspecialchars((string)($_POST["pais"] ?? $muebleSeleccionado->getPais())); ?>">
        <br>
        <br>
        <label>Año Fabricacion</label>
        <input id="anFabri" type="text" name="anFabri" value="<?php echo htmlspecialchars((string)($_POST["anFabri"] ?? $muebleSeleccionado->getAnio())); ?>">
        <br>
        <br>
        <label>Fecha de Inicio</label>
        <input id="fecIni" type="text" name="fecIni" value="<?php echo htmlspecialchars((string)($_POST["fecIni"] ?? $muebleSeleccionado->getFechaIniVenta())); ?>">
        <br>
        <br>
        <label>Fecha de Venta</label>
        <input id="fecVen" type="text" name="fecVen" value="<?php echo htmlspecialchars((string)($_POST["fecVen"] ?? $muebleSeleccionado->getFechaFinVenta())); ?>">
        <br>
        <br>
        <label>Precio</label>
        <input id="precio" type="text" name="precio" value="<?php echo htmlspecialchars((string)($_POST["precio"] ?? $muebleSeleccionado->getPrecio())); ?>">
        <br>
        <br>
        
        <label>Material</label>
        <input id="materialActual" type="text" name="materialActual" value="<?php echo htmlspecialchars((string)($_POST["material"] ?? $muebleSeleccionado->getMaterialDescripcion())); ?>">
        <br>
        <br>
        <label>ELECCION NUEVO MATERIAL</label>
        <br>
        <br>
        <label>Madera</label>
        <input id="madera" type="radio" name="material" value = "5">
        <br>
        <label>Hierro</label>
        <input id="hierro" type="radio" name="material" value = "10">
        <br>
        <label>Acero</label>
        <input id="acero" type="radio" name="material" value = "15">
        <br>
        <label>Plastico</label>
        <input id="plastico" type="radio" name="material" value = "20">
        <br>
    <?php 
    if ($muebleSeleccionado instanceof MuebleReciclado) { 
    
    ?>
        <br>
        <label>Porcentaje reciclado</label>
        <input type="text" name="porcentaje" value="<?php echo htmlspecialchars((string)($_POST["porcentaje"] ?? $muebleSeleccionado->getPorcentajeReciclado())); ?>">
        <br><br>
    <?php 
    } elseif ($muebleSeleccionado instanceof MuebleTradicional) { 
    ?>
    <br>
    <label>Peso</label>
    <input type="text" name="peso" value="<?php echo htmlspecialchars((string)($_POST["peso"] ?? $muebleSeleccionado->getPeso())); ?>">
    <br>
    <br>
    <label>Serie</label>
    <input type="text" name="serie" value="<?php echo htmlspecialchars((string)($_POST["serie"] ?? $muebleSeleccionado->getSerie())); ?>">
    <br>
    <br>
    <?php 
    } 
    ?>
    
        <br>
        <input id="btnCambiarDatos" type="submit" name="accion" value="ModificarDatos">
    </form>
    


      <br>
      <hr>
      <br>
<?php
    if (count($errores) > 0) {  
        echo "<h2>ERRORES ENCONTRADOS</h2>" . PHP_EOL;
        foreach ($errores as $error) {
            echo $error;
        }
    }

}