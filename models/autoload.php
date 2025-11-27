<?php
// autoload.php

spl_autoload_register(function ($class) {
    // Répertoires racine à scanner
    $baseDirectories = [
        __DIR__ . '/../models',
        __DIR__ . '/../controllers',
        __DIR__ . '/../views'
    ];

    // Fonction récursive pour scanner les dossiers
    $findClass = function ($dir, $className) use (&$findClass) {
        if (!is_dir($dir)) {
            return null;
        }

        $files = scandir($dir);
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $dir . DIRECTORY_SEPARATOR . $file;

            // Si c'est un fichier PHP, vérifie si c'est la classe cherchée
            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                if (basename($filePath, '.php') === $className) {
                    require_once $filePath;
                    return $filePath;
                }
            }

            // Si c'est un dossier, le scanner récursivement
            if (is_dir($filePath)) {
                $result = $findClass($filePath, $className);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    };

    // Cherche la classe dans tous les répertoires
    foreach ($baseDirectories as $baseDir) {
        if ($findClass($baseDir, $class) !== null) {
            return;
        }
    }

    // Log si classe non trouvée (debug)
    if (defined('DEBUG') && DEBUG) {
        error_log("Classe non trouvée : $class");
    }
}, true, true);
