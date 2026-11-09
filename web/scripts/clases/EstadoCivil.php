<?php
/**
 *  5.- Definir el tipo enumerado EstadoCivil con las siguientes características: 
 * 
 *  -Casos de soltero, casado, pareja y viudo con valores 10, 20, 30 y 40 respectivamente. 
 * 
 *  -Método descripcion que devuelve el nombre del caso concreto. 
 * 
 *  -Método valor que devuelve el valor del caso concreto. 
 * 
 *  -Método estático casos que devuelve un array con todos los casos 
 * 
 * 
 */ 

enum EstadoCivil:int{

//Dficno los casos con sus valores
    case SOLTERO = 10;
    case CASADO = 20;
    case PAREJA = 30;
    case VIUDO = 40;

    /**
     * Metodo descripcion que la descripcion del caso concreto, usando un switch para devolver el nombre del caso concreto
     *
     * @return string
     */
    public function descripcion(): string {

        return $this->name;
    }

    /**
     * Metodo valor que devuelve el valor del caso concreto
     *
     * @return int
     */
    public function valor(): int {
        return $this->value;
    }

    /**
     * Metodo estático casos que devuelve un array con todos los casos
     *
     * @return array
     */
    public static function casos(): array {
        return EstadoCivil::cases();
    }

    
}