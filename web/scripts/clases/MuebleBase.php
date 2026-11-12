
<?php
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
 abstract class MuebleBase {
    //variables
    private const MAXIMO_MUEBLES = 0;
    private static int $_mueblesCreados = 0;

    //propiedades
    private string $_nombre;
    private string $_fabricante = "FaMu";
    private string $_pais = "ESPAÑA";
    private int $_anio = 2020;
    private string $_fechaIniVenta = "01/01/2020";
    private string $_fechaFinVenta = "31/12/2040";
    private float $_precio = 30;

    //propiedad tipo Caracteristica

    private Caracteristicas $_caracteristicasDinamicas;

    /** 
     * Constructor 
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", 
        int $anio = 2020, string $fechaIniVenta = "01/01/2020",  string $fechaFinVenta = "31/12/2040", float $precio = 30.0) {
   
        //incializo el nombre, pasandole lafuncion setNombre, si devuelve false genero una exception
        if (!$this->setNombre($nombre)) {
        throw new Exception("El nombre del mueble no es válido.");
        }    

        //Fabricante (Si el set devuelve false, aplicamos el valor por defecto)
        if (!$this->setFabricante($fabricante)) {
            $this->setFabricante("FaMu:");
        }

        //País (Si el set devuelve false, aplicamos el valor por defecto)
        if (!$this->setPais($pais)) {
            $this->setPais("ESPAÑA");
        }
        
        //Año (Si el set devuelve false, aplicamos el valor por defecto 2020)
        if (!$this->setAnio($anio)) {
            $this->setAnio(2020);
        }

        //Incio la fecha de ini venta (si no se cunmple 01/01/2020)
        if(!$this->setFechaIniVenta($fechaIniVenta)){
            $this->setFechaIniVenta("01/01/2020");
        }
        //Incio la fechaFinVenta venta (si no se cunmple 31/12/2040)
        if(!$this->setFechaFinVenta($fechaFinVenta)){
            $this->setFechaFinVenta("31/12/2040");
        }

        //Inicializo el precio que tiene que ser real y minimo 30
        if(!$this->setPrecio($precio)){
            $this->setPrecio(30);
        }

        //inicializo la variable que guarda las caracteristicas
        $this->_caracteristicasDinamicas = new Caracteristicas();

        //si todo va bien y el constructor crea el mueble sumo 1
        self::$_mueblesCreados +=1;
    }


    //====== MÉTODOS MÁGICOS EVITANDO LA SOBREACARGA ======

    
    public function __set($name, $value) {
        throw new Exception("No se permite la creación dinámica de la propiedad '{$name}'.");
    }

    public function __get($name) {
        throw new Exception("La propiedad '{$name}' no existe o no es accesible.");
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



        //tras pasarle la validacion devolverá false si no cumple, osea mas de 40
        if(!VALFINAL\validaCadena($nombre,40,"")){
            return false;
        }
        //Lo paso a mayuscula
        $nombreMayus = mb_strtoupper($nombre);

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
        $pa = trim($pais);

        // Compruebo que no valga más de 20 caracteres
        if (!VALFINAL\validaCadena($pa, 20, "")) {
            return false; //No cumple la validación
        }

        $this->_pais = $pa;
        return true;
    }

    /**
     * Anio (entero, año de inicio de fabricación, valor entre 2020 y el año actual, por defecto 2020),
     *
     * @param integer $an
     * @return boolean
     */
    public function setAnio(int $an): bool {
        //saco el año actual
        $anioActual = (int) date('Y');

        // Valida el año entre 2020 y el año actual, le meto 2020 por defecto (porque la funcion de validar lo requiere)
        if (!VALFINAL\validaEntero($an, 2020, $anioActual, 2020)) {
            return false; // Fuera de rango devuelvo false
        }
        //si la validacion devuelve true esta correcto
        $this->_anio = $an;
        return true;
    }

    /**
     * Undocumented FechaIniVenta (cadena, fecha en la que se empieza a vender el mueble, no puede ser anterior al uno 
     * de enero del Anio de inicio de fabricación, en caso de fallo se asigna “01/01/anio”, por defecto ‘01/01/2020’ aunque se usará lo anterior)
     *
     * @param string $fechaIniVenta
     * @return boolean
     */
    public function setFechaIniVenta(string $fechaIniVenta): bool {
        //quito los espacios a la fecha
        $tempFecha = trim($fechaIniVenta);

        //Valido que la fecha metida este en fomrato correcto
        // Si no es válida, la función cambiará $tempFecha a "" y devolverá false.
        if (!VALFINAL\validaFecha($tempFecha, "")) {
            return false; //directamete false
        }

        //COjo el año de fabricacion, si por lo que sea es null uso el operador ?? y le meto 2020
        $anioMinimo = $this->_anio ?? 2020;
        
        //Creo dos fechas con DateTime, una la fecha mínima y la otra la que hemos validado e ingresado
        $fechaMinima = DateTime::createFromFormat('d/m/Y', "01/01/{$anioMinimo}");
        $fechaIngresada = DateTime::createFromFormat('d/m/Y', $tempFecha);

        //Compreubo que la fecha ingresada sea menor que la minima, osea que la fecha mínima sea mas antigua
        if ($fechaIngresada < $fechaMinima) {
            return false; //Si la fecha ingresada es mas antigua ppues no  se cumple y devuelvo false
        }

        //Si pasa todo es que está correcto, pues devuelvo true e inicializo la fecha.
        $this->_fechaIniVenta = $tempFecha;
        return true;
    }

    
    /**
     * FechaFinVenta (cadena-fecha, fecha en la que dejará de venderse, no puede ser anterior a la FechaIniVenta)
     *
     * @param string $fechaFinVenta
     * @return boolean
     */
    public function setFechaFinVenta(string $fechaFinVenta): bool {
        // Quito los espacios a la fecha
        $tempFecha = trim($fechaFinVenta);

        // Valido que la fecha metida esté en formato correcto (si no, devuelve false y asigna "")
        if (!VALFINAL\validaFecha($tempFecha, "")) {
            return false; 
        }
        
        // Creo dos fechas con DateTime: inicio de venta y la ingresada
        $fechaInVenta = DateTime::createFromFormat('d/m/Y', $this->_fechaIniVenta);
        $fechaIngresada = DateTime::createFromFormat('d/m/Y', $tempFecha);

        // Compruebo que la fecha ingresada NO sea anterior a la de inicio de venta
        if ($fechaIngresada < $fechaInVenta) {
            return false; // Si es más antigua que la de inicio, no es válida
        }

        //Si todo va bien inicializo la fecha y devuelvo true
        $this->_fechaFinVenta = $tempFecha;
        return true;
    }

    /**
     *Precio (real, por defecto 30, no puede ser menor de 30). 
     *
     * @param float $precio
     * @return boolean
     */
    public function setPrecio(float $precio): bool {
    
        // Valido el precio que sea real
        if (!VALFINAL\validaReal($precio, 30.00, 1000000000.00, 30.00)) {
            return false; // si es menor de 30 false
        }
        //si la validacion devuelve true esta correcto
        $this->_precio =$precio;
        return true;
    }

    /**
     * Método damePropiedadesAdicionales. Será redefinido en las clases hijas y devolverá
     * un array con el nombre de las propiedades adicionales a la clase base
     *
     * @return array
     */
    abstract function damePropiedadesAdicionales(): array;
    
    
    /**
     * Método de clase puedeCrear que devuelve true si se pueden crear más instancias de la
     * clase y false en caso contrario. Además, devuelve en el parámetro Número el número de
     * muebles que aún se pueden crear de la clase.
     *
     * @param int $numRestantes
     * @return boolean
     */
    public static function puedeCrear(int &$numRestantes): bool {
    //En el if pregunto si los muebles creados son iguales o mas, si se cumpleentonces quiere que decir que ya no se pueden crear mas
    //le asigno a la numRestantes 0 y devuelvo false
    if (self::$_mueblesCreados >= self::MAXIMO_MUEBLES) {
        $numRestantes = 0;
        return false;
    } else {
        //si no significa que todavia hay "espacio" para crear mas, y a la variable numRestantes le asigno la resta del maximo menos los muebles creados
        $numRestantes = self::MAXIMO_MUEBLES - self::$_mueblesCreados;
        return true; }
    }

    /**
     * Método que al convertir la instancia en cadena nos devuelve 'MUEBLE de clase
     * XXX con nombre XXX, fabricante XXX, fabricado en XXX a partir del año 999,
     * vendido desde 99/99/9999 hasta 99/99/9999, precio 9999'.
     *
     * @return string
     */
    public function toString(): string {
        return "MUEBLE de " . get_class($this) . " con nombre " . $this->getNombre() . ", fabricante " . $this->getFabricante() . ", fabricado en " . $this->getPais() . 
                ", a partir del año " . $this->getAnio() . " vendido desde " . $this->getFechaIniVenta() . " hasta " . $this->getFechaFinVenta() . ", precio " . number_format($this->getPrecio(), 2, '.', '') . "€";
    }


    /**
     * Método para meter características a nuestro objeto de caracterisitcas
     *
     * @param string $carac
     * @param mixed $valor
     * @param mixed ...$resto
     * @return void
     */
    public function anadirCaracteristicas(string $carac, mixed $valor, mixed ...$resto): void {
    

        //Añado los dos primeros valores
        $this->_caracteristicasDinamicas->__set($carac, $valor);

        //Miro si he pasado mas de dos valores a la funcion
        $totalResto = count($resto);
        
        //Si le he pasado un numero impar de elementos le borro el ultimo con array_pop al resto
        if ($totalResto % 2 !== 0) {
            array_pop($resto);
            $totalResto = count($resto);
        }

        //Recorro el array de dos en dos para ir añadiendo las características
        for ($i = 0; $i < $totalResto; $i += 2) {
            $clave = $resto[$i];
            $val = $resto[$i + 1];
            
            $this->_caracteristicasDinamicas->__set($clave, $val);
        }
    }

    public function getCaracteristicas(): string {


        return $this->_caracteristicasDinamicas->__toString();
    }

}