<?php

namespace VALFINAL;

/**
 * Function validaEntero(int &$var, int $min, int $max, int $defecto):bool Esta función
 * comprueba que $var contiene un entero cuyo valor está entre $min y $max. En $var se
 * devuelve el entero saneado (en caso de no cumplir las condiciones asigna a $var el valor
 * $defecto). La función devuelve true si es correcto y false en caso contrario.
 *
 * @param mixed $var
 * @param integer $min
 * @param integer $max
 * @param integer $defecto
 * @return boolean
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool {
    
    //el primer if comprueba que sea un numero entero
    if(is_int($var)){
            //este segundo if que este dentro del rrango que el ponesmos, si entra en este segundo if
            //el numero es correcto y devuelvo true
            if ($var >= $min && $var <= $max) {
            return true;
            }
        }
    
    //si en el if no entra, ssignifica que no es un numero entero o que no está dentro del rango
    //pues devuelvo false y el valor por defecto
    $var = $defecto;

    return false;
}

/**
 * Function validaReal(float &$var, float $min, float $max, float $defecto):bool Esta función
 * comprueba que $var contiene un real cuyo valor está entre $min y $max. En $var se devuelve
 * el real saneado (en caso de no cumplir las condiciones asigna a $var el valor $defecto). La
 * función devuelve true si es correcto y false en caso contrario. 
 *
 * @param float $var
 * @param float $min
 * @param float $max
 * @param float $defecto
 * @return boolean
 */
function validaReal(float &$var, float $min, float $max, float $defecto):bool {

    //el primer if comprueba que sea un numero real
    if(is_float($var)){
            //este segundo if que este dentro del rrango que el ponesmos, si entra en este segundo if
            //el numero es correcto y devuelvo true
            if ($var >= $min && $var <= $max) {
            return true;
            }
        }
    
    //si en el if no entra, ssignifica que no es un numero real o que no está dentro del rango
    //pues devuelvo false y el valor por defecto
    $var = $defecto;

    return false;
}

/**
 *  Function validaFecha(string &$var, string $defecto):bool Esta función comprueba que $var
 *  contiene una fecha correcta en el formato dd/mm/aaaa. En $var se devuelve la fecha saneada
 *  (2 cifras para hora y minutos y cuatro para año- ej fecha 1/2/2023 es válida aunque se sanea y se
 *  convierte en 01/02/2023). En caso de no cumplir las condiciones devuelve $defecto en
 *  $var. La función devuelve true si es correcta y false en caso contrario.
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaFecha(string &$var, string $defecto):bool {
    
//con split separo el string de fecha por las "/" y al hora minutos y año le asigno suvalor
    $arrayFecha = explode("/",$var);
    
    //Por si acaso me aseguro que el array creado tenga 3 objetos,
    //porque si alguien pasa por ejemplo un string 21/03, el array
    //solo tiene 2 y me daria error
    if(count($arrayFecha) != 3){
        $var = $defecto;
        return false;
    }

    $dia=$arrayFecha[0];
    $mes=$arrayFecha[1];
    $anio=$arrayFecha[2];

     //ahora compruebo la longitud y le añado los ceros concatenando
    if(mb_strlen($dia) < 2){
        $dia = "0".$dia;
    }
    if(mb_strlen($mes) < 2){
        $mes = "0".$mes;
    }
     //el año es raro, porque si enviamos un 99, significa 1999 y no 2099,
    //por lo que asumiremos que las fechas que se meten en del año 2000 en adelante
    if(mb_strlen($anio) < 4){
        $anio = "20".$anio;
    }

        //Con checkdate compreubo que la fecha sea correcta
        if (checkdate($dia, $mes, $anio)) {
            $var =  $dia."/".$mes."/".$anio;
            return true;
        }
    

    // Si no cumple el formato o la fecha no existe en el calendario:
    $var = $defecto;
    return false;
   
}

/**
 * function validaHora(string &$var, string $defecto):bool Esta función comprueba que $var
 * contiene una hora correcta en el formato hh:mm:ss . En $var se devuelve la hora saneada (2
 * cifras para hora, min, segundos - Ej 0:5:1, hora valida aunque se sanea y se convierte a
 * 00:05:01). En caso de no cumplir las condiciones devuelve $defecto en $var. La función
 * devuelve true si es correcta y false en caso contrario
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaHora(string &$var, string $defecto):bool {

//con explode separo el string de la hora por las ":"
    $arrayHora = explode(":",$var);
    
    //Por si acaso me aseguro que el array creado tenga 3 objetos,
    //porque si alguien pasa por ejemplo un string 14:31, el array
    //solo tiene 2 y me daria error
    if(count($arrayHora) != 3){
        $var = $defecto;
        return false;
    }

    $hora=$arrayHora[0];
    $minutos=$arrayHora[1];
    $segundos=$arrayHora[2];

     //ahora compruebo la longitud y le añado los ceros concatenando
    if(mb_strlen($minutos) < 2){
        $minutos = "0".$minutos;
    }
    if(mb_strlen($hora) < 2){
        $hora = "0".$hora;
    }
    if(mb_strlen($segundos) < 2){
        $segundos = "0".$segundos;
    }
    
    //debo comprobar que no se le pasa negativo y que no pasa de 60 min, 60 segunos o 23 horas
    //si algun parametro no es validado devuelvo false y el por defecto
    if(!($hora < 23 && $hora >= 0 &&
       $minutos < 60 && $minutos >= 0 &&
       $segundos < 60 && $segundos >= 0)){

        $var = $defecto;
        return false;
       }

        //ahora a partir de las variables de hora, minuto y segundos creo un objeto DateTime
            $dateTime = \DateTime::createFromFormat('H:i:s', $hora.":".$minutos.":".$segundos);
        if($dateTime != false){
            $var= $hora.":".$minutos.":".$segundos;
            return true;
        }
    
    // Si el $dateTime es falso no entra y devuelvo el valor por defecto y false
    $var = $defecto;
    return false;

}

/**
 * function validaEmail(string &$var, string $defecto):bool Esta función comprueba que $var
 * contiene un email correcto en el formato aaaaa@bbbb.ccc. En $var se devuelve el email
 * saneado (en caso de no cumplir las condiciones devuelve $defecto). La función devuelve
 * true si es correcto y false en caso contrario.
 * 
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaEmail(string &$var, string $defecto): bool {
    //Creo una expresion regular para el email
    $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    //con el preg_match le asigno el patron a la variable para ver si esta correcto
    if (preg_match($patron, $var)) {
        //Si entra devuelvo true proque es correcto
        return true;
    }

    //Si no cumple el formato, devuelvo el valor por defecto y false
    $var = $defecto;
    return false;
}

/**
 * function validaCadena(string &$var, int $longitud, string $defecto):bool Esta función
 * comprueba que $var contiene una cadena de longitud máxima $longitud. En caso de no
 * cumplir las condiciones se asigna a $var el valor $defecto. La función devuelve true si es
 * correcto y false en caso contrario.
 *
 * @param string $var
 * @param integer $longitud
 * @param string $defecto
 * @return boolean
 */
function validaCadena(string &$var, int $longitud, string $defecto): bool {
    //Primero me aseguro de la logitud
    if (mb_strlen($var) <= $longitud) {
        return true;
    }

    // Si supera la longitud máxima, le doy el valor por defecto y devuelvo false
    $var = $defecto;
    return false;
}

/**
 * function validaExpresion(string &$var, string $expresion, string $defecto):bool Esta función
 * comprueba que $var cumple con la expresión regular $expresion. En caso de no cumplir las
 * condiciones se asigna a $var el valor por $defecto. La función devuelve true si es correcto y
 * false en caso contrario.
 *
 * @param string $var
 * @param string $expresion
 * @param string $defecto
 * @return boolean
 */
function validaExpresion(string &$var, string $expresion, string $defecto): bool {
    //uso preg match para comprobar la expresion
    if (preg_match($expresion, $var)) {
        return true;
    }

    //Si no cumple puse false y por defecto
    $var = $defecto;
    return false;
}

/**
 * function validaRango(mixed $var, array $posibles, int $tipo=1):bool Esta función comprueba
 * que $var sea igual a uno de los elementos del array $posibles ($tipo=1) o a una de las claves
 * del array $posibles ($tipo=2). La función devuelve true si es correcta y false en caso contrario.
 *
 * @param mixed $var
 * @param array $posibles
 * @param integer $tipo
 * @return boolean
 */
function validaRango(mixed $var, array $posibles, int $tipo=1):bool {
        $resultado = false;

        //Meto las opciones (tipo) en un switch
    switch ($tipo){
        //si es 1 pues pregunto si la $var existe en el array
        case 1 : $resultado = (in_array($var, $posibles))? true : false;  break;
        //si es 2 pues compruebo si existe la clave en el array
        case 2 : $resultado = (array_key_exists($var, $posibles))? true : false;  break;
        default : $resultado = false;
    }
    //Devuelvo el resultado
    return $resultado;
}