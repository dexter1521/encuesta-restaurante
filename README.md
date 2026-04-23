# Sistema Web de Encuestas de Satisfaccion para Restaurante

Aplicacion desarrollada en **CodeIgniter 4 + MariaDB + Bootstrap (SB Admin 2)** para operar en **intranet local**.

Despliegue recomendado:
- **Docker Compose (PHP 8.2+)** para entorno estable y reproducible.
- XAMPP como alternativa, siempre que use PHP 8.2+.

## Modulos implementados
- Login de administrador con sesion segura.
- Dashboard con KPIs:
  - Encuestas del dia
  - Encuestas de la semana
  - Promedio general
  - Ultimas respuestas
  - Graficas por sucursal
  - Preguntas peor calificadas
  - Comentarios recientes
- CRUD de sucursales (alta, edicion, activar/desactivar, borrado logico).
- CRUD de preguntas (categoria, tipo escala 1-5, orden, estado, borrado logico).
- Encuesta publica sin login, apta para tablet/celular.
- Fecha y hora de encuesta registradas automaticamente en backend (no editables por cliente).
- Reportes por fecha/sucursal/rango y exportacion CSV (compatible con Excel).
- Registro de logs de acciones administrativas.

## Arquitectura (MVC)
- Controladores: `app/Controllers`
- Modelos: `app/Models`
- Servicios de negocio: `app/Services`
- Vistas admin/publica: `app/Views`
- Migraciones y seeders: `app/Database`

## Base de datos
- Migracion principal: `app/Database/Migrations/2026-04-22-220000_CreateSurveySystem.php`
- Seeders:
  - `InitialDataSeeder`
  - `UserSeeder`
  - `BranchSeeder`
  - `QuestionSeeder`
- SQL manual: `docs/sql/initial_schema.sql`

## Arranque rapido
1. Configurar `.env` con base URL y credenciales MariaDB.
2. Ejecutar:
   - `php spark migrate`
   - `php spark db:seed InitialDataSeeder`
3. Abrir:
   - Encuesta: `/encuesta`
   - Admin: `/admin/login`

Credenciales iniciales:
- Usuario: `admin`
- Contrasena: `Admin12345*`

## Documentacion
- Guia de despliegue local: `docs/INSTALACION.md`
- Guia con Docker Compose (PHP 8.2): `docs/DOCKER.md`

## Notas de repositorio
- El archivo `.env` no se versiona.
- Usa `.env.example` como base para nuevos entornos.
- El `.gitignore` ya esta configurado para CI4 + Docker + artefactos locales.
