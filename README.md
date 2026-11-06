# bienes_raices_mvc

Sitio web para mostrar inmuebles, administrando las propiedades y sus vendedores con **PHP (MVC propio)**, **MySQL/MariaDB**, **JavaScript**, **Sass** y **Gulp**.

![bienesraices captura tablet](https://user-images.githubusercontent.com/56383926/224508336-ffc48a59-c8e2-4275-8ef3-1721e981ce6c.png)

> **Nota:** GitHub Pages no ejecuta PHP. Para verlo funcionando en línea hace falta un hosting con PHP y MySQL (ver "Despliegue en alwaysdata").

## Funciones

- **Sitio público:** inicio, listado de propiedades, detalle de cada propiedad, nosotros, blog y formulario de contacto (envía un correo).
- **Panel de administración** (con login): crear, editar y eliminar propiedades (con foto) y vendedores.

## Requisitos

- PHP 7.4 o superior (probado con 8.3) con las extensiones `mysqli`, `mbstring`, `openssl`, `curl` y **`gd`** (para redimensionar las fotos)
- MySQL 5.7+ / MariaDB 10.3+
- [Composer](https://getcomposer.org/)

## Ejecutarlo en tu computadora

```bash
# 1. dependencias de PHP
composer install

# 2. base de datos (tablas + datos de ejemplo opcionales)
mysql -u root -p -e "CREATE DATABASE bienesraices CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root -p bienesraices < database/schema.sql
mysql -u root -p bienesraices < database/datos-ejemplo.sql     # opcional

# 3. configuración: copia el ejemplo y pon tus datos
cp .env.example .env

# 4. crea tu usuario administrador (te pide la contraseña sin mostrarla)
php database/crear-admin.php tu@correo.com

# 5. servidor de desarrollo -> http://localhost:3000
php -S localhost:3000 -t public
```

El servidor integrado de PHP no usa el `.htaccess`, por lo que en esa vista las imágenes de `/build` y `/imagenes` se sirven directo pero las rutas "bonitas" (`/anuncios`, `/admin`...) necesitan Apache. La forma más sencilla de desarrollar es XAMPP/Laragon apuntando el sitio a la carpeta `public/`.

El panel de administración está en `/login`.

## Variables de entorno (`.env`)

| Variable | Descripción |
|---|---|
| `APP_BASE_PATH` | Ruta donde vive la app si comparte dominio con otra (ej. `/bienes-raices`). Vacía si está en la raíz del dominio |
| `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASS`, `DB_BD` | Conexión a la base de datos |
| `MAIL_HOST`, `MAIL_PORT`, `MAIL_USER`, `MAIL_PASS`, `MAIL_ENCRYPTION`, `MAIL_FROM` | Servidor SMTP para el formulario de contacto. Si `MAIL_HOST` está vacío no se envían correos: el mensaje queda en el log de PHP |
| `CONTACTO_EMAIL` | Dirección que recibe los mensajes del formulario de contacto |
| `APP_DEBUG` | `true` muestra los errores en pantalla (solo en desarrollo) |

El archivo `.env` **nunca** se sube a GitHub. La app lo busca primero en la raíz del proyecto y después en la carpeta de arriba (en un hosting es lo más seguro: fuera de la zona pública).

## Despliegue en alwaysdata

1. **Base de datos** (panel → *Databases → MySQL*): usa la base `TU_CUENTA_base` que ya trae la cuenta (o crea otra). Pon una contraseña al usuario de MySQL.
2. **Código:** por SSH,
   ```
   cd ~
   git clone https://github.com/InvedAllens/bienes_raices_mvc.git bienes_raices
   cd bienes_raices
   composer install --no-dev --optimize-autoloader
   ```
3. **Tablas, ejemplos y administrador:**
   ```
   mysql -h mysql-TU_CUENTA.alwaysdata.net -u TU_CUENTA -p TU_CUENTA_base < database/schema.sql
   mysql -h mysql-TU_CUENTA.alwaysdata.net -u TU_CUENTA -p TU_CUENTA_base < database/datos-ejemplo.sql   # opcional
   ```
4. **`.env`** en `~/.env` (fuera de la carpeta pública) con los datos de la base, el SMTP y `CONTACTO_EMAIL` (ver `.env.example`). Después `php database/crear-admin.php tu@correo.com`.
5. **Sitio** (*Web → Sites*): tipo **PHP** y directorio raíz **`/bienes_raices/public/`**. Así el código, `vendor/`, `.env` y `.git` quedan fuera de la zona pública.
   - Si tienes una dirección propia para esta app, úsala tal cual y deja `APP_BASE_PATH` vacío.
   - En el plan gratuito solo se puede usar la dirección de tu cuenta (`TU_CUENTA.alwaysdata.net`). Si ya la usa otra app, pon esta en una ruta: dirección `TU_CUENTA.alwaysdata.net/bienes-raices` y en el `.env` `APP_BASE_PATH=/bienes-raices`. Cada app usa su propia cookie de sesión, así que no comparten inicios de sesión.
6. Comprueba `/` (inicio), `/anuncios`, `/login` y que `/.env` no se pueda abrir.

La carpeta `public/imagenes/` guarda las fotos que subas desde el panel; debe poder escribirse.

## Estructura

```
public/            única carpeta pública: index.php (rutas), build/ (css, js, imágenes del sitio) e imagenes/ (fotos)
Router.php         enrutador + control de acceso al panel
controllers/       lógica de cada pantalla
models/            ActiveRecord y modelos (Propiedad, Vendedor, Admin)
views/             plantillas PHP
includes/          configuración, conexión a BD y funciones auxiliares
database/          esquema SQL, datos de ejemplo y script para crear el administrador
```
