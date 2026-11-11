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
 * Función que comprueba si una fecha es válida en el formato dd/mm/aaaa
 *
 * @param string $var Fecha a comprobar
 * @param string $defecto Valor a asignar a fecha en caso de no ser correcta
 * @return boolean Devuelve true si la fecha es válida. False en caso contrario
 */
function validaFecha(string &$var, string $defecto): bool
{
    $patron = '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/';

    
    if (preg_match($patron, $var, $arrayCoincidencias)) {
        $dia = (int)$arrayCoincidencias[1];
        $mes = (int)$arrayCoincidencias[2];
        $año = (int)$arrayCoincidencias[3];

        
        // Validar rangos
        if (checkdate($mes,$dia,$año)) {

            // Saneamiento
            $var = sprintf('%02d/%02d/%02d', $dia, $mes, $año);
            return true;
        }
    }

    // Si no es válida, asignar valor por defecto
    $var = $defecto;
    return false;
}

/**
 * Funcion que comprueba si una hora  es válida.
 *
 * @param string $var  hora a comprobar
 * @param string $defecto  Hora por defecto
 * @return boolean  Devuelve true si la hora es correcta. False en caso contrario
 */
function validaHora(string &$var, string $defecto): bool
{
    $patron = '/^([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})$/';
    
    if (preg_match($patron, $var, $arrayCoincidencias)) 
        {
            $hora = (int)$arrayCoincidencias[1];
            $minutos = (int)$arrayCoincidencias[2];
            $segundos = (int)$arrayCoincidencias[3];

            // Validar rangos
            if ($hora >= 0 && $hora <= 23 &&
                $minutos >= 0 && $minutos <= 59 &&
                $segundos >= 0 && $segundos <= 59) 
                {

                    // Saneamiento
                    $var=mb_substr("0000$hora",-2).":".
                        mb_substr("0000$minutos",-2).":".
                        mb_substr("0000$segundos",-2);
                    return true;
                }
        }
    // Si no es válida, asignar valor por defecto
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