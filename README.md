# API de Pantallas Publicitarias - Desafío LatinAd

Proyecto desarrollado con Laravel 11, MySQL y autenticación JWT.

---

## 📑 Índice

* [📄 Descripción general](#-descripción-general)
* [🚀 Instalación y puesta en marcha](#-instalación-y-puesta-en-marcha)
* [🔐 Autenticación JWT](#-autenticación-jwt)
* [📈 Endpoints disponibles](#-endpoints-disponibles)
* [🛡️ Seguridad y control de acceso](#-seguridad-y-control-de-acceso)
* [🔧 Tecnologías usadas](#-tecnologías-usadas)
* [📘 Acceso a la documentación Swagger](#-acceso-a-la-documentación-swagger)
* [📊 Pruebas con Postman](#-pruebas-con-postman)
* [📁 Organización del código](#-organización-del-código)
* [📌 Notas adicionales](#-notas-adicionales)

---

## 📄 Descripción general

Esta API permite gestionar pantallas publicitarias (displays) para distintos usuarios autenticados. Incluye operaciones CRUD, autenticación con JWT y filtros avanzados. 

---

## 🚀 Instalación y puesta en marcha

1. **Clonar el repositorio:**

```bash
git clone https://github.com/tuusuario/desafio-latinad.git
cd desafio-latinad
```

2. **Instalar dependencias:**

```bash
composer install
```

3. **Configurar el entorno:**

```bash
cp .env.example .env
```

Editar el archivo `.env` para establecer la conexión con MySQL:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=latinad
DB_USERNAME=root
DB_PASSWORD=secret
```

4. **Generar claves necesarias:**

```bash
php artisan key:generate
php artisan jwt:secret
```

5. **Ejecutar migraciones y seeders:**

```bash
php artisan migrate --seed
```

Esto crea un usuario demo:

* **Email:** [naranjaspintadas@gmail.com](mailto:naranjaspintadas@gmail.com)
* **Contraseña:** password

6. **Levantar el servidor:**

```bash
php artisan serve
```

La API estará disponible en: `http://127.0.0.1:8000`

---

## 🔐 Autenticación JWT

### Endpoint de Login

```
POST /api/login
```

**Body:**

```json
{
  "email": "naranjaspintadas@gmail.com",
  "password": "password"
}
```

**Respuesta esperada:** token JWT para usar en los siguientes endpoints.

---

## 📈 Endpoints disponibles

Todos los endpoints requieren el header:

```
Authorization: Bearer TU_TOKEN
Content-Type: application/json
```

### CRUD de pantallas (`/api/displays`)

* **GET /**: lista de pantallas del usuario (con filtros `name`, `type`, `page`, `perPage`).
* **GET /{id}**: detalle de una pantalla del usuario.
* **POST /**: crear pantalla (ver formato de ejemplo más abajo).
* **PUT /{id}**: actualizar una pantalla existente.
* **DELETE /{id}**: eliminar una pantalla del usuario.

### Ejemplo de body para crear/editar:

```json
{
  "name": "Pantalla Costanera Norte",
  "description": "Pantalla LED frente al mar en Mar del Plata",
  "price_per_day": 4200.50,
  "resolution_height": 1080,
  "resolution_width": 1920,
  "type": "outdoor"
}
```

### Otros endpoints

* **GET /api/me**: datos del usuario autenticado.
* **POST /api/logout**: cerrar sesión.
* **POST /api/refresh**: renovar el token JWT.

---

## 🛡️ Seguridad y control de acceso

* Solo se permite operar sobre pantallas del usuario autenticado.
* Se utilizan **políticas de autorización** (`DisplayPolicy`) para validar propiedad.
* Validaciones completas en todos los formularios (campos requeridos, tipo, formato, valores permitidos).

**Restricción de tipo:**

* El campo `type` sólo acepta: `indoor` o `outdoor`.
* Validado mediante reglas de Laravel en el controlador.

---

## 🔧 Tecnologías usadas

* Laravel 11
* MySQL
* Tymon JWT-Auth
* Postman para pruebas de la API
* **Swagger (Laravel OpenAPI):** documentación técnica automática disponible

---

## 📘 Acceso a la documentación Swagger

Una vez levantado el servidor local (`php artisan serve`), la documentación Swagger está disponible en:

```
http://127.0.0.1:8000/api/documentation
```

Desde allí se pueden consultar todos los endpoints, ver los esquemas, parámetros, tipos de datos, ejemplos y probar las llamadas directamente desde el navegador.

---

## 📊 Pruebas con Postman

Se incluye una colección de Postman exportada (`Desafio LatinAd.postman_collection.json`) en la raíz del proyecto. Incluye todos los endpoints:

* Login
* Listar
* Ver detalle
* Crear
* Editar
* Eliminar
* Perfil de usuario


**Nombres de las solicitudes en la colección:**

* Login de usuario
* Listar pantallas (GET all)
* Ver pantalla por ID
* Crear pantalla
* Editar pantalla
* Eliminar pantalla
* Perfil de usuario autenticado
* Filtros por nombre, tipo y paginado

---

## 📁 Organización del código

* `routes/api.php`: definición de endpoints.
* `app/Http/Controllers`: controladores de lógica.
* `app/Models`: modelos Eloquent (User, Display).
* `app/Policies`: políticas de acceso.
* `database/seeders`: datos de prueba.
* `config/jwt.php`: configuración del paquete JWT.

---

## 📌 Notas adicionales

* El código fue escrito siguiendo PSR y buenas prácticas de Laravel.
* Se evitaron valores sensibles hardcodeados. Se utilizan variables de entorno (`.env`).
* El archivo `.gitignore` incluye exclusión por defecto de dependencias, caché y archivos sensibles. No requiere modificaciones adicionales.
* El proyecto puede desplegarse fácilmente en cualquier entorno compatible con PHP 8.2+, Composer y MySQL.
