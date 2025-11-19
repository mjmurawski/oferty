# Konfiguracja JWT

## Krok 1: Wygeneruj klucze JWT

Na systemie Windows możesz użyć OpenSSL (jeśli jest zainstalowany) lub użyć online generatora.

### Opcja A: Używając OpenSSL (jeśli dostępny)

```bash
# W katalogu config/jwt
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

### Opcja B: Używając PHP (dla Windows)

Utwórz plik `generate_jwt_keys.php` w katalogu głównym projektu:

```php
<?php
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

$res = openssl_pkey_new($config);
openssl_pkey_export($res, $privateKey);
$publicKey = openssl_pkey_get_details($res)["key"];

if (!is_dir('config/jwt')) {
    mkdir('config/jwt', 0755, true);
}

file_put_contents('config/jwt/private.pem', $privateKey);
file_put_contents('config/jwt/public.pem', $publicKey);

echo "Klucze JWT zostały wygenerowane!\n";
```

Następnie uruchom:
```bash
php generate_jwt_keys.php
```

## Krok 2: Skonfiguruj zmienne środowiskowe

Dodaj do pliku `.env` (lub `.env.local`):

```env
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_passphrase_here
```

**WAŻNE:** Zmień `your_passphrase_here` na bezpieczne hasło!

## Krok 3: Sprawdź konfigurację

Upewnij się, że plik `config/packages/lexik_jwt_authentication.yaml` zawiera:

```yaml
lexik_jwt_authentication:
    secret_key: '%env(resolve:JWT_SECRET_KEY)%'
    public_key: '%env(resolve:JWT_PUBLIC_KEY)%'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
```

## Krok 4: Testowanie

Po skonfigurowaniu możesz przetestować API:

### Rejestracja:
```bash
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password123",
    "city": "Warszawa",
    "postalCode": "00-001"
}
```

### Logowanie:
```bash
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password123"
}
```

Odpowiedź zawiera token JWT, który należy używać w nagłówku:
```
Authorization: Bearer {token}
```

