<?php

/**
 * Autoloader Class
 * 
 * This class provides a simple autoloader mechanism for loading PHP class files.
 * It registers the 'autoload' method as a spl_autoload function, allowing classes
 * to be automatically loaded when they are used.
 */

class Autoloader {
    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($className) {
        // Directories to search for class files
        $directories = [
            __DIR__ . '/controllers/',
            __DIR__ . '/middlewares/'
        ];

        // Iterate through directories
        foreach ($directories as $directory) {
            // Convert class name to file path
            $filePath = $directory . $className . '.php';

            // Check if the file exists
            if (file_exists($filePath)) {
                // Include the file
                require_once $filePath;
                return;
            }
        }

        // Handle autoload failure (e.g., throw an exception)
        throw new Exception("Class '$className' not found");
    }
}

// Register the autoloader
Autoloader::register();
