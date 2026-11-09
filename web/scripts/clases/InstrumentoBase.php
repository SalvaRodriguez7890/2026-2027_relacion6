<?php
/**
 * 1.- Crear la clase abstracta IntrumentoBase con el siguiente comportamiento. Definirla inicialmente
*   como no abstracta para probar su funcionamiento. Una vez probado se pasará a abstracta:
*
*   - Tiene el atributo descripción de tipo cadena. La descripción se puede fijar mediante el
*   constructor o mediante métodos get/set públicos (ej para propiedad cadena, métodos
*   getCadena/setCadena, no confundir con lo que veremos después como método mágico __get
*   y __set). Directamente no puede ser accesible.
*
*   - Tiene el atributo edad que no es accesible desde el exterior aunque si desde las clases
*   descendientes. Su valor por defecto será 10. Se tiene método get para devolver su valor. Se
*   asignará en el constructor.
*   Para definir los atributos con valor por defecto se declaran en la clase, con el valor por
*   defecto, se define un parámetro en el constructor con el valor por defecto y se asigna en el
*   constructor. Así garantizas que cuando se llame al constructor, si no se indica ningún valor,
*   se asigne el de por defecto.
*
*   - Se definen dos métodos abstractos: sonido (devuelve una frase que representa el sonido) y
*   afinar (devuelve una cadena con los pasos necesarios para afinar el instrumento)
*
*   - Se define el método envejecer, que aumenta la edad del instrumento en un año.
*
*   - Se tiene una variable de clase protegida que controla cuantos elementos se han creado y una
*   propiedad de instancia para indicar cuál es el orden de creación de la instancia. Cada vez
*   que se crea un instrumento se le asigna a la instancia el número de orden de creación del
*   instrumento actual y se incrementa el valor de la variable de clase.
*
*   - Cuando se muestre en un echo aparecerá “instrumento con descripción XXXXX, instancia
*   9999 de un total de 999. Tiene 999 años. La clase es XXXX”. La clase debe ser obtenida
*   mediante get_class. (999 representa un numero, XXX representa una cadena)
*
*   - No tiene la sobrecarga de propiedades por defecto.
 */ 

abstract class InstrumentoBase  {

    protected static int $_numElementos = 0;

    protected int $_ordenCreacion;

    private string $_desripcion;

    protected int $_edad;


    //constructor 
    public function __construct(string $desripcion, int $edad = 10) { 
        //realizo operaciones al crear el objeto 
        $this->_desripcion = $desripcion;
        $this->_edad = $edad;

        // Incrementamos el contador y se lo asignamos al orden de esta instancia
        self::$_numElementos++;
        $this->_ordenCreacion = self::$_numElementos;

    }

    // Getter para desripcion
    public function getDesripcion(): string {
        return $this->_desripcion;
    }

    // Setter para desripcion
    public function setDesripcion(string $desripcion): void {
        $this->_desripcion = $desripcion;
    }

    // Getter para edad
    public function getEdad(): int {
        return $this->_edad;
    }

    // Setter para edad
    public function setEdad(int $edad): void {
        $this->_edad = $edad;
    }
 

/**
 * Método sonido, que devuelve una prase que representará al sonido
 *
 * @return string
 */
abstract function sonido():string;

//return "Pom pom"};


/**
 * Método afinar, devuelve una cadena con los pasos necesarios para afinar el instrumento
 *
 * @return string
 */
abstract function afinar():string;

//return "paso 1, paso 2"};



/**
 * Aumenta la edad en un año
 *
 * @return void
 */
public function envejecer():void{

    $this->_edad++;

}

/**
 * Convierte el objeto a cadena para cuando se use con echo
 * 
 * @return string
 */
public function __toString(): string {
    $clase = get_class($this);
    return "Instrumento con descripción {$this->_desripcion}, instancia {$this->_ordenCreacion} de un total de " .self::$_numElementos. ". Tiene {$this->_edad} años. La clase es {$clase}.";
}


}