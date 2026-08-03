<?php
/**
 * Hostinger Shared Hosting - Public Entry Point
 *
 * Is file ko public_html/ root mein rakhna hai.
 * Ye Laravel ke actual public/index.php ko point karta hai.
 *
 * Folder structure on server:
 *   /home/u123456789/         (account root)
 *   /home/u123456789/pathoflix/     ← Laravel project yahan
 *   /home/u123456789/public_html/   ← Ye file yahan
 */

define('LARAVEL_START', microtime(true));

// Laravel project ka path (ek level upar + pathoflix folder)
// Agar project directly account root mein hai toh: __DIR__ . '/../pathoflix/public/index.php'
require __DIR__ . '/../pathoflix/public/index.php';
