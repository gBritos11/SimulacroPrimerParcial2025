<?php
// Incluyo a las clases Cliente, Moto y Ventas
include_once 'Cliente.php';
include_once 'Moto.php';
include_once 'Venta.php';

// Clase Empressa
class Empresa{

    // Atributos - Variables
    private string $nombre;
    private string $direccion;
    private array $coleccionClientes;//Colección de objetos Clientes
    private array $coleccionMotos;//Colección de objetos Motos
    private array $coleccionVentas;//Colección de objetos Ventas

    // Constructor
    public function __construct(
        string $nombre,
        string $direccion,
        array $coleccionClientes,
        array $coleccionMotos,
        array $coleccionVentas
    ) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->coleccionClientes = $coleccionClientes;
        $this->coleccionMotos = $coleccionMotos;
        $this->coleccionVentas = $coleccionVentas;
    }

    // Metodos de acceso a las variables:
    // Getters - Observadoras
    public function getNombre(): string{
        return $this->nombre;
    }

    public function getDireccion(): string{
        return $this->direccion;
    }

    public function getColeccionClientes(): array{
        return $this->coleccionClientes;
    }

    public function getColeccionMotos(): array{
        return $this->coleccionMotos;
    }

    public function getColeccionVentas(): array{
        return $this->coleccionVentas;
    }

    // Setters - Modificadoras
    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }

    public function setDireccion(string $direccion): void{
        $this->direccion = $direccion;
    }

    public function setColeccionClientes(array $coleccionClientes): void{
        $this->coleccionClientes = $coleccionClientes;
    }

    public function setColeccionMotos(array $coleccionMotos): void{
        $this->coleccionMotos = $coleccionMotos;
    }

    public function setColeccionVentas(array $coleccionVentas): void{
        $this->coleccionVentas = $coleccionVentas;
    }

    // MÉTODOS
    /**
     * Retorna una representación en cadena de la clase empresa
     * 
     * @return string
    */
    public function __toString(): string{
        // COLECCIÓN CLIENTES
        $clientes = "";
        foreach ($this->coleccionClientes as $cliente) {
            $clientes .= $cliente->__toString() . "\n";
        }

        // COLECCIÓN MOTOS
        $motos = "";
        foreach ($this->coleccionMotos as $moto) {
            $motos .= $moto->__toString() . "\n";
        }

        // COLECCIÓN VENTAS
        $ventas = "";
        foreach ($this->coleccionVentas as $venta) {
            $ventas .= $venta->__toString() . "\n";
        }

        return
        "----------------------------\n".
        "EMPRESA -> ".$this->getNombre()."\n".
        $this->getDireccion()."\n".
        "=== CLIENTES ===\n".$clientes.
        "=== STOCK MOTOS ===\n".$motos.
        "=== VENTAS ===\n".$ventas.
        "----------------------------\n";
    }

    /**
     * Recorre la colección de motos de la empresa y retorna la referencia
     * al objeto moto cuyo código coincide con el recibido por parámetro
     * 
     * @param int $codigoMoto código de la moto
     * @param mixed
    */
    public function retornarMoto(int $codigoMoto): mixed{
        /*
            $resultado null || object
        */
        $resultado = null;

        foreach($this->getColeccionMotos() as $moto){
            if($moto->getCodigo() == $codigoMoto){
                $resultado = $moto;
            }
        }

        return $resultado;
    }

    /**
     * Recorre una colección de códigos de motos y se busca su objeto Moto Correspondiente.
     * Luego se incorpora a la colección de motos de la instancia Venta
     * 
     * @param array $colCodigosMoto colección de códigos de motos
     * @param object $objCliente objeto Cliente
     * @return float importe final del precio venta
    */
    public function registrarVenta(array $colCodigosMoto, object $objCliente): float{
        /*
            float $importeFinalVenta
            object $fechaVenta, Venta
        */
        $importeFinalVenta = -1;

        if($objCliente->getAlta()){

            // Obtengo Fecha
            $fechaVenta = DatosFecha();

            // Creo el objeto Venta
            $venta = new Venta(
                $fechaVenta,
                $objCliente,
                []//colección vacía de Motos
            );

            // Recorro los códigos de Motos
            foreach($colCodigosMoto as $codigo){
                $moto = $this->retornarMoto($codigo);

                // Si la moto tiene el mismo código y está disponible, la incorporamos
                if($moto && $moto->getEstado()){
                    $venta->incorporarMoto($moto);
                }
                
            }

            // Guardamos la venta si se incorporó al menos una moto
            if(!empty($venta->getColeccionMotos())){
                // Agrego la Venta a la colección de Ventas de la Empresa
                $this->coleccionVentas[] = $venta;
                
                //Calculo el importe final
                $importeFinalVenta = $venta->getPrecioVenta();
            }
        }
        
        return $importeFinalVenta;
    }
    
    /**
     * Retorna una colección con las ventas realizadas al cliente
     * 
     * @param string $tipoDoc tipo de documento
     * @param int $numDoc número de documento
     * @return array
    */
    public function retornarVentasPorClientes(string $tipoDoc, int $numDoc): array{
        /*
            array $ventasAlCliente
        */

        //Creo el array vacío que luego voy a retornar
        $ventasAlCliente = [];

        //Recorro la colección de ventas
        foreach($this->coleccionVentas as $venta){

            //Verifico que se cumplan las condiciones
            if(
                $venta->getCliente()->getPersona()->getTipoDocumento() == $tipoDoc &&
                $venta->getCliente()->getPersona()->getNumDocumento() == $numDoc
            ){
                $ventasAlCliente[] = $venta;//Guardo la venta
            }
        }

        return $ventasAlCliente;
    }
}