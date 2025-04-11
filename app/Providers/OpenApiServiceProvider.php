<?php

namespace App\Providers;

use App\OpenApi\ApiDocumentation;
use App\OpenApi\Controllers\EnrollmentControllerDoc;
use App\OpenApi\Controllers\CourseControllerDoc;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;

class OpenApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/openapi.php', 'openapi'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/openapi.php' => config_path('openapi.php'),
        ], 'openapi-config');

        // Register OpenAPI documentation classes
        $this->registerOpenApiDocumentation();
    }

    /**
     * Register all OpenAPI documentation classes
     */
    private function registerOpenApiDocumentation(): void
    {
        // This array will contain all documentation classes
        $documentationClasses = [
            EnrollmentControllerDoc::class,
            CourseControllerDoc::class,
            // Add more documentation classes as needed
        ];

        // If auto-discovery is enabled, scan directories for documentation classes
        if (config('openapi.auto_discover', true)) {
            $discoveredClasses = $this->discoverDocumentationClasses();
            $documentationClasses = array_merge($documentationClasses, $discoveredClasses);
        }

        // Merge with manually configured classes
        $configuredClasses = config('openapi.documentation_classes', []);
        $documentationClasses = array_merge($documentationClasses, $configuredClasses);

        // Remove duplicates and ensure all classes are valid
        $documentationClasses = array_unique($documentationClasses);
        $documentationClasses = array_filter($documentationClasses, function ($class) {
            return class_exists($class) && $this->implementsApiDocumentation($class);
        });

        // Store documentation classes for use in Swagger configuration
        config(['openapi.documentation_classes' => $documentationClasses]);
    }

    /**
     * Discover documentation classes in the configured directories
     *
     * @return array
     */
    private function discoverDocumentationClasses(): array
    {
        $discoveredClasses = [];
        $directories = config('openapi.documentation_directories', []);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                continue;
            }

            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $class = $this->getClassFromFile($file->getPathname());
                if ($class && $this->implementsApiDocumentation($class)) {
                    $discoveredClasses[] = $class;
                }
            }
        }

        return $discoveredClasses;
    }

    /**
     * Get the fully qualified class name from a file path
     *
     * @param string $filepath
     * @return string|null
     */
    private function getClassFromFile(string $filepath): ?string
    {
        // Read the file content
        $content = file_get_contents($filepath);
        
        // Extract namespace
        $namespace = null;
        if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
            $namespace = $matches[1];
        }
        
        // Extract class name
        $className = null;
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
        }
        
        if ($namespace && $className) {
            return $namespace . '\\' . $className;
        }
        
        return null;
    }

    /**
     * Check if a class implements the ApiDocumentation interface
     *
     * @param string $class
     * @return bool
     */
    private function implementsApiDocumentation(string $class): bool
    {
        if (!class_exists($class)) {
            return false;
        }

        return in_array(
            ApiDocumentation::class,
            class_implements($class) ?: []
        );
    }
} 