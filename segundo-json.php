<?php

$dni = isset($_POST["dni"]) ? $_POST["dni"] : '';

if (strlen($dni) != 8) {
    $prueba = 1;
} else {
    $apiEndpoint = 'https://macexpress2.pcm.gob.pe/AtencionCiudadano/AtenderCiudadano/listarciudadano';
    $url = $apiEndpoint . '?dni=' . urlencode($dni);

    // Using try-catch for error handling when making the API request
    try {
        $prueba = file_get_contents($url);
        if ($prueba === FALSE) {
            // Handle the case when file_get_contents fails
            $prueba = 'Error fetching data from the API';
        }
    } catch (Exception $e) {
        // Handle the exception (e.g., log the error, set an appropriate value for $prueba)
        $prueba = 'Error during API request: ' . $e->getMessage();
    }
}

echo $prueba;
