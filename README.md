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

# Biblioteca Digital Universe

Aplicación web sencilla para gestionar una biblioteca digital (registro de usuarios, catálogo, préstamos, subida de archivos y panel de administración).

-----------------
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

Galería de ejemplo
- Catalogo
![Catálogo](Codigo/img/biblioteca%20capturas/catalogo.png)

- Detalle de libro
![Detalle libro](Codigo/img/biblioteca%20capturas/detalle_libro.png)

- Formulario de registro de libro
![Formulario registro libro](Codigo/img/biblioteca%20capturas/form_registro_libro.png)

- Login
![Login](Codigo/img/biblioteca%20capturas/login.png)

- Mis préstamos
![Mis préstamos](Codigo/img/biblioteca%20capturas/mis_prestamos.png)

- Panel administrador
![Panel admin](Codigo/img/biblioteca%20capturas/panel_admin.png)

- Registro
![Registro](Codigo/img/biblioteca%20capturas/registro.png)

## 🙋 Sobre mí

Soy estudiante de **Ingeniería Informática** con experiencia en tesorería, logística y atención al cliente. Este proyecto fue realizado para integrar diseño, funcionalidad y buenas prácticas de desarrollo web.

---

## 📫 Contacto

- 📧 calero2121@hotmail.com