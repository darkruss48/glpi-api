<?php


// Fonction pour envoyer des requêtes à l'API GLPI
function _get_request($url, $method = 'GET', $data = null, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $headers[] = 'Content-Type: application/json';
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    if ($error = curl_error($ch)) {
        echo 'Erreur cURL : ' . $error;
    } else {
        // echo 'Réponse : ' . $response . "\n";
    }
    curl_close($ch);
    return json_decode($response, true);
}


function _post_request($url, $data, $headers=[])
{    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_POST, 1);
    $json_data = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    if ($error = curl_error($ch)) {
        echo 'Erreur cURL : ' . $error;
    } else {
        // echo 'Réponse création ticket : ' . $response . "\n";
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

function _patch_request($url, $data, $headers=[])
{    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    $json_data = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    if ($error) {
        echo 'Erreur cURL : ' . $error;
    } else {
        // echo 'Réponse mise à jour ticket : ' . $response . "\n";
    }
    
    curl_close($ch);
    return json_decode($response, true);
}



?>