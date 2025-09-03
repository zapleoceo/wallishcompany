<?php
echo "Testing index.php loading...\n";

// Capture output
ob_start();
include 'index.php';
$output = ob_get_clean();

echo "Output length: " . strlen($output) . "\n";
echo "First 500 characters:\n";
echo substr($output, 0, 500) . "\n";

echo "Test completed!\n";
?>
