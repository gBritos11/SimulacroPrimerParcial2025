<?php

// Clase Venta
class Venta{

    // Atributo Estático
    private static int $conteoVentas = 1;
    
    // Atributos - Variables
    private int $numVenta;
    private object $fecha;
    private object $cliente;
    private array $coleccionMotos;//Colección de objetos Motos. Inicializada sin motos
    private float $precioVenta = -1;//Precio total de la venta de cada moto. Incializada en -1

    // Constructor
    public function __construct(
        object $fecha,
        object $cliente,
        array $coleccionMotos
    ) {
        // Asigno valor al atributo numVenta
        $this->numVenta = self::$conteoVentas;
        self::$conteoVentas++;
        $this->fecha = $fecha;
        $this->cliente = $cliente;
        $this->coleccionMotos = $coleccionMotos;
    }

    // Metodos de acceso a las variables:
    // Getters - Observadoras
    public function getNumVenta(): int{
        return $this->numVenta;
    }

    public function getFecha(): object{
        return $this->fecha;
    }

    public function getCliente(): object{
        return $this->cliente;
    }

    public function getColeccionMotos(): array{
        return $this->coleccionMotos;
    }

    public function getPrecioVenta(): float{
        return $this->precioVenta;
    }

    // Setters - Modificadoras
    public function setFecha(object $fecha): void{
        $this->fecha = $fecha;
    }

    public function setCliente(object $cliente): void{
        $this->cliente = $cliente;
    }

    public function setColeccionMotos(array $coleccionMotos): void{
        $this->coleccionMotos = $coleccionMotos;
    }

    public function setPrecioVenta(float $precioVenta): void{
        $this->precioVenta = $precioVenta;
    }

    // MÉTODOS
    /**
     * Retorna una representación en cadena de la clase Venta
     * 
     * @return string
    */
    public function __toString(): string{
        // COLECCIÓN MOTOS
        $motos = "";
        foreach ($this->getColeccionMotos() as $moto){
            $motos .= $moto;
        }

        return
        "----------------------------\n".
        "VENTA -> fecha: ".$this->getFecha().

        (empty($this->getColeccionMotos()) ? 
            "En este momento no hay motos en la colección!\n" :
            $motos
        )."\n".

        "Precio final de las motos vendidas -> $".($this->getPrecioVenta() == -1 ? "XXXXXXXXXXXX" : $this->getPrecioVenta()."\n").
        "(con su respectivo interés anual)\n".
        "\n".$this->getCliente();
    }

    /**
     * Incorpora a la colección de motos, siempre que sea posible la venta, el objeto moto recibido por parámetro
     * 
     * @param object $objMoto objeto moto
     * @return string
    */
    public function incorporarMoto(object $objMoto): string{
        /*
            string $mensaje
            float $precioMoto
        */
        $mensaje = "";

        if($objMoto->getEstado()){
            // Agrego $objMoto a la coleccion de motos
            $this->coleccionMotos[]=$objMoto;

            $precioMoto = $objMoto->darPrecioVenta();

            // Si es la primera moto, seteo el precio directamente
            if($this->getPrecioVenta() == -1){
                $this->setPrecioVenta($precioMoto);
            }else{// si no es la primera moto, sumo al precio que ya habia
                $this->setPrecioVenta($this->getPrecioVenta() + $precioMoto);
            }

            $mensaje = "Moto incorporada a la colección!\n";
            $objMoto->setEstado(false);

        }else{
            $mensaje = "Moto no disponible. No se puede incorporar a la colección.\n";
        }

        return $mensaje;
    }
}

?>