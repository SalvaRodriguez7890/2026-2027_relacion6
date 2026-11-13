<?php 

define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO","desarrollo"); //en "produccion o en desarrollo




if (MODO_TRABAJO=="produccion"){
    error_reporting(0);
    date_default_timezone_get('Europe/Berlin');
}
    else 
        error_reporting(E_ALL);  

spl_autoload_register(function ($clase){
    $ruta=RUTABASE."/scripts/clases/";
    $fichero=$ruta."$clase.php";
    
    if (file_exists($fichero))
        {
            require_once($fichero);
        }
      else
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE."/aplicacion/plantilla/plantilla.php");

//creo todos los objetos que necesita mi aplicación
/**Creo el array de muebles */
$mueble1 = new MuebleReciclado("Silla Rústica", " PEDRO EL CARPINTERO", "ESPAÑA", 2021, "01/02/2022", "01/01/2070", 70, 33);
$mueble1->anadirCaracteristicas("Color", "Rojo", "Firmado", "SI");

$mueble2 = new MuebleReciclado("Mesa Rústica", "HIJO DE PEDRO", "ESPAÑA", 2021, "02/02/2022", "01/01/2050", 120, 10);
$mueble2->anadirCaracteristicas("Color", "Acacia", "Firmado", "SI");

$mueble3 = new MuebleTradicional("Sofa", "MUEBLES SAN JUAN", "ESPAÑA", 2024, "01/02/2024", "01/01/2035", 400, 340,"Serie 201");
$mueble3->anadirCaracteristicas("Color", "Beige", "Firmado", "NO");

$mueble4 = new MuebleTradicional("Sillon", "MUEBLES JOSEP", "FRANCIA", 2025, "01/02/2026", "16/05/2035", 240.99, 60,"Serie 202");
$mueble4->anadirCaracteristicas("Color", "Azul", "Firmado", "NO");

$mueble4 = new MuebleTradicional("Puerta", "CARPINTERIA JOHN JOSEP", "UK", 2023, "01/02/2024", "16/10/2035", 150.99, 25,"Serial 51");
$mueble4->anadirCaracteristicas("Color", "Brown", "Firmado", "NO");

$mueble5 = new MuebleReciclado("Barandilla", "CARPINTERIA JOHN JOSEP", "UK", 2021, "12/12/2022", "16/10/2035", 150.99, 25);
$mueble5->anadirCaracteristicas("Color", "Brown", "Firmado", "SI");

$arrayMuebles = [$mueble1, $mueble2, $mueble3, $mueble4, $mueble5];