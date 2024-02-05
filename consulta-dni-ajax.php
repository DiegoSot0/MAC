<?php

$dni = isset($_POST["dni"]) ? htmlspecialchars($_POST["dni"]) : '';

if (strlen($dni) != 8) {
    $prueba = 1;
} else {
    // Using try-catch for error handling when making the API request
    try {
        $prueba = file_get_contents('https://api.apis.net.pe/v1/dni?numero=' . $dni);
    } catch (Exception $e) {
        // Handle the exception (e.g., log the error, set an appropriate value for $prueba)
        $prueba = 'Error fetching data from the API';
    }
}

echo $prueba;
