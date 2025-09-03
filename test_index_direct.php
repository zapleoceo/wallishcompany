<?php
echo "<h1>Direct Index.php Test</h1>";

// Set error handler to catch all errors
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<p style='color: orange;'>⚠ Notice: $errstr in $errfile on line $errline</p>";
    return true;
});

// Set exception handler
set_exception_handler(function($e) {
    echo "<p style='color: red;'>✗ Fatal Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
});

// Try to load index.php
echo "<h2>Loading index.php directly</h2>";
try {
    ob_start();
    include 'index.php';
    $output = ob_get_clean();
    
    echo "<p style='color: green;'>✓ index.php loaded successfully</p>";
    echo "<p>Output length: " . strlen($output) . " characters</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Exception: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
