<?php
include_once(dirname(__FILE__) . "/../cabecera.php");
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
<?php

// $mueble1 = new MuebleBase("Mueble 1 Ejemplo","Pedro","Españaaaaaaaaaaaaaaaaaaaaaaaaaaaa",2021,"fechaMal","fechamal2", 12.32);

// $cadena =  MuebleBase::toString($mueble1);

// echo $cadena;



}