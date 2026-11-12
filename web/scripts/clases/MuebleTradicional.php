
<?php
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
final class MuebleTradicional extends MuebleBase{

    private float $_peso = 15;
    private string $_serie = "S01";










  /**
   * Undocumented function
   *
   * @return array
   */
  public function damePropiedadesAdicionales(): array
  {
    throw new \Exception('Not implemented');
  }
}