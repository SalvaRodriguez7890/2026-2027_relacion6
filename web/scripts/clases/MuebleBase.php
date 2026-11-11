
<?php
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
abstract class MuebleBase {
    //variables
    private const MAXIMO_MUEBLES = 0;
    private int $_mueblesCreados = 0;

    //propiedades
    private string $_nombre;
    private string $_fabricante = "FaMu";
    private string $_pais = "ESPAÑA";
    private int $_anio = 2020;
    private string $_fechaIniVenta = "01/01/2020";
    private string $_fechaFinVenta = "31/12/2040";
    private float $_precio = 30;

    /**
     * Constructor 
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", 
        int $anio = 2020, string $fechaIniVenta = "01/01/2020",  string $fechaFinVenta = "31/12/2040", float $precio = 30.0) {
   
        //incializo el nombre, pasandole lafuncion setNombre, si devuelve false genero una exception
        if (!$this->setNombre($nombre)) {
        throw new Exception("El nombre del mueble no es válido.");
        }    

        //Inicializo el fabricante 
        $this->setFabricante($fabricante);

        //se inicializa el pais
        $this->setPais($pais);
        
        //se inicializa el año
        $this->setAnio($anio);
     
    }



    // ================= GETTERS y SETTERS =================

    public function getNombre(): string {
        return $this->_nombre;
    }

    public function getFabricante(): string {
        return $this->_fabricante;
    }

    public function getPais(): string {
        return $this->_pais;
    }

    public function getAnio(): int {
        return $this->_anio;
    }

    public function getFechaIniVenta(): string {
        return $this->_fechaIniVenta;
    }

    public function getFechaFinVenta(): string {
        return $this->_fechaFinVenta;
    }

    public function getPrecio(): float {
        return $this->_precio;
    }

    /**
     * Set que se asegura que el nombre mida maximo 40
     *
     * @param string $nombre
     * @return boolean
     */
    public function setNombre(string $nombre): bool {
        $validoNombre = VALFINAL\validaCadena($nombre,40,"");

        //tras pasarle la validacion devolverá false si no cumple, osea mas de 40
        if(!$validoNombre){
            return false;
        }
        //Lo paso a mayuscula
        $nombreMayus = mb_strtoupper($validoNombre);

        //se lo asigno a nuestra propiedad nombre
        $this->_nombre = $nombreMayus;

        return true;
    }

    /**
     * Set Fabricante (cadena de máximo 30, por defecto ‘FaMu:’, siempre se añade al 
     * principio FaMu: si no lo tiene ya - se recorta a 30 caracteres-)
     *
     * @param string $fabricante
     * @return boolean
     */
    public function setFabricante(string $fabricante): bool {
        //Le quito espacios vacios por si acaso       
        $fab = trim($fabricante);

        //Compruebo si empieza o nor por Famu, y si no se lo añado al principio
        if (!str_starts_with($fab, 'FaMu:')) {
            $fab = 'FaMu:' . $fab;
        }

        //Compruebo que no valga mas de 30 caracteres
        if(!(VALFINAL\validaCadena($fab,30,""))){
        // Se recorta estrictamente a un máximo de 30 caracteres si esque vale mas de 30
        $this->_fabricante = mb_substr($fab, 0, 30);
        }else{
         $this->_fabricante = $fab;
        }


        return true;
        }

    /**
     * Pais (cadena, máximo 20 caracteres, por defecto ‘ESPAÑA’)
     *
     * @param string $pais
     * @return boolean
     */
    public function setPais(string $pais): bool {
        //Le quito espacios vacios por si acaso       
        $pa = trim($pais);

        //Compruebo que no valga mas de 20 caracteres
        if(!(VALFINAL\validaCadena($pa,20,""))){
        // Si la validacion devuelve false entonces mide mas de 20, le meto por defecto ESPAÑA
        $this->_pais = "ESPAÑA";
        }else{
         $this->_pais = $pa;
        }
        return true;
        }

    public function setAnio(int $an): bool {
        //genero el año actual
        $anioActual = (int)date('Y');

        //Valido el año entre 2020 y el año actual por defecto le meto 2020
        if(!(VALFINAL\validaEntero($an,2020,$anioActual,2020))){
        // Si la validacion devuelve false el anio no cumplia el rango, por lo que ahora $anio valdrá 2020 (por defecto)
        $this->_anio = $an;
        }else{
        //si la validacion es correcta y el año que se le pasa esta entre 2020 y el año actual $anio vale lo mismo que se le paso
        // por lo que se le asigna a nuestra variable
         $this->_anio = $an;
        }
        return true;
        }



 

}