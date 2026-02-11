<?php

/**
 * Database Configuration
 * 
 * Configuration settings for database connection
 */

return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',        // Host database, default localhost
    'dbname' => $_ENV['DB_NAME'] ?? 'db_pengajuan',   // Nama database, default db_pengajuan
    'username' => $_ENV['DB_USERNAME'] ?? 'root',     // Username database, default root
    'password' => $_ENV['DB_PASSWORD'] ?? '',         // Password database, default kosong
    'charset' => 'utf8mb4',                           // Character set untuk support emoji dan unicode
    'options' => [                                    // Options untuk PDO connection
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,           // Set error mode ke exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Default fetch mode ke associative array
        PDO::ATTR_EMULATE_PREPARES => false,                   // Disable emulated prepared statements
    ]
];