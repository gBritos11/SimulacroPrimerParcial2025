<?php

// Clase Moto
class Moto{

    // Atributo Estático
    private static int $conteoMotos = 11;
    
    // Atributos - Variables
    private int $codigo;
    private float $costo;
    private int $anioFabricacion;
    private string $descripcion;
    private float $incrementoAnual;//porcentaje incremento anual (%)
    private bool $estado;//true = disponible para la venta; false = no disponible

    // Constructor
    public function __construct(
        float $costo,
        int $anioFabricacion,
        string $descripcion,
        float $incrementoAnual,
        bool $estado
    ) {
        // Asigno valor al atributo codigo
        $this->codigo = self::$conteoMotos;
        self::$conteoMotos++;
        $this->costo = $costo;
        $this->anioFabricacion = $anioFabricacion;
        $this->descripcion = $descripcion;
        $this->incrementoAnual = $incrementoAnual;
        $this->estado = $estado;
    }

    // Metodos de acceso a las variables:
    // Getters - Observadoras
    public function getCodigo(): int{
        return $this->codigo;
    }

    public function getCosto(): float{
        return $this->costo;
    }

    public function getAnioFabricacion(): int{
        return $this->anioFabricacion;
    }

    public function getDescripcion(): string{
        return $this->descripcion;
    }

    public function getIncrementoAnual(): float{
        return $this->incrementoAnual;
    }

    public function getEstado(): bool{
        return $this->estado;
    }

    // Setters - Modificadoras
    public function setCosto(float $costo): void{
        $this->costo = $costo;
    }

    public function setAnioFabricacion(int $anioFabricacion): void{
        $this->anioFabricacion = $anioFabricacion;
    }

    public function setDescripcion(string $descripcion): void{
        $this->descripcion = $descripcion;
    }

    public function setIncrementoAnual(float $incrementoAnual): void{
        $this->incrementoAnual = $incrementoAnual;
    }

    public function setEstado(bool $estado): void{
        $this->estado = $estado;
    }

    // MÉTODOS
    /**
     * Retorna una representación en cadena de la clase Moto
     * 
     * @return string
    */
    public function __toString(): string{
        return
        "----------------------------\n".
        "MOTO -> Código de identificación: ".$this->getCodigo()."\n".
        "Modelo: ".$this->getAnioFabricacion()."\n".
        $this->getDescripcion()."\n".
        "Precio: $".$this->getCosto()." -> %".$this->incrementoAnual." de incremento anual\n".
        "Estado -> ".($this->getEstado() ? "Disponible para venta" : "VENDIDA")."\n".
        "----------------------------\n";
    }

    /**
     * Calcula el valor por el cual puede ser vendida una moto
     * 
     * @return float retorna el precio de la moto. Si la moto no esta disponible para venta devuelve -1
    */
    public function darPrecioVenta(): float{
        /*
            float $precioVenta
            int $anio
        */
        $precioVenta = -1;//Variable bandera
        $anio = 2025-$this->getAnioFabricacion();//Años transcurridos desde que se fabricó la moto

        if($this->getEstado()){
            $precioVenta = $this->getCosto() + $this->getCosto() * ($anio * ($this->getIncrementoAnual() / 100));
        }

        return $precioVenta;
    }
}

// FUNCIONES

/**
 * Obtengo los datos de una Moto
 * 
 * @return object $moto
*/
function datosMoto(): object{
    // COSTO
    do{
        $costo = readline("Ingresar costo de la moto: $");

        if(! (is_numeric($costo) && $costo>0)){
            echo "El costo debe ser un valor numerico mayor a 0. Intentar de nuevo por favor.\n";
        }
    }while(! (is_numeric($costo) && $costo>0));

    // AÑO FABRICACIÓN
    do{
        $anioFabricacion = readline("Ingresar modelo de la moto (año de fabricación): ");

        if(! (is_numeric($anioFabricacion) && $anioFabricacion>2000)){
            echo "El año de fabricación debe ser un valor numérico mayor a 2000. Intentar de nuevo por favor.\n";
        }
    }while(! (is_numeric($anioFabricacion) && $anioFabricacion>2000));

    // DESCRIPCIÓN
    $descripcion = readline("Ingresar descripción de la moto: ");

    // PORCENTAJE DE INCREMENTO ANUAL
    do{
        $incAnual = readline("Ingresar porcentaje de incremento anual de la moto: %");

        if(! (is_numeric($incAnual) && $incAnual>0)){
            echo "El porcentaje de incremento anual debe ser un valor numerico mayor a 0. Intentar de nuevo por favor.\n";
        }
    }while(! (is_numeric($incAnual) && $incAnual>0));

    // ESTADO TRUE - FALSE
    do {
        echo "Moto disponible para venta? (si/no): ";
        $estado = strtolower(trim(fgets(STDIN))); // Leer entrada del usuario y normalizar

        if ($estado === 'si') {

            $resultado =  true;
            break;

        } elseif ($estado === 'no') {

            $resultado = false;
            break;

        } else {
            echo "Entrada no válida. Por favor, ingrese 'si' o 'no'.\n";
        }
    } while (true);

    // CREACIÓN DEL OBJETO MOTO
    echo "\n--- Validación Moto exitosa ---\n\n";

    $moto = new Moto($costo, $anioFabricacion, $descripcion, $incAnual, $resultado);

    return $moto;
}