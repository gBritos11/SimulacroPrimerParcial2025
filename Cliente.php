<?php
// Incluyo la clase Persona
include_once 'C:/Users/54299/OneDrive/Escritorio/GBritos/Universidad/IPOO/TP2/Persona.php';

// Clase Cliente
class Cliente{

    // Atributos - Variables
    private object $persona;
    private bool $alta;//true = dado de alta; false = dado de baja

    // Constructor
    public function __construct(object $persona, bool $alta){
        $this->persona = $persona;
        $this->alta = $alta;
    }

    // Metodos de acceso a las variables:
    // Getters - Observadoras
    public function getPersona(): object{
        return $this->persona;
    }

    public function getAlta(): bool{
        return $this->alta;
    }

    // Setters - Modificadoras
    public function setPersona(object $persona): void{
        $this->persona = $persona;
    }

    public function setAlta(bool $alta): void{
        $this->alta = $alta;
    }

    // MÉTODOS
    /**
     * Retorna una representación en cadena de la clase Cliente
     * 
     * @return string
    */
    public function __toString(): string{
        return 
        "----------------------------\n".
        "CLIENTE:\n".
        $this->getPersona()."\n".
        "Dado de alta -> ".($this->getAlta() ? "sí" : "no")."\n".
        "----------------------------\n";
    }
}

// FUNCIONES

/**
 * Obtengo los datos de un Cliente
 * 
 * @return object $cliente
*/
function datosCliente(): object{
    // Objeto Persona
    $persona = datosPersona();

    do {
        echo "Cliente dado de alta? (si/no): ";
        $alta = strtolower(trim(fgets(STDIN))); // Leer entrada del usuario y normalizar

        if ($alta === 'si') {

            $resultado =  true;
            break;

        } elseif ($alta === 'no') {

            $resultado = false;
            break;

        } else {
            echo "Entrada no válida. Por favor, ingrese 'si' o 'no'.\n";
        }
    } while (true);

    echo "\n--- Validación Cliente exitosa ---\n\n";

    // CREACIÓN OBJETO CLIENTE
    $cliente = new Cliente($persona, $resultado);

    return $cliente;
}