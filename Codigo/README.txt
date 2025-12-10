Biblioteca Digital - Proyecto

Descripción
----------
Este proyecto es una aplicación web simple de gestión de una biblioteca digital. Permite registrar usuarios, añadir libros (con archivos y portadas), prestar y devolver libros, y consultar un catálogo. El proyecto está escrito en PHP y usa una base de datos MySQL.

Contenido del repositorio
-------------------------
- `Codigo/` : código fuente de la aplicación (archivos PHP, CSS, imágenes, uploads, modelos y vistas).
- `biblioteca_usuarios.sql`, `biblioteca_libros.sql`, `biblioteca_prestamos.sql` : archivos SQL de ejemplo con datos y estructura.

Requisitos
---------
- PHP 7.2+ (o la versión que soporte las funciones usadas). Recomendado PHP 7.4 o 8.x.
- Servidor web local (XAMPP, WAMP, Laragon, IIS) o el servidor embebido de PHP.
- MySQL o MariaDB.
- Extensiones PHP típicas: `mysqli`, `fileinfo` (para subir archivos), `mbstring`.

Instalación rápida
-----------------
1. Clona o descarga el repositorio y coloca el contenido de la carpeta `Codigo/` en la raíz pública de tu servidor (por ejemplo `htdocs` en XAMPP), o usa el servidor embebido de PHP.

2. Crear la base de datos
   - Opción A (importar ejemplos):
     - Crea una base de datos nueva en MySQL (por ejemplo `biblioteca`).
     - Desde línea de comandos (PowerShell) ejecuta:
       ```powershell
       mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < ruta\a\biblioteca_usuarios.sql
       mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < ruta\a\biblioteca_libros.sql
       mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < ruta\a\biblioteca_prestamos.sql
       ```
     - También puedes importar los archivos SQL usando phpMyAdmin (Importar → subir archivo `.sql`).

   - Opción B (crear desde cero):
     - Sí. Puedes crear la base de datos y las tablas manualmente si prefieres. Los archivos `.sql` incluidos tienen la estructura y datos de ejemplo; úsalos como referencia para crear las tablas o modifícalos según tus necesidades.

3. Configurar la conexión a la base de datos
   - Edita `Codigo/config/conexion.php` y actualiza las credenciales de conexión (`host`, `usuario`, `password`, `nombre_base_datos`).

4. Permisos de carpetas
   - Asegúrate que las carpetas `Codigo/uploads/libros/` y `Codigo/uploads/portadas/` tengan permisos de escritura para el usuario del servidor web, ya que ahí se guardan los archivos subidos.

Ejecutar la aplicación (opciones)
-------------------------------
- Con XAMPP/WAMP/Laragon: coloca `Codigo/` en la carpeta pública (`htdocs`), inicia Apache y MySQL, y abre `http://localhost/Codigo/`.
- Servidor embebido de PHP (para pruebas rápidas):
  - Abre PowerShell en la carpeta que contiene `Codigo` y ejecuta:
    ```powershell
    php -S localhost:8000 -t Codigo
    ```
  - Luego visita `http://localhost:8000`.

Archivos SQL incluidos
----------------------
- `biblioteca_usuarios.sql` : estructura y datos de ejemplo para la tabla de usuarios.
- `biblioteca_libros.sql` : estructura y datos de ejemplo para la tabla de libros.
- `biblioteca_prestamos.sql` : estructura y datos de ejemplo para la tabla de préstamos.

Notas sobre crear la base de datos desde cero
-------------------------------------------
- Si decides crear todo desde cero, asegúrate de crear al menos las tablas: `usuarios`, `libros`, `prestamos` con campos esenciales (ID, nombre/título, rutas de archivo, fechas, claves foráneas). Puedes mirar los `.sql` incluidos para copiar la estructura de las tablas y relaciones.

Configuración adicional y buenas prácticas
-----------------------------------------
- Revisa `Codigo/config/conexion.php` para establecer el juego de caracteres (`utf8mb4`) y manejo de errores.
- Considera restringir los tipos de archivos permitidos al subir (por ejemplo PDF para libros, JPG/PNG para portadas) y limitar el tamaño.
- No subas contraseñas reales ni credenciales al repositorio público. Usa variables de entorno o un archivo de configuración local que no subas al repositorio.

Problemas comunes y soluciones
-----------------------------
- Error de conexión a la base de datos: verifica `host`, `usuario`, `password` y que MySQL esté ejecutándose.
- Permiso denegado al subir archivos: ajusta permisos de `uploads/` y propietario del servidor web.
- Páginas en blanco o errores PHP: activa `display_errors` en `php.ini` durante desarrollo o revisa el `error_log`.

Contribuir
---------
Si deseas mejorar el proyecto (corregir errores, agregar funciones), crea un fork y envía un Pull Request. Incluye una descripcion clara de los cambios.

Licencia
--------
Añade aquí la licencia que prefieras (por ejemplo MIT). Si quieres, puedo ayudarte a agregar un archivo `LICENSE` apropiado.

Contacto
-------
Si alguien tiene dudas o quiere usar el proyecto, puede abrir un issue en el repositorio de GitHub.

--
README actualizado para subir a GitHub públicamente. Si quieres, puedo también:
- Añadir un archivo `LICENSE` (ej. MIT).
- Crear un `README.md` con formato Markdown para GitHub (más visual).
- Preparar un `.gitignore` para no subir credenciales ni archivos subidos.
# Proyecto Biblioteca Digital Universe

## Instrucciones para ejecutar el proyecto en tu PC

### 1. Requisitos
- XAMPP, WAMP o cualquier servidor con PHP y MySQL
- MySQL Workbench, phpMyAdmin o similar

### 2. Importar la base de datos
1. Abre MySQL Workbench o phpMyAdmin.
2. Crea una base de datos llamada `biblioteca` (o el nombre que prefieras, pero recuerda cambiarlo en el archivo de conexión).
3. Importa el archivo `base_datos.sql` incluido en la carpeta del proyecto. Esto creará las tablas e insertara los datos automáticamente.

### 3. Configurar la conexión a la base de datos
1. Abre el archivo `conexion.php` en el proyecto.
2. Modifica los siguientes datos según tu entorno local:

```
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'biblioteca';
```

3. Guarda los cambios.

### 4. Ejecutar el proyecto
1. Copia la carpeta del proyecto en la carpeta `htdocs` de XAMPP (o la correspondiente en tu servidor local).
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre tu navegador y accede a: `http://localhost/proyecto_final/index.php`


