<?php

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// 1. If Composer vendor autoload exists, boot standard Laravel 11
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';

    // Bootstrap Laravel and handle the request...
    (require_once __DIR__.'/../bootstrap/app.php')
        ->handleRequest(\Illuminate\Http\Request::capture());
    exit;
}

// 2. High-Performance Standalone Runner Fallback (Zero-Dependency Shared Hosting Mode)
require_once __DIR__.'/../app/StandaloneRunner.php';
\App\StandaloneRunner::run();

