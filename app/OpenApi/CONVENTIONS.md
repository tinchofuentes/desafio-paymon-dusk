# Convenciones de documentación de API

Este archivo describe las convenciones a seguir para la documentación de la API utilizando OpenAPI.

## Estructura

En este proyecto, la documentación de API sigue un enfoque de separación de responsabilidades:

1. **Controladores API**: Se mantienen limpios sin anotaciones de OpenAPI
2. **Clases de documentación**: Contienen todas las anotaciones OpenAPI relacionadas

## Cómo documentar un nuevo controlador

1. Crea un nuevo controlador en `app/Http/Controllers/Api/`.
2. Referencia la documentación en el controlador:

```php
/**
 * @see NombreControllerDoc for API documentation
 */
class NombreController extends Controller
{
    // Métodos del controlador sin anotaciones OpenAPI
}
```

3. Crea la clase de documentación en `app/OpenApi/Controllers/`:

```php
<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="NombreRecurso",
 *     description="API Endpoints de gestión de..."
 * )
 */
class NombreControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for this controller
     */
    public static function getAnnotations(): array
    {
        return [
            self::indexEndpoint(),
            self::storeEndpoint(),
            // Otros métodos...
        ];
    }

    /**
     * @OA\Get(
     *     path="/recursos",
     *     operationId="getRecursosList",
     *     tags={"NombreRecurso"},
     *     summary="Obtener listado de recursos",
     *     // Resto de anotaciones OpenAPI...
     * )
     */
    public static function indexEndpoint(): string
    {
        return "";
    }

    // Otros métodos para cada endpoint...
}
```

## Recomendaciones

- Mantén los controladores limpios de anotaciones OpenAPI
- Cada método de documentación debe devolver un string vacío
- Organiza los endpoints siguiendo el patrón RESTful (index, store, show, update, destroy)
- Utiliza nombres consistentes para los endpoints
- Documenta todos los parámetros, respuestas y códigos de estado
- Agrega ejemplos siempre que sea posible
- Utiliza referencias a esquemas para evitar duplicación
- Especifica todos los tipos de datos y formatos correctamente

## Generación de documentación

La documentación se genera automáticamente utilizando las anotaciones OpenAPI.
Para ver la documentación, visita `/api/documentation` (interfaz Swagger UI)
o `/api/documentation.json` (archivo JSON). 