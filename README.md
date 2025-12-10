# Biblioteca Digital Universe

Aplicación web sencilla para gestionar una biblioteca digital (usuarios, catálogo, préstamos y subida de archivos).

Estado: Proyecto escolar/prototipo — listo para ejecutar localmente.

Contenido
- `Codigo/` — código fuente PHP de la aplicación.
- `biblioteca_usuarios.sql`, `biblioteca_libros.sql`, `biblioteca_prestamos.sql` — SQL de ejemplo.
- `LICENSE` — licencia MIT.

Requisitos
- PHP 7.2+ (recomendado 7.4 / 8.x)
- MySQL / MariaDB
- Servidor local: XAMPP, WAMP, Laragon, IIS, o `php -S` para pruebas

Instalación rápida
1. Coloca el contenido de `Codigo/` dentro de la carpeta pública de tu servidor (por ejemplo `htdocs` en XAMPP), o usa el servidor embebido de PHP:
```powershell
php -S localhost:8000 -t Codigo
```

2. Crear/Importar la base de datos
- Opción rápida (importar SQL de ejemplo):
```powershell
mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < "C:\ruta\a\biblioteca_usuarios.sql"
mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < "C:\ruta\a\biblioteca_libros.sql"
mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < "C:\ruta\a\biblioteca_prestamos.sql"
```
- Opción manual: crea una base de datos y define las tablas `usuarios`, `libros`, `prestamos` según necesites (usa los `.sql` como referencia).

3. Configurar conexión
- Edita `Codigo/config/conexion.php` y actualiza `host`, `usuario`, `password` y `nombre_base_datos`.

4. Permisos
- Asegura permisos de escritura en `Codigo/uploads/libros/` y `Codigo/uploads/portadas/`.

Capturas e imágenes
- He creado `docs/images/` para que coloques ahí las capturas del proyecto. No encontré una carpeta llamada "biblioteca capturas" en el repositorio; si tienes las imágenes en tu máquina, cópialas a `docs/images/` o adjúntamelas y las agrego.

Sugerencias para publicar en GitHub
- Añade un `.gitignore` (ya incluido) para no subir credenciales ni archivos subidos.
- Reemplaza cualquier credencial real en `Codigo/config/conexion.php` por variables locales antes de publicar.

Contribuciones
- Para mejorar: crea un fork y un Pull Request describiendo los cambios.

Contacto
- Abre un issue en el repositorio si quieres colaboración o ayuda adicional.
