# Sistema de Gestión de Comunicados y Matrículas para Escuela

## Características

- **Gestión de Oferta Académica**
  - Visualización de academias y cursos disponibles
  - Detalles de cursos incluyendo costo, duración y modalidad

- **Sistema de Matrícula**
  - Formularios de inscripción interactivos usando Livewire con proceso por pasos
  - Registro de estudiantes con información demográfica (género, fecha de nacimiento)
  - Selección de cursos y seguimiento del estado de matrícula

- **Sistema de Comunicación**
  - Comunicaciones dirigidas a padres/tutores
  - Filtrado por curso específico o rango de edad del estudiante
  - Programación de envíos y seguimiento del estado (borrador, enviado, programado)
  - Envío de correos electrónicos a tutores con seguimiento de lectura

- **Procesamiento de Pagos**
  - Soporte para múltiples métodos de pago (efectivo, transferencia bancaria)

## Stack Tecnológico

- **Backend**
  - Laravel 12.0
  - PHP 8.2+
  - MySQL

- **Frontend**
  - Livewire 3.4+
  - TailwindCSS 3.1+

- **Documentación API**
  - L5-Swagger 9.0+

- **Desarrollo y Pruebas**
  - Laravel Sail
  - PHPUnit

## Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js y NPM
- MySQL
- Docker (opcional, para usar Laravel Sail)

## Instalación

### Con Laravel Sail (recomendado)

Laravel Sail es una interfaz de línea de comandos ligera para interactuar con el entorno de desarrollo Docker predeterminado de Laravel.

#### Instalación en proyectos existentes

1. Clonar el repositorio
```bash
git clone https://github.com/tinchofuentes/desafio-paymon-dusk
cd desafio-paymon-dusk
```

2. Instalar dependencias de Composer con Docker
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php84-composer:latest \
composer install --ignore-platform-reqs
```

3. Configurar variables de entorno
```bash
cp .env.example .env
```
4. Agregar la siguiente línea al archivo .env
```env
APP_PORT=8000
```
También se incluye el archivo .env.dusk.local para configuración específica de los tests con Dusk. Copiar la APP_KEY generada al final en ambos archivos .env y .env.dusk.local.

4. Ejecutar la instalación de Sail
```bash
php artisan sail:install
```

5. Iniciar los contenedores de Sail
```bash
./vendor/bin/sail up -d
```

6. Generar clave de aplicación
```bash
./vendor/bin/sail artisan key:generate
```
Asegúrate de copiar esta misma clave al archivo .env.dusk.local.

7. Ejecutar migraciones y seeders
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

8. Instalar dependencias frontend y compilar assets
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

9. Acceder a la aplicación en http://localhost:8000

10. Instalar Laravel Dusk
```bash
./vendor/bin/sail composer require --dev laravel/dusk
```

#### Configurando un alias para Sail

Para evitar escribir `./vendor/bin/sail` cada vez, puedes configurar un alias en tu shell:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Agrega esto a tu archivo de configuración de shell (~/.bashrc, ~/.zshrc, etc.) y reinicia la terminal.

Una vez configurado, puedes usar simplemente:

```bash
sail up -d
sail artisan migrate
sail npm run build
```

### Con Docker Compose

1. Clonar el repositorio
```bash
git clone https://github.com/yourusername/school-management-system.git
cd school-management-system
```

2. Configurar variables de entorno
```bash
cp .env.example .env
```

3. Levantar los contenedores Docker
```bash
docker compose up -d
```

4. Instalar dependencias PHP
```bash
docker compose exec app composer install
```

5. Generar clave de aplicación
```bash
docker compose exec app php artisan key:generate
```

6. Ejecutar migraciones y seeders
```bash
docker compose exec app php artisan migrate --seed
```

7. Instalar dependencias frontend y compilar assets
```bash
docker compose exec app npm install
docker compose exec app npm run build
```

8. Acceder a la aplicación en http://localhost

### Sin Docker (Entorno Local)

1. Clonar el repositorio
```bash
git clone https://github.com/yourusername/school-management-system.git
cd school-management-system
```

2. Instalar dependencias PHP
```bash
composer install
```

3. Configurar variables de entorno
```bash
cp .env.example .env
```

4. Configurar la conexión a la base de datos en el archivo .env

5. Generar clave de aplicación
```bash
php artisan key:generate
```

6. Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

7. Instalar dependencias frontend y compilar assets
```bash
npm install
npm run build
```

8. Iniciar servidor de desarrollo
```bash
php artisan serve
```

9. Acceder a la aplicación en http://localhost:8000

## Comandos Útiles

### Con Laravel Sail
```bash
# Iniciar contenedores
sail up -d

# Detener contenedores
sail stop

# Ejecutar tests
sail artisan test

# Iniciar servidor de desarrollo frontend
sail npm run dev

# Generar documentación API
sail artisan l5-swagger:generate

# Limpiar caché
sail artisan optimize:clear

# Reconstruir imágenes (actualización)
sail build --no-cache
```

### Sin Docker
```bash
# Ejecutar tests
php artisan test

# Iniciar servidor de desarrollo frontend
npm run dev

# Generar documentación API
php artisan l5-swagger:generate

# Limpiar caché
php artisan optimize:clear
```

## Estructura de la Base de Datos

### Modelos Principales

1. **Academia (Academy)**
   - id
   - name (nombre)
   - description (descripción)
   - logo (logo) 
   - active (activo)
   - created_at
   - updated_at

2. **Curso (Course)**
   - id
   - academy_id (id de academia)
   - name (nombre)
   - description (descripción)
   - cost (costo)
   - duration (duración)
   - modality (modalidad: in-person, online, hybrid)
   - active (activo)
   - capacity (capacidad)
   - start_date (fecha de inicio)
   - end_date (fecha de fin)
   - created_at
   - updated_at

3. **Estudiante (Student)**
   - id
   - guardian_id (id del tutor)
   - first_name (nombre)
   - last_name (apellido)
   - birth_date (fecha de nacimiento)
   - gender (género: male, female, other)
   - created_at
   - updated_at

4. **Tutor (Guardian)**
   - id
   - user_id (id del usuario)
   - name (nombre)
   - email (correo electrónico)
   - phone (teléfono)
   - created_at
   - updated_at

5. **Matrícula (Enrollment)**
   - id
   - student_id (id del estudiante)
   - course_id (id del curso)
   - enrollment_date (fecha de matrícula)
   - status (estado: pending, confirmed, cancelled)
   - notes (notas)
   - created_at
   - updated_at

6. **Pago (Payment)**
   - id
   - enrollment_id (id de matrícula)
   - amount (monto)
   - method (método de pago: cash, bank_transfer)
   - status (estado: pending, completed, failed, refunded)
   - payment_date (fecha de pago)
   - reference_number (número de referencia)
   - notes (notas)
   - created_at
   - updated_at

7. **Comunicación (Communication)**
   - id
   - course_id (id del curso, opcional)
   - title (título)
   - message (mensaje)
   - age_from (edad desde)
   - age_to (edad hasta)
   - send_date (fecha de envío)
   - status (estado: draft, sent, scheduled)
   - created_at
   - updated_at

## Documentación API

El proyecto incluye documentación completa de la API usando Swagger/OpenAPI. Puede acceder a la documentación en:

- **Interfaz Swagger UI**: `/api/documentation`
- **Formato JSON**: `/docs?api-docs.json`

La documentación proporciona información detallada sobre todos los endpoints disponibles, parámetros de solicitud, formatos de respuesta y requisitos de autenticación.

## Endpoints API

### Academias y Cursos
```
GET /api/v1/academies
GET /api/v1/academies/{id}
GET /api/v1/courses
GET /api/v1/courses/{id}
```

### Matrículas
```
POST /api/v1/enrollments
GET /api/v1/enrollments/{id}
PUT /api/v1/enrollments/{id}
```

### Pagos
```
POST /api/v1/payments
```

### Comunicaciones
```
POST /api/v1/communications
GET /api/v1/communications
GET /api/v1/communications/{id}
POST /api/v1/communications/{communication}/send
```

## Seguridad

- Autenticación API usando Laravel Sanctum 4.0+
- Protección CSRF para rutas web
- Validación de formularios
- Protección XSS
- Prevención de inyección SQL mediante Eloquent ORM

## Pruebas

Ejecutar el conjunto de pruebas:
```bash
./vendor/bin/sail artisan test
```

Ejecutar pruebas automatizadas con Dusk
```bash
./vendor/bin/sail dusk
```