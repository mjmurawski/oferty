<?php

/**
 * Script do generowania kluczy JWT dla Windows
 * Uruchom: php generate_jwt_keys.php
 */

$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

$res = openssl_pkey_new($config);
if (!$res) {
    echo "Błąd podczas generowania kluczy: " . openssl_error_string() . "\n";
    exit(1);
}

openssl_pkey_export($res, $privateKey);
$publicKeyDetails = openssl_pkey_get_details($res);
$publicKey = $publicKeyDetails["key"];

$jwtDir = __DIR__ . '/config/jwt';
if (!is_dir($jwtDir)) {
    mkdir($jwtDir, 0755, true);
}

file_put_contents($jwtDir . '/private.pem', $privateKey);
file_put_contents($jwtDir . '/public.pem', $publicKey);

echo "✓ Klucze JWT zostały wygenerowane w katalogu: config/jwt/\n";
echo "✓ Pamiętaj, aby dodać zmienne środowiskowe do pliku .env:\n";
echo "  JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem\n";
echo "  JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem\n";
echo "  JWT_PASSPHRASE=twoje_bezpieczne_haslo\n";

