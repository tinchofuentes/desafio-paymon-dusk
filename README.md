# Sistema de Gestión Escolar

## Acerca del Proyecto

Una aplicación web construida con Laravel y Livewire para gestionar comunicaciones escolares y procesos de matrícula. Este sistema permite a las escuelas mostrar su oferta académica, gestionar inscripciones de estudiantes y mantener una comunicación efectiva con los padres.

## Características

- **Gestión de Oferta Académica**
  - Visualización de academias y cursos disponibles
  - Detalles de cursos incluyendo costo, duración y modalidad
  - Catálogo de cursos interactivo

- **Sistema de Matrícula**
  - Formularios de inscripción interactivos usando Livewire
  - Registro de estudiantes
  - Selección de cursos
  - Procesamiento de pagos (efectivo/transferencia bancaria)

- **Sistema de Comunicación**
  - Comunicaciones dirigidas a padres
  - Filtrado por curso o edad del estudiante
  - Seguimiento del historial de comunicaciones

- **Procesamiento de Pagos**
  - Soporte para múltiples métodos de pago
  - Seguimiento y gestión de pagos
  - Historial de transacciones

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
git clone https://github.com/yourusername/school-management-system.git
cd school-management-system
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

4. Ejecutar la instalación de Sail
```bash
php artisan sail:install
```

5. Iniciar los contenedores de Sail
```bash
./vendor/bin/sail up
```

Para iniciar en modo desacoplado (background):
```bash
./vendor/bin/sail up -d
```

6. Generar clave de aplicación
```bash
./vendor/bin/sail artisan key:generate
```

7. Ejecutar migraciones y seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

8. Instalar dependencias frontend y compilar assets
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

9. Acceder a la aplicación en http://localhost

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
   - modality (modalidad)
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
   - status (estado)
   - created_at
   - updated_at

6. **Pago (Payment)**
   - id
   - enrollment_id (id de matrícula)
   - amount (monto)
   - payment_method (método de pago)
   - status (estado)
   - created_at
   - updated_at

7. **Comunicación (Communication)**
   - id
   - title (título)
   - message (mensaje)
   - target_type (tipo de destinatario)
   - target_criteria (criterio de destinatario)
   - sent_at (fecha de envío)
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
GET /api/v1/payments/{id}
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