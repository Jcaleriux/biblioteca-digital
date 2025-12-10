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


