<?php
/**
 *  4.- Definir la clase Flauta que es un instrumento de viento que es fabricable y de la que no se puede heredar ninguna otra subclase. 
 * 
 *  -El constructor se hará privado
 * 
 *  -Se tiene el método estático CrearDesdeArray (constructor estatico) con parámetro un Array con posiciones asociativas “material” y “edad” 
 *   (pueden no aparecer por lo que se tienen en cuenta valores por defecto) y que devuelve una instancia de Flauta con los valores indicados. 
 * 
 *  - Definir el método de clonación para la clase flauta de forma que el nuevo objeto tenga los mismos valores, salvo la edad que será 0 y el 
 *   número de instancia (propiedad) /número de instancias (propiedad de clase), ya que realmente he creado una nueva instancia. 
 * 
 * 
 */ 

final class Flauta extends InstrumentoViento implements IFabricable {

    // Declaro el atributo material
    protected string $_material;


    /**
     * Constructor
     * 
     * @param string $material
     * @param int $edad
     */
    //material por defecto es madera, y la edad 15
    private function __construct(string $material = "madera", int $edad = 15) { 
        // Llamamos al constructor de la clase padre pasándole el material y la edad
        parent::__construct($material, $edad);
        
      
    }

    /**
     * Método sonido (obligatorio porque es abstracto en el padre)
     *
     * @return string
     */
    public function sonido(): string {
        return "Fluuu Fluuu";
    }

    /**
     * Método estatico para poder llamarlo y crear el objeto
     *
     * @param array $datos
     * @return Flauta
     */
    static function CrearDesdeArray(array $datos): Flauta {

        // Extraemos los valores del array, usando valores por defecto si no están presentes
        $material = ($datos['material']) ? $datos['material'] : 'madera';
        $edad = ($datos['edad']) ? $datos['edad'] : 15;

        // Creamos y devolvemos una nueva instancia de Flauta
        return new Flauta($material, $edad);
    }

 
    /**
     * Método que clona el objeto y pone la edad a 0, y actualiza el contador de instancias
     *
     * @return void
     */
    public function __clone() {
        // Clonamos, reseteamos la edad a 0 y actualizamos el contador de instancias
        $this->_edad = 0;
        self::$_numElementos++;
        $this->_ordenCreacion = self::$_numElementos;
    }


    /**
     * Convierte el objeto a cadena para cuando se use con echo
     * 
     * @return string
     */
    public function __toString(): string {
        // Añado lo que dice el enunciado, y para no repetir codigo llamo al tostring de la clase padre
        return parent::__toString();
    }


     /**
     * Devuelve los pasos para fabricar el elemento
     *
     * @return string
     */
    public function metodoFabricacion():string{
        return "Paso 1. Tallar, Paso2. Alisar";
    }

    /**
     * Devuelve el método de reciclado que se debe aplicar al elemento según su fabricación
     *
     * @return string
     */
    public function metodoReciclado():string{
        return "Paso 1 cortar, Paso 2 quemar";

    }
  


}