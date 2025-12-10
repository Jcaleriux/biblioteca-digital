<?php
// Header común para todas las páginas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? htmlspecialchars($titulo) : 'Biblioteca Digital Universe'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700|Open+Sans:400,700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'menu.php'; ?>

