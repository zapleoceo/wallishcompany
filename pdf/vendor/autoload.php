<?php
// Simple autoloader for mPDF
spl_autoload_register(function ($class) {
    // mPDF namespace
    if (strpos($class, 'Mpdf') === 0) {
        $class = str_replace('Mpdf', '', $class);
        $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Load main mPDF class if it exists
$mpdf_file = __DIR__ . '/../src/Mpdf.php';
if (file_exists($mpdf_file)) {
    require_once $mpdf_file;
}
?>
