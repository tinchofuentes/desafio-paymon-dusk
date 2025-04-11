<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAPI Documentation Classes
    |--------------------------------------------------------------------------
    |
    | This array contains all the documentation classes that provide OpenAPI
    | annotations for the application. These classes will be registered by
    | the OpenApiServiceProvider and can be used to generate Swagger documentation.
    |
    */
    'documentation_classes' => [],

    /*
    |--------------------------------------------------------------------------
    | Auto Discovery
    |--------------------------------------------------------------------------
    |
    | If enabled, the system will automatically discover and register
    | documentation classes that implement the ApiDocumentation interface.
    |
    */
    'auto_discover' => true,

    /*
    |--------------------------------------------------------------------------
    | Documentation Directories
    |--------------------------------------------------------------------------
    |
    | Directories to scan for ApiDocumentation classes if auto_discover is enabled.
    |
    */
    'documentation_directories' => [
        app_path('OpenApi/Controllers'),
        app_path('OpenApi/Schemas'),
        app_path('OpenApi/Components'),
        app_path('OpenApi/Responses'),
    ],
]; 