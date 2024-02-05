<?php

$dni = $_POST["dni"];

if (strlen($dni) < 8 || strlen($dni) > 8) {
    $prueba = 1;
} else {
    $url = 'https://api.apis.net.pe/v1/dni?numero=' . $dni;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // You can set additional cURL options if needed
    
    $prueba = curl_exec($ch);

    if (curl_errno($ch)) {
        // Handle cURL error
        $prueba = 1;
    }

    curl_close($ch);
}

echo $prueba;
?>
