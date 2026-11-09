<?php
/**
 * 7.- Crear la clase ClaseMisPropiedades. En esta clase se define una propiedad privada llamada 
 * $_propiedades. Se debe permitir añadir en tiempo de ejecución cualquier nueva propiedad 
 * (propiedades dinámicas) a una instancia. Además tenemos las propiedades de instancia 
 * $propPublica (publica, mixed) y $_propPrivada (privada, mixed, inicializada a 25). 
 * Se debe garantizar que no se pueda asignar un valor a una propiedad que llamemos _propPrivada 
 * (creada de forma dinámica). Por ejemplo, este código debería ser válido. 
 * 
 * $Objeto= new ClaseMisPropiedades (); 
 * 
 * $Objeto->propPublica=”publica”; 
 * 
 * //$Objeto->_propPrivada=”privada”; //no es valida al ser privada 
 * 
 * $Objeto->propiedad1=25; 
 * 
 * $Objeto->propiedad2=”cadena de texto”; 
 * 
 * echo “la propiedad 1 vale “.$Objeto->propiedad1.”<br>”. 
 * 
 * // echo $Objeto->propiedad3; // esto debería dar un error al no haber asignado previamente la propiedad 
 * 
 * 
 * Además la clase deber ser iterable. Así cuando se haga un foreach ($Objeto as $clave=>$valor) se 
 * deben devolver como claves las propiedades con el prefijo oi_ delante (ejemplo para la propiedad 
 * propiedad1, se devolverá como clave oi_propiedad1), incluyendo propPublica y _propPrivada como últimos 
 * elementos a devolver en el foreach. 
 * 
 */ 

class MisPropiedades implements Iterator {

    //variables
    public mixed $propPublica = null;
    private mixed $_propPrivada = 25;
    
    // Array para almacenar las propiedades dinámicas
    private array $_propiedades = [];

    // variables para el iterator
    private int $_posicion = 0;
    private array $_elementosIterable = [];

    /**
     * Método mágico __set para capturar propiedades dinámicas
     */
    public function __set(string $name, mixed $value): void {
        if ($name == "_propPrivada") {
            throw new Exception("Error: Esa propieadad ya existe y no se puede modificar.");
        }
        $this->_propiedades[$name] = $value;
    }

    /**
     * Método mágico __get para leer propiedades dinámicas
     */
    public function __get(string $name): mixed {
        //con el array_key_exists comrpuebo si existe la propiedad en el array dinamico
        if (array_key_exists($name, $this->_propiedades)) {
            return $this->_propiedades[$name];
        }
        throw new Exception("Error: La propiedad '{$name}' no ha sido definida.");
    }

    /**
     * Método auxiliar para ordenar los elementos con el prefijo 'oi_' y dejar las fijas al final
     */
    private function prepararElementos(): array {
        $elementos = [];
        
        //Primero con un foreach recorro el array de propiedades dinamicas y le añado el prefijo oi_
        foreach ($this->_propiedades as $clave => $valor) {
            $elementos["oi_" . $clave] = $valor;
        }
        
        //Ahora añado las propiedades fijas al final del array con el prefijo oi_
        $elementos["oi_propPublica"] = $this->propPublica;
        $elementos["oi__propPrivada"] = $this->_propPrivada;
        
        return $elementos;
    }

    //Metodos de iterator

    /**
     * Método rewind para reiniciar el iterador
     */
    public function rewind(): void {
        //INicializo el array y reiniciamos el puntero
        $this->_elementosIterable = $this->prepararElementos();
        $this->_posicion = 0;
    }

    /**
     * Método valid para comprobar si la posición actual es válida
     */
    public function valid(): bool {
        $claves = array_keys($this->_elementosIterable);
        return isset($claves[$this->_posicion]);
    }

    /**
     * Método current para obtener el valor actual
     */
    public function current(): mixed {
        $valores = array_values($this->_elementosIterable);
        return $valores[$this->_posicion];
    }

    /**
     * Método key para obtener la clave actual
     */
    public function key(): mixed {
        $claves = array_keys($this->_elementosIterable);
        return $claves[$this->_posicion];
    }

    /**
     * Método next para avanzar a la siguiente posición
     */
    public function next(): void {
        $this->_posicion++;
    }
}