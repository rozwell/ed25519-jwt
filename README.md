# Ed25519 JWT
Instant Laravel/Lumen v9+ Ed25519 support for tymon/jwt-auth

## Installation

### 1. Register service provider *(Lumen only)*
Add below line in `bootstrap/app.php` **Service Providers** section:
```php
$app->register(Rozwell\Ed25519JWT\Providers\Ed25519JWTServiceProvider::class);
```

### 2. Change configuration *(optional)*
Change default configuration in `.env`:
```dotenv
JWT_ALGO=Ed25519
JWT_PUBLIC_KEY=ed25519.public
JWT_PRIVATE_KEY=ed25519.private
```

### 3. Generate keys with command:
```shell
php artisan jwt:keys
```

### 4. Ignore keys files
Add to `.gitignore`:
```shell
/storage/keys
```
