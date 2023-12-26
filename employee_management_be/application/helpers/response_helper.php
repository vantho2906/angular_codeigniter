<?php
function generateResponse($status, $message, $data = null, $error = null)
{
    $response = [
        'status' => $status,
        'message' => $message,
    ];

    if ($data) $response['data'] = $data;

    if ($error) $response['error'] = $error;

    return $response;
}
