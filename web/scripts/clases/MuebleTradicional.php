
<?php

use function VALFINAL\validaReal;

include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
final class MuebleTradicional extends MuebleBase{

    private float $_peso = 15;
    private string $_serie = "S01";


    /**
     * Constructor de la clase MuebleTradicional
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", 
                                int $anio = 2020, string $fechaIniVenta = "01/01/2020",  
                                string $fechaFinVenta = "31/12/2040", float $precio = 30.0,
                                float $peso = 15.0, string $serie = "S01") {
        //LLamo al constructor padre para las variables que eredan
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);

        //inicializo el peso, si no cumple la validación le meto 15
        if (!$this->setPeso($peso)) {
            $this->setPeso(15.0);
        }

        //Inicializo la serie y si no cumple (le paso cadena vacia) le mete "S01"
        if (!$this->setSerie($serie)) {
            $this->setSerie("S01");
        }
    }


    /**
     * Getts y setters
     */
    
    public function getPeso(): float {
          return $this->_peso;
      }

    public function getSerie(): string {
          return $this->_serie;
      }

    /**
     * Peso (real, entre 15 y 300, por defecto 15)
     *
     * @param float $peso
     * @return boolean
     */
    public function setPeso($peso): bool{
      //si la validacion del real devuelve false, yo devuelvo false
      if(!VALFINAL\validaReal($peso,15,300,0)){
        return false;
      }else{
        //si la validación devuelve true le asigno el valor a la variabler
        $this->_peso = $peso;
        return true;
      }
    }

    /**
     * Serie (cadena, por defecto S01)
     *
     * @param string $serie
     * @return boolean
     */
    public function setSerie($serie): bool{
      //serie no tiene ningun filtro, simplemente si no se le pasa cadena pues luego se mete su valor por defecto

      //si no le paso nada pues devuelvo false y se le asigna luego el valor por defecto
      if($serie == ""){
      return false;
      }else{
        $this->_serie = $serie;
        return true;
      }
    }


  /**
   * Devuelvo un array con los nombres de las propiedades
   *
   * @return array
   */
  public function damePropiedadesAdicionales(): array
  {
      return ['_peso','_serie'];
  }

  /**
   * To Strig reescrito usando la clase padre y suamndole las dos nuevas propiedades
   *
   * @return string
   */
    #[Override]
  public function toString(): string
  {
    return parent::toString() . ", en la serie " . $this->getserie() . ", con un peso de " . $this->getPeso() . "kg";
  }

}