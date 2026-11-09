<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador
$barra=[
    [
    "TEXTO"=>"inicio",
    "ENLACE"=>"/index.php",
    "ADICIONAL" => ">>"
    ],
    [
    "TEXTO"=>"otro"
    ],
    [
    "TEXTO"=>"index",
    "ADDICIONAL" => "&copy;&copy;"
    ]
];

$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("tienda");
cabecera();
finCabecera();
inicioCuerpo("Tienda", $barra);
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
    ?>
    <!--Comentario-->

    
    <?php

    
}

//vista
function cuerpo()
{
?>
            <br>
                <lu>
                    <hr>
                    <li><a href="./index.php">RECARGA-PAGINA</a></li>
                    <br>
                </lu>

   
    
<?php
}
