# Docker Compose (PHP 8.2 + MariaDB)

Este proyecto ya incluye `docker-compose.yml` para evitar depender de XAMPP 8.2.

## Servicios
- `app`: PHP 8.2 + Apache (`http://localhost:8080`)
- `db`: MariaDB 11 (`localhost:3307`)
- `phpmyadmin`: administración DB (`http://localhost:8081`)

## 1. Configurar `.env` para Docker
Si no existe `.env`, crea uno desde `env`.

Configura al menos estas variables:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = db
database.default.database = encuesta_restaurante
database.default.username = encuesta_user
database.default.password = encuesta_pass
database.default.DBDriver = MySQLi
database.default.port = 3306
```

## 2. Levantar contenedores
```bash
docker compose up -d --build
```

## 3. Instalar dependencias PHP (Composer)
```bash
docker compose exec app composer install
```

## 4. Ejecutar migraciones y seeders
```bash
docker compose exec app php spark migrate
docker compose exec app php spark db:seed InitialDataSeeder
```

## 5. Acceso
- App: `http://localhost:8080/encuesta`
- Admin: `http://localhost:8080/admin/login`
- phpMyAdmin: `http://localhost:8081`

Credenciales iniciales admin:
- Usuario: `admin`
- Contrasena: `Admin12345*`

## 6. Uso en intranet (celular/tablet)
Desde la red local, abre:
- `http://IP_DEL_SERVIDOR:8080/encuesta`

Y ajusta en `.env`:
```ini
app.baseURL = 'http://IP_DEL_SERVIDOR:8080/'
```
