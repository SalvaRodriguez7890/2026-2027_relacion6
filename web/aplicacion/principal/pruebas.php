<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$barraUbi = [
    [
        "TEXTO"=>"Inicio",
        "ENLACE" =>"/index.php"
    ],
    [
        "TEXTO"=>"Pruebas Relacion 6",
        "ENLACE" =>"/aplicacion/index.php"
    ]
   
];



$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Pruebas Relación 6", $barraUbi);
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
   
}

//vista
function cuerpo()
{
?>
<!--Pruebas de muebles-->  

<br>
<hr>
<br>

<?php


// $mueble1 = new MuebleBase("Mueble 1 Ejemplo","Pedro","Españaaaaaaaaaaaaaaaaaaaaaaaaaaaa",2021,"fechaMal","fechamal2", 12.32);

// $cadena =  MuebleBase::toString($mueble1);

// echo $cadena;

    $muebleReciclado1 = new MuebleReciclado("Silla de plástico", "No tiene", "China", 2023, 04/3/2023, 1/1/2032, 31, 70);

    echo $muebleReciclado1->toString().PHP_EOL;

    echo "<br><br>".PHP_EOL;
   
    foreach($muebleReciclado1->damePropiedadesAdicionales() as $propiedad){

    echo $propiedad."<br>".PHP_EOL;

    }
    echo "<br><hr><br>".PHP_EOL;

    $muebleTradicional = new MuebleTradicional("Silla de madera Rústica", "Pedro el Carpintero" , "", 2021, 04/3/2022, 1/1/2042, 150, 16, "SERIE 5");

    echo $muebleTradicional->toString().PHP_EOL;

    echo "<br><br>".PHP_EOL;
   
    foreach($muebleTradicional->damePropiedadesAdicionales() as $propiedad){

    echo $propiedad."<br>".PHP_EOL;

    }

    $muebleReciclado1->anadirCaracteristicas("Material Respaldo", "ROBLE", "DescuentoDiscapacidad", 5);

    echo $muebleReciclado1->getCaracteristicas();

    echo "<br><br>".PHP_EOL;
    try{

    $muebleReciclado1->anadirCaracteristicas("Perro", 3.51, "Juan", "5 añós", "Ultima", "Ultima");

    echo $muebleReciclado1->getCaracteristicas();
    
    echo "<br><br>".PHP_EOL;

    $muebleReciclado1->anadirCaracteristicas("Otra", 1);

    echo "<br><br>".PHP_EOL;
   
    }catch(Exception $e){
        echo  $e->getMessage() . PHP_EOL;
    }

}