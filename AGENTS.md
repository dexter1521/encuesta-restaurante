# Reglas para Agentes en el Repositorio

Este documento establece las reglas y directrices que deben seguir todos los agentes (subagentes de IA, scripts automatizados o herramientas de desarrollo) que interactuen con este repositorio.

## Proyecto
Este repositorio contiene el proyecto **sistema web de encuestas de satisfaccion para restaurante** desarrollado con **CodeIgniter 4**.

## Reglas Generales
1. **No modificar archivos criticos sin aprobacion**:
Antes de editar archivos como `composer.json`, `Dockerfile`, archivos de configuracion en `app/Config/`, o bases de datos, obtener confirmacion del desarrollador jefe.

2. **Seguir estandares de CodeIgniter 4**:
Todas las modificaciones deben adherirse a las mejores practicas de CodeIgniter 4, incluyendo estructura de directorios, convenciones de nomenclatura y patrones de diseno.

3. **Validar cambios**:
Despues de cualquier modificacion, ejecutar pruebas unitarias (`phpunit`), verificar sintaxis y asegurar que el proyecto compile sin errores.

4. **Documentar cambios**:
Proporcionar comentarios claros en el codigo y actualizar documentacion relevante (como `README.md` o archivos en `docs/`).

5. **Seguridad primero**:
No exponer informacion sensible como claves API, contrasenas o datos de configuracion en commits o registros.

6. **Usar control de versiones**:
Todos los cambios deben hacerse a traves de branches separados y pull requests para revision.

7. **No hacer commit de archivos temporales o basura**:
Evitar incluir archivos de debug, cookies, archivos HTML generados temporalmente, scripts de prueba o cualquier archivo no relacionado con el codigo fuente principal del proyecto.

## Reglas Especificas para Agentes
- **Acceso limitado**: Los agentes solo pueden acceder a archivos dentro del workspace definido. No intentar acceder a directorios externos o sistemas no autorizados.
- **Ejecucion controlada**: No ejecutar comandos destructivos (como `rm -rf`) sin verificacion explicita.
- **Monitoreo**: Registrar todas las acciones realizadas para auditoria.
- **Compatibilidad**: Asegurar que cualquier herramienta o script sea compatible con el entorno (Windows, Docker, etc.).
- **Excepcion Docker autorizada**: Se permite modificar `Dockerfile` y `docker-compose.yml` cuando el objetivo sea mantener operativo el entorno local Docker de este proyecto y exista autorizacion explicita del desarrollador responsable.

## Contacto
Para preguntas o modificaciones a estas reglas, contactar al administrador del repositorio.
