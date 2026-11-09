<?php
/**
 * - propiedades nombre (string), fecha_nacimiento (string), domicilio (string), localidad (string) y estado (EstadoCivil). Todas las propiedades son privadas. 
 * 
 * - Un conjunto de sentencias get/set para devolver/poner su valor. 
 * 
 * - Constructor privado al que no se indica ningún parámetro y que rellena las propiedades con valores nombre “prueba”, 
 *   echa_nacimiento “01/01/2000”, domicilio “carrera 12”, localidad “antequera” y estado “soltero”. 
 * 
 *  - Constructor estático registrarPersona, que recibe parámetros para todas las propiedades 
 * 
 *  - Método toString que devuelve la cadena “Nombre es una persona estado nacida en fecha_nacimiento y que vive en localidad” 
 * 
 * 
 */ 

class Persona{

     // Declaro las propiedades privadas

    private string $_nombre;
    private string $_fechaNacimiento;
    private string $_domicilio;
    private string $_localidad;
    
    //El atributo estado es de la enumeracion
    private EstadoCivil $_estado;

    /**
     * Constructor privado
     */
    private function __construct() {
        // Inicializo las propiedades con los valores por defecto
        $this->_nombre = "prueba";
        $this->_fechaNacimiento = "01/01/2000";
        $this->_domicilio = "carrera 12";
        $this->_localidad = "antequera";
        $this->_estado = EstadoCivil::SOLTERO;
    }

    /**
     * Constructor estático registrarPersona
     *
     * @param string $nombre
     * @param string $fechaNacimiento
     * @param string $domicilio
     * @param string $localidad
     * @param EstadoCivil $estado
     * @return static
     */
    public static function registrarPersona(string $nombre, string $fechaNacimiento, string $domicilio, string $localidad, EstadoCivil $estado): static {
        // Creo el objeto Persona usando el constructor privado
        // y luego le cambio sus propiedades a los valores recibidos por parámetro
        $persona = new static();
        
        // Asigno los valores recibidos por parámetro a las propiedades
        $persona->_nombre = $nombre;
        $persona->_fechaNacimiento = $fechaNacimiento;
        $persona->_domicilio = $domicilio;
        $persona->_localidad = $localidad;
        $persona->_estado = $estado;

        //Devuelvo la persona creada
        return $persona;
    }

    /**
     * Método toString
     *
     * @return string
     */
    public function __toString(): string {
            //monto el return como dice el enunciado
            
        return "{$this->_nombre} es una persona {$this->_estado->descripcion()} nacida en {$this->_fechaNacimiento} y que vive en {$this->_localidad}";
    }















    // Getter y Setter

    public function getNombre(): string {
        return $this->_nombre;
    }

    public function setNombre(string $nombre): void {
        $this->_nombre = $nombre;
    }

    public function getFechaNacimiento(): string {
        return $this->_fechaNacimiento;
    }

    public function setFechaNacimiento(string $fechaNacimiento): void {
        $this->_fechaNacimiento = $fechaNacimiento;
    }

    public function getDomicilio(): string {
        return $this->_domicilio;
    }

    public function setDomicilio(string $domicilio): void {
        $this->_domicilio = $domicilio;
    }

    public function getLocalidad(): string {
        return $this->_localidad;
    }

    public function setLocalidad(string $localidad): void {
        $this->_localidad = $localidad;
    }

    public function getEstado(): EstadoCivil {
        return $this->_estado;
    }

    public function setEstado(EstadoCivil $estado): void {
        $this->_estado = $estado;
    }



}