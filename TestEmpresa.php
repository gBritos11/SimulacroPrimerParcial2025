<?php
// Incluyo los archivos necesarios
include_once 'Cliente.php';
include_once 'Moto.php';
include_once 'Venta.php';
include_once 'Empresa.php';

// === CREACIÓN Y PRUEBAS ===

//1. Crear objetos Cliente

// PRIMERA INSTANCIA
$cliente1 = datosCliente();

// SEGUNDA INSTANCIA
$cliente2 = datosCliente();

// 2. Crear objetos Moto

// PRIMERA INSTANCIA
$moto1 = datosMoto();

// SEGUNDA INSTANCIA
$moto2 = datosMoto();

// TERCERA INSTANCIA
$moto3 = datosMoto();

// 3. Crear objeto Empresa
$empresa = new Empresa(
    "Alta Gama",
    "Av Argentina 123",
    [$cliente1, $cliente2],
    [$moto1, $moto2, $moto3],
    []
);

echo "=== REALIZAR VENTAS ===\n";

// 5.
$ventaTotal = $empresa->registrarVenta([12,13], $cliente2);
echo (
        $ventaTotal == -1 ?
        "-XXX- NO SE PUDO COMPLETAR LA VENTA -XXX-\n" :
        "=== VENTA COMPLETADA ===\nTotal: $$ventaTotal\n"
    )."========================\n"
;

// 6.
$ventaTotal = $empresa->registrarVenta([0], $cliente2);
echo (
        $ventaTotal == -1 ?
        "-XXX- NO SE PUDO COMPLETAR LA VENTA -XXX-\n" :
        "=== VENTA COMPLETADA ===\nTotal: $$ventaTotal\n"
    )."========================\n"
;

// 7.
$ventaTotal = $empresa->registrarVenta([2], $cliente2);
echo (
        $ventaTotal == -1 ?
        "-XXX- NO SE PUDO COMPLETAR LA VENTA -XXX-\n" :
        "=== VENTA COMPLETADA ===\nTotal: $$ventaTotal\n"
    )."========================\n"
;

// 8.
$empresa->retornarVentasPorClientes("DNI", 46179117);

// 9.
$empresa->retornarVentasPorClientes("DNI", 12345678);

// 10.
echo $empresa;