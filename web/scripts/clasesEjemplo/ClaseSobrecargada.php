<?php

/**
 * Clase ClaseSobrecargada con el siguiente comportamiento
 * - Si la propiedad empieza por m o M la doy por buena.
 * - Una propiedad sobrecargada siempre tendrá el valor 234
 * 
 */
class ClaseSobrecargada{

    public int $numero = 10;


    //metodos mágicos para el control de la sobrecarga

    public function __set(string $name,mixed $value):void
    {
        throw new \Exception("La propiedad $name no existe");
        
    }

    public function __get(string $name)
    {

        if(mb_strtoupper($name[0]) == "M"){

            return 234;
        }else{

         throw new \Exception("La propiedad $name no existe");

        }

       

        
    }

    public function __isset(string $name):bool
    {
        return (mb_strtoupper($name[0]) === "M");
        
    }

    public function __unset(string $name):void
    {
        ;
       // throw new \Exception('Not implemented');
    }
}

