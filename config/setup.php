<?php

/**
 * Database Setup Script
 * 
 * This script initializes the database schema and sample data
 */

require_once __DIR__ . '/../models/Database.php';

function setupDatabase(): bool {
    try {
        // Read configuration
        $config = require __DIR__ . '/database.php';
        
        // Connect to MySQL server (without specific database)
        $dsn = "mysql:host={$config['host']};charset={$config['charset']}";
        $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        
        // Read and execute schema
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        if ($schema === false) {
            throw new Exception("Could not read schema.sql file");
        }
        
        // Execute schema statements
        $statements = explode(';', $schema);
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
        
        // Read and execute sample data
        $sampleData = file_get_contents(__DIR__ . '/sample_data.sql');
        if ($sampleData === false) {
            throw new Exception("Could not read sample_data.sql file");
        }
        
        // Execute sample data statements
        $statements = explode(';', $sampleData);
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
        
        echo "Database setup completed successfully!\n";
        return true;
        
    } catch (Exception $e) {
        echo "Database setup failed: " . $e->getMessage() . "\n";
        return false;
    }
}

// Run setup if called directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    setupDatabase();
}