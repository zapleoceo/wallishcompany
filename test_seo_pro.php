<?php
echo "<h1>SEO Pro Module Test</h1>";

// Load main config
require_once('config.php');
require_once(DIR_SYSTEM . 'startup.php');

// Create Registry
$registry = new Registry();
$loader = new Loader($registry);
$config = new Config();
$registry->set('config', $config);

// Create DB
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

echo "<p>✓ Basic setup completed</p>";

// Check SEO Pro module
echo "<h2>Checking SEO Pro Module</h2>";

$seo_pro_path = DIR_APPLICATION . 'controller/common/seo_pro.php';
if (file_exists($seo_pro_path)) {
    echo "<p>✓ SEO Pro module exists</p>";
    
    // Check file content around problematic lines
    $lines = file($seo_pro_path);
    
    // Check line 246 (host index)
    if (isset($lines[245])) {
        echo "<p>Line 246: " . htmlspecialchars(trim($lines[245])) . "</p>";
    }
    
    // Check line 314 (host index)
    if (isset($lines[313])) {
        echo "<p>Line 314: " . htmlspecialchars(trim($lines[313])) . "</p>";
    }
    
    // Check line 436 (strpos issue)
    if (isset($lines[435])) {
        echo "<p>Line 436: " . htmlspecialchars(trim($lines[435])) . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ SEO Pro module not found</p>";
}

// Check $_SERVER variables
echo "<h2>Server Variables</h2>";
echo "<p>HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'NOT SET') . "</p>";
echo "<p>SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'NOT SET') . "</p>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "</p>";

echo "<h2>Test Completed</h2>";
?>
