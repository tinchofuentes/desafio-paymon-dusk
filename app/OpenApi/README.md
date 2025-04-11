# OpenAPI Documentation

Este directorio contiene la documentación OpenAPI para la API del sistema, implementada utilizando el enfoque de separación de responsabilidades.

## Estructura

La documentación OpenAPI está organizada de la siguiente manera:

- `ApiDocumentation.php`: Interfaz base que todos los documentos de API deben implementar.
- `Controllers/`: Clases de documentación específicas para controladores.
- `Schemas/`: Esquemas de datos para modelos.
- `Components/`: Componentes reutilizables de OpenAPI.
- `Responses/`: Respuestas comunes reutilizables.
- `Parameters/`: Parámetros comunes reutilizables.

## Enfoque

En lugar de incluir todas las anotaciones de OpenAPI en los controladores, hemos separado la documentación en clases dedicadas. Esto proporciona varias ventajas:

1. **Controladores más limpios**: Los controladores se centran solo en la lógica de negocio.
2. **Mejor organización**: La documentación de API está agrupada por contexto.
3. **Mantenibilidad**: Facilita la actualización de la documentación sin modificar los controladores.
4. **Reutilización**: Permite reutilizar componentes comunes entre diferentes endpoints.

## Uso

### Crear una nueva clase de documentación

Para documentar un nuevo controlador:

1. Crea una nueva clase en `Controllers/` que implemente `ApiDocumentation`.
2. Define métodos para cada endpoint con las anotaciones OpenAPI necesarias.
3. Añade la clase al array `$documentationClasses` en `OpenApiServiceProvider`.

Ejemplo:

```php
<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="MiRecurso",
 *     description="API Endpoints para mi recurso"
 * )
 */
class MiRecursoControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for this controller
     */
    public static function getAnnotations(): array
    {
        return [
            self::indexEndpoint(),
            self::storeEndpoint(),
            // ...
        ];
    }

    /**
     * @OA\Get(
     *     path="/mi-recurso",
     *     // ...anotaciones OpenAPI
     * )
     */
    public static function indexEndpoint(): string
    {
        return "";
    }

    // Más métodos para otros endpoints
}
```

### Referencia en el controlador

En el controlador, solo se necesita una referencia a la clase de documentación:

```php
/**
 * @see MiRecursoControllerDoc for API documentation
 */
class MiRecursoController extends Controller
{
    // Métodos del controlador sin anotaciones OpenAPI
}
```

### Generar documentación

Ejecuta el comando para generar la documentación:

```bash
php artisan openapi:generate
```

## Visualización

La documentación generada está disponible en:

- JSON: `/api/documentation`
- UI: `/api/documentation` 