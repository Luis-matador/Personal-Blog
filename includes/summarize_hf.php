<?php
// Resumen automático usando Hugging Face Inference API (facebook/bart-large-cnn)
function obtenerResumenHF($texto) {
    $token = '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';
    $url = 'https://api-inference.huggingface.co/models/facebook/bart-large-cnn';
    $data = ["inputs" => $texto];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);
    error_log('HF response: ' . $response);
    if ($curlError) {
        error_log('HF CURL error: ' . $curlError);
    }
    $result = json_decode($response, true);

    if (isset($result[0]['summary_text'])) {
        error_log('HF summary: ' . $result[0]['summary_text']);
        return trim($result[0]['summary_text']);
    }
    error_log('HF summary not found');
    return null;
}
