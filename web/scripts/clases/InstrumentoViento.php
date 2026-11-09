<?php
/**
 * 3.- Definir la clase InstrumentoViento que hereda de InstrumentoBase con el siguiente comportamiento: 
 * 
 * -La descripción es “instrumento de viento”. 
 * 
 * -Tiene el atributo material con valor por defecto madera. Este atributo no es accesible directamente desde el exterior aunque si desde las clases derivadas. 
 *  No se  tienen métodos set/get para esta propiedad. 
 * 
 * -Al constructor se le pasa como parámetro el material y la edad (valor por defecto 15). 
 * 
 * -El método afinar no debe ser redefinible en las clases derivadas de esta. 
 * 
 * -Cuando se muestre en un echo aparecerá, junto a todo lo indicado por la clase base, el texto “Instrumento de material XXXX”. 
 */ 

class InstrumentoViento extends InstrumentoBase {

    // Declaro el atributo material
    protected string $_material;


    /**
     * Constructor
     * 
     * @param string $material
     * @param int $edad
     */
    //material por defecto es madera, y la edad 15
    public function __construct(string $material = "madera", int $edad = 15) { 
        // Llamamos al constructor de la clase padre pasándole la descripción fija y la edad
        parent::__construct("instrumento de viento", $edad);
        
        // Asignamos el unico parametro de esta clase
        $this->_material = $material;
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
     * Método afinar con el atributo FInal para que no puedan redefinir en las clases que hereden
     *
     * @return string
     */
    final public function afinar(): string {
        return "paso 1 limpiar, paso 2 secar";
    }

    /**
     * Convierte el objeto a cadena para cuando se use con echo
     * 
     * @return string
     */
    public function __toString(): string {
        // Añado lo que dice el enunciado, y para no repetir codigo llamo al tostring de la clase padre
        return "Instrumento de material {$this->_material}, " . parent::__toString();
    }
}