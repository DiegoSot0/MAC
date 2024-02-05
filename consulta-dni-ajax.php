<?php

// Verificar si el método de la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

// Verificar si se proporciona el parámetro 'dni' en la solicitud POST
if (!isset($_POST["dni"])) {
    http_response_code(400); // Solicitud incorrecta
    echo json_encode(["error" => "Parámetro 'dni' no proporcionado"]);
    exit;
}

$dni = $_POST["dni"];

if (strlen($dni) !== 8) {
    // Longitud de DNI incorrecta
    $response = ["error" => "Longitud de DNI incorrecta"];
} else {
    $url = 'https://api.apis.net.pe/v1/dni?numero=' . $dni;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Puedes establecer opciones adicionales de cURL si es necesario

    $apiResponse = curl_exec($ch);

    if (curl_errno($ch)) {
        // Manejar el error de cURL
        $response = ["error" => "Error en la solicitud cURL: " . curl_error($ch)];
    } else {
        // Decodificar la respuesta JSON de la API
        $responseData = json_decode($apiResponse, true);

        if ($responseData === null) {
            // Error al decodificar la respuesta JSON
            $response = ["error" => "Error al decodificar la respuesta JSON de la API"];
        } else {
            // Respuesta exitosa de la API
            $nombreCompleto = $responseData['nombre'];
            $numeroDocumento = $responseData['numeroDocumento'];

            $response = [
                "data" => [
                    "nombre" => $nombreCompleto,
                    "numeroDocumento" => $numeroDocumento
                ]
            ];
        }
    }

    curl_close($ch);
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');

// Establecer el código de estado de la respuesta según sea necesario
if (isset($response["error"])) {
    http_response_code(400); // Solicitud incorrecta
} else {
    http_response_code(200); // OK
}

echo json_encode($response);
