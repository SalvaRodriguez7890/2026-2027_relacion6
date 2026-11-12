
<?php
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
final class MuebleReciclado extends MuebleBase{

    private int $_porcentajeReciclado = 10;

    /**
     * Constructor de la clase MuebleReciclado
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", 
                                int $anio = 2020, string $fechaIniVenta = "01/01/2020",  
                                string $fechaFinVenta = "31/12/2040", float $precio = 30.0,
                                int $porcentajeReciclado = 10) {
        //LLamo al constructor padre para las variables que eredan
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);

        //inicializo el porcentaje, si no cumple la validación le meto 10
        if (!$this->setPorcentajeReciclado($porcentajeReciclado)) {
            $this->setPorcentajeReciclado(10);
        }
    }

  /**
     * Getts y setters
     */
    
    public function getPorcentajeReciclado(): int {
          return $this->_porcentajeReciclado;
      }

    /**
     * PorcentajeReciclado (entero, con valor por defecto 10, debe estar entre 0 y 100)
     *
     * @param int $porcentaje
     * @return boolean
     */
    public function setPorcentajeReciclado($porcentaje): bool{
      //si la validacion del real devuelve false, yo devuelvo false
      if(!VALFINAL\validaEntero($porcentaje,0,100,10)){
        return false;
      }else{
        //si la validación devuelve true le asigno el valor a la variabler
        $this->_porcentajeReciclado = $porcentaje;
        return true;
      }
    }


    /**
     * Undocumented function
     *
     * @return array
     */
    public function damePropiedadesAdicionales(): array
    {
     return ['_porcentajeReciclado'];
    }

  /**
   * To Strig reescrito usando la clase padre y sumandole la propiedad porcentajeReciclado
   *
   * @return string
   */
    #[Override]
  public function toString(): string
  {
    return parent::toString() . ", material reciclado usado " . $this->getPorcentajeReciclado() . "%";
  }

}