<?php

function generateJWT($payload, $secret) {
  $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
  $payload = json_encode($payload);
  $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
  $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
  $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
  $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
  return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

function verifyJWT($jwt, $secret) {
  $parts = explode('.', $jwt);
  $header = json_decode(base64_decode($parts[0]), true);
  $payload = json_decode(base64_decode($parts[1]), true);
  $signature = base64_decode($parts[2]);

  if ($header['alg'] !== 'HS256') {
    return false;
  }

  $expectedSignature = hash_hmac('sha256', $parts[0] . "." . $parts[1], $secret, true);
  return hash_equals($signature, $expectedSignature);
}

function decodeJWT($jwt, $secret) {
  $parts = explode('.', $jwt);
  return json_decode(base64_decode($parts[1]), true);
}
