<?php
/**
 *  6.- Crear la clase SerieFibonacci que implementa la serie de Fibonacci. 
 *  Esta serie se basa en la fórmula F(x)=F(x-1)+F(x-2) siendo F(0)=0 y F(1)=1. 
 *  Para obtener el valor F(n) se puede usar la fórmula alternativa 
 * 
 * 
 * 
 *  Para implementar esta clase podéis usar la interfaz Iterator y tener dos propiedades privadas $_limite y $_claveActual. 
 *  $limite indica hasta qué valor se generaría la serie. $_claveActual indica cual es el elemento actual para el que se calcula la serie. 
 *  El funcionamiento tendría que ser algo así: 
 * 
 *  foreach(new SerieFibonacci(10) as $valor) { 
 * 
 *   echo “$valor &nbsp;”; 
 *   
 *  } 
 *   Generaria 10 valores 0 1 1 2 3 5 8 13 21 34 55 
 * 
 *   
 *  Crear la función fFibonacci($ultimo) como función estática dentro de  la SerieFibonacci, que debe implementar la serie de Fibonacci usando  para ello un generador. 
 */

class SerieFibonacci implements Iterator {

    //Defino las variables

    private int $_limite;
    private int $_claveActual;

    //defino dos variables para llevar el valor actual y el anterior 

    private int $_valorActual;
    private int $_valorAnterior;

    /**
     * Constructor
     *
     * @param int $limite
     */ 

    public function __construct(int $limite) {
        $this->_limite = $limite;
        $this->rewind(); //iunicio el iterador


    }


    /**
     * Método rewind para reiniciar el iterador
     *
     * @return void
     */ 
    public function rewind(): void {
        $this->_claveActual = 0;
        $this->_valorActual = 0;
        $this->_valorAnterior = 1; //lo inicalizo a 1 par que no de error
    }

    /**
     * Método valid
     */
    public function valid(): bool {
        return $this->_claveActual < $this->_limite;
    }


    /**
     * Método current para obtener el valor actual de la serie
     *
     * @return int
     */
    public function current():int {
        //llamo al metodo fFibonacci, si devuelve 0
        return $this->_valorActual;
        }

    /**
     * Método key para obtener la clave actual
     *
     * @return int
     */
    public function key(): int {
        return $this->_claveActual;
    }


    /**
     * Método next para avanzar al siguiente valor de la serie
     *
     * @return void
     */
    public function next(): void {
        // Si estamos en el primer elemento (clave 0 y valor 0), el siguiente es 1
        if ($this->_claveActual == 0 && $this->_valorActual == 0) {
            $this->_valorActual = 1;
            $this->_valorAnterior = 0;
        } else {
            // Como no es la posicioon 0 palicamos la formula
            $siguiente = $this->_valorActual + $this->_valorAnterior;
            $this->_valorAnterior = $this->_valorActual;
            $this->_valorActual = $siguiente;
        }

        //aumento la clasveActual
        $this->_claveActual++;
    }



    /**
     * Método estático fFibonacci que implementa la serie de Fibonacci usando un generador
     *
     * @param int $ultimo
     * @return Generator
     */ 
    public static function fFibonacci(int $ultimo): Generator {
        $a = 0;
        $b = 1;

        for ($i = 0; $i < $ultimo; $i++) {
            yield $a;
            $temp = $a;
            $a = $b;
            $b = $temp + $b;
        }
    }

}
