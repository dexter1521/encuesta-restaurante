# Instalacion en XAMPP (Intranet)

## 1. Requisitos
- PHP 8.2+ (XAMPP)
- MariaDB 10.5+
- Composer

## 2. Configurar proyecto
1. Copia el proyecto a `htdocs`.
2. Duplica `env` como `.env`.
3. Configura en `.env`:
   - `CI_ENVIRONMENT = production` (o `development`)
   - `app.baseURL = 'http://IP-DEL-SERVIDOR/encuesta-restaurante/'`
   - `database.default.hostname = localhost`
   - `database.default.database = encuesta_restaurante`
   - `database.default.username = root`
   - `database.default.password =`
   - `database.default.DBDriver = MySQLi`

## 3. Apache (XAMPP) para .htaccess raiz
- Asegura `mod_rewrite` habilitado en Apache.
- En `httpd.conf` (o vhost), permitir overrides en el proyecto:
  - `AllowOverride All`
- El `.htaccess` de la raiz ya redirige al front controller en `public/` y bloquea rutas sensibles.

## 4. Crear base de datos
```sql
CREATE DATABASE encuesta_restaurante CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

## 5. Migraciones y seeders
```bash
php spark migrate
php spark db:seed InitialDataSeeder
```

## 6. Credenciales iniciales
- Usuario: `admin`
- Contrasena: `Admin12345*`

## 7. Rutas principales
- Encuesta publica: `/encuesta`
- Login admin: `/admin/login`
- Dashboard: `/admin/dashboard`
- CRUD sucursales: `/admin/sucursales`
- CRUD preguntas: `/admin/preguntas`
- Reportes: `/admin/reportes`

## 8. Produccion intranet
- Compartir IP local del servidor para tablets/celulares.
- Mantener el servidor y MariaDB en red local segura.
- Cambiar la contrasena del admin al primer inicio.
