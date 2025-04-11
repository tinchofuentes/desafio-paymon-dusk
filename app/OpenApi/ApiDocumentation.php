<?php

namespace App\OpenApi;

/**
 * Interface for API Documentation classes
 * This interface standardizes how we define OpenAPI documentation for our API endpoints
 */
interface ApiDocumentation
{
    /**
     * Get the OpenAPI annotations for the controller or specific endpoint
     * 
     * @return array An array of OpenAPI annotation strings
     */
    public static function getAnnotations(): array;
} 