<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="text-align: center; margin-top: 10rem;" >Pedido Realizado</title>
</head>
<body>
    <div class="success-container" style="text-align: center;">
        <h1>¡Pedido Realizado con Éxito!</h1>
        <p>Tu número de pedido es: <strong>#<?php echo htmlspecialchars($orderId); ?></strong></p>
        <p>Total a pagar: <strong>₡<?php echo number_format($totalAmount, 2); ?></strong></p>
        <p>Puedes proceder al pago utilizando el método que seleccionaste.</p>
        <a href="/" class="btn btn-primary"style="margin-bottom: 30rem;" >Volver al Inicio</a>
    </div>
</body>
</html>