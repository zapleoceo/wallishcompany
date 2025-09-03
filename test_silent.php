<?php
// Suppress all output
ob_start();

// Load index.php
include 'index.php';

// Get output length
$output_length = ob_get_length();
ob_end_clean();

echo "Output length: " . $output_length . "\n";
echo "Test completed!\n";
?>
