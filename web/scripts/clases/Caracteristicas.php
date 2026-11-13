
<?php
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
class Caracteristicas implements IteratorAggregate {
    
    //Array para meter calve-valor las nuevas características
    private array $caracteristicas = [];
    
    //Variable para dejar añadir o no mas propiedades nuevas
    private bool $bloqueado = false;

    /**
     * Método mágico __set para crear y modficar las propiedads dinámicas
     */
    public function __set(string $clave, mixed $valor): void {
        //la clave la paso a mayuscula
        $nombreMayus = strtoupper($clave);
        
        //Si ya está bloqueado, lanzo excepcion
        if ($this->bloqueado) {
            throw new Exception("Error: No se pueden añadir más características. Se indicó ULTIMA previamente.");
        }

        //Si el if de antes no entra, le meto la nueva caracteristica nueva al array, indicando la clave y su valor
        //o si la característica si que existe pues la cambio
        $this->caracteristicas[$clave] = $valor;

        //Si la característica que le hemos pasado es Ultima  o su valor es Ultima pues pasabloes el bloqueo a true
        if ($nombreMayus === 'ULTIMA' || $valor === 'ULTIMA') {
            $this->bloqueado = true;
        }
    }

    /**
     * Método mágico __get para leer propiedades dinámicas.
     */
    public function __get(string $clave) {
        //pregunto si esa clave existe entro del array y si es así pues lo devuelvo
        if (array_key_exists($clave, $this->caracteristicas)) {
            return $this->caracteristicas[$clave];
        }
        //si no entra el if pues saco una excepcion diciendo que la clave no existe
        throw new Exception("La característica '{$clave}' no existe.");
    }

    /**
     * Método mágico __isset para comprobar si existe la propiedad.
     */
    public function __isset(string $clave): bool {
        //uso otra vez array_key_exists para comprobarlo
        return array_key_exists($clave, $this->caracteristicas);
    }

    /**
     * Método mágico __unset para eliminar propiedades.
     */
    public function __unset(string $clave): void {
        //llamo al unset del array y la clave para eliminarlo
        unset($this->caracteristicas[$clave]);
    }

    /**
     * Uso el getIterator y el Traversable para poder hacer al objeto iterable y usarlo directamente en un foreach
     *
     * @return Traversable
     */
    public function getIterator(): Traversable {
        //Uso array_reverse, al cual hay que pasarle un array, esta funcion te devuelve dicho array invertido
        //ademas el segundo aprametro (true o false) le indicas si quieres que te devuelva también las
        return new ArrayIterator(array_reverse($this->caracteristicas, true));
    }

    /**
     * Este método ahce lo mismo que el getIterator, pero es necesario llamar a la funcion del objeto para poder iterar las caracteristicas
     *
     * @return array
     */
    public function caracteristicasInversa(): array{
        //Uso array_reverse, al cual hay que pasarle un array, esta funcion te devuelve dicho array invertido
        //ademas el segundo aprametro (true o false) le indicas si quieres que te devuelva también las
        return array_reverse($this->caracteristicas, true);
    }

    /**
     * convertir el objeto en cadena, se devolverá una cadena de la forma car1:valor1;car2:valor2;…… 
     *
     * @return string
     */
   public function __toString(): string {
        $cadena = "";
        //Reccorro también también en orden inverso para que la cadena coincida con el foreach
        foreach ($this->caracteristicas as $key => $valor) {
            $cadena .= "{$key}:{$valor};";
        }
        
        //Devuelvo la cadena
        return $cadena;
    }
}

    