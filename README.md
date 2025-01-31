Aquí tienes el **README completo** para tu proyecto **Todo List API**, siguiendo el reto de [roadmap.sh](https://roadmap.sh/projects/todo-list-api) y basado en los endpoints que proporcionaste. Este archivo está listo para usar en tu repositorio.

---

# Todo List API 🚀

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php)](https://php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![JWT Auth](https://img.shields.io/badge/JWT-Auth-critical?logo=JSON%20web%20tokens)](https://jwt.io)

API RESTful para gestión de tareas con autenticación JWT, desarrollada como parte del [reto Todo List API de roadmap.sh](https://roadmap.sh/projects/todo-list-api). Este proyecto implementa todas las mejores prácticas recomendadas para APIs RESTful profesionales.

---

## Características Clave 🔥

- ✅ **Autenticación JWT segura**: Registro, inicio de sesión y cierre de sesión.
- ✅ **CRUD completo de tareas**: Crear, leer, actualizar y eliminar tareas.
- ✅ **Paginación integrada**: Listado de tareas con paginación.
- ✅ **Validación de datos en tiempo real**: Validaciones robustas para todos los endpoints.
- ✅ **Pruebas unitarias**: Suite de pruebas con PHPUnit y alta cobertura.

---

## Tecnologías Principales 🛠️

- **Laravel 11**: Framework backend para desarrollo rápido y seguro.
- **tymon/jwt-auth**: Autenticación basada en JSON Web Tokens (JWT).
- **Eloquent ORM**: Gestión de base de datos con un ORM potente y flexible.
- **PHPUnit**: Suite de pruebas unitarias y de integración.
- **Postman**: Colección de pruebas y documentación de la API.

---

## Endpoints 🚪

### Autenticación
| Método | Endpoint       | Descripción               |
|--------|----------------|---------------------------|
| POST   | `/register`    | Registrar usuario         |
| POST   | `/login`       | Iniciar sesión            |
| POST   | `/logout`      | Cerrar sesión             |
| GET    | `/me`          | Obtener perfil usuario    |

### Tareas
| Método | Endpoint       | Descripción               |
|--------|----------------|---------------------------|
| GET    | `/tasks`       | Listar todas las tareas   |
| POST   | `/tasks`       | Crear nueva tarea         |
| GET    | `/tasks/{id}`  | Obtener tarea específica  |
| PUT    | `/tasks/{id}`  | Actualizar tarea          |
| DELETE | `/tasks/{id}`  | Eliminar tarea            |

---

## Uso de la API 📡

### 1. Registro de usuario
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ana García",
    "email": "ana@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
```

**Respuesta exitosa (201):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "Ana García",
    "email": "ana@example.com"
  }
}
```

### 2. Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "ana@example.com",
    "password": "password"
  }'
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

### 3. Crear tarea (requiere autenticación)
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Comprar leche",
    "description": "Ir al supermercado"
  }'
```

**Respuesta exitosa (201):**
```json
{
  "success": true,
  "task": {
    "id": 1,
    "title": "Comprar leche",
    "description": "Ir al supermercado",
    "user_id": 1
  }
}
```

---

## Instalación 🛠️

1. Clonar repositorio:
```bash
git clone https://github.com/fer-gc05/todo-list-api.git
cd todo-list-api
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar entorno:
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

4. Configurar base de datos en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_list
DB_USERNAME=root
DB_PASSWORD=
```

5. Ejecutar migraciones:
```bash
php artisan migrate
```

6. Iniciar servidor:
```bash
php artisan serve
```

---

## Pruebas 🧪

Ejecutar todas las pruebas:
```bash
php artisan test
```

Generar reporte de cobertura (requiere Xdebug):
```bash
php artisan test --coverage-html coverage
```

---

## Estructura de una Tarea 📦

```json
{
  "id": 1,
  "title": "Revisar documentación",
  "description": "Revisar la documentación técnica del proyecto",
  "user_id": 1,
  "created_at": "2024-01-01T12:00:00.000000Z",
  "updated_at": "2024-01-01T12:00:00.000000Z"
}
```

---

## Manejo de Errores ⚠️

**Ejemplo de error (403 Forbidden):**
```json
{
  "success": false,
  "message": "Forbidden"
}
```

**Códigos de estado comunes:**
- 401 Unauthorized
- 403 Forbidden
- 404 Not Found
- 422 Validation Error

---

## Contribución 🤝

1. Haz fork del proyecto.
2. Crea tu feature branch: `git checkout -b feature/nueva-funcionalidad`.
3. Commit cambios: `git commit -m 'Add some feature'`.
4. Push: `git push origin feature/nueva-funcionalidad`.
5. Abre un Pull Request.

---

> **Nota del Desarrollador** 💡  
> Este proyecto implementa todas las mejores prácticas recomendadas por [roadmap.sh](https://roadmap.sh/projects/todo-list-api) para APIs RESTful profesionales. ¡Espero que te sea útil! 🚀

---

### Créditos
- Desarrollado por [Fernando Gil](https://github.com/tu-usuario).
- Basado en el [reto Todo List API de roadmap.sh](https://roadmap.sh/projects/todo-list-api).

---

¡Listo para usar! 🎉
