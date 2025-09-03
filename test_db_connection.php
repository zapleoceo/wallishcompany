<?php
echo "Testing database connection...\n";

// Load config
require_once 'config.php';

echo "DB_HOSTNAME: " . DB_HOSTNAME . "\n";
echo "DB_USERNAME: " . DB_USERNAME . "\n";
echo "DB_DATABASE: " . DB_DATABASE . "\n";

// Test connection
try {
    $mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
    
    if ($mysqli->connect_error) {
        echo "Connection failed: " . $mysqli->connect_error . "\n";
    } else {
        echo "Database connection successful!\n";
        
        // Test query
        $result = $mysqli->query("SELECT COUNT(*) as count FROM " . DB_PREFIX . "setting");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Settings table count: " . $row['count'] . "\n";
        } else {
            echo "Query failed: " . $mysqli->error . "\n";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

echo "Test completed!\n";
?>
