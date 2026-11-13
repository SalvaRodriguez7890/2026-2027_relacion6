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



$usuario=getenv("MYSQL_USER");

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Pruebas Relación 6", $barraUbi);
cuerpo($arrayMuebles);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
   
}

//vista
function cuerpo(array $arrayMuebles)
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
    for ($i = 0; $i < count($arrayMuebles); $i++){
            // Asumiendo métodos estándar tipo getNombre(), getFabricante(), etc. 
            // Si tus propiedades son públicas o usas otros getters, ajústalos aquí:
            echo "<tr>";
            echo "<td>" . ($i+1)."</td>";
            echo "<td>" . $arrayMuebles[$i]->getNombre() . "</td>";
            echo "<td>" . $arrayMuebles[$i]->getFabricante() . "</td>"; // Nota: ajusta según tus getters de clase
            echo "<td>" . $arrayMuebles[$i]->getPais() . "</td>";
            echo "<td>" . $arrayMuebles[$i]->getAnio() . "</td>";
            echo "<td>" . $arrayMuebles[$i]->getFechaIniVenta() . "</td>";
            echo "<td>" . $arrayMuebles[$i]->getFechaFinVenta() . "</td>";
            echo "<td>" . $arrayMuebles[$i]->getPrecio() . " €</td>";
            echo "<td>" . $arrayMuebles[$i]->getCaracteristicas() . "</td>";
            echo "</tr>";
        }
?>
</table>
<?php


}
