<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Core Application Helper & Dispatcher
 */
class App
{
    /**
     * Get dynamic base path (e.g. '/dental-saas' or '')
     */
    public static function getAppBase(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        if (preg_match('~^/([^/?#]+)~', $uri, $m)) {
            if ($m[1] === 'dental-saas') {
                return '/' . $m[1];
            }
        }
        return '';
    }

    /**
     * Generate an absolute URL prefixed with the app subfolder
     */
    public static function url(string $path = ''): string
    {
        $base = self::getAppBase();
        $p = '/' . ltrim($path, '/');
        if ($p === '/' || $p === '//') {
            return $base !== '' ? $base . '/' : '/';
        }
        return ($base !== '' ? $base : '') . $p;
    }

    /**
     * Generate asset URL
     */
    public static function asset(string $path = ''): string
    {
        return self::url($path);
    }

    /**
     * Initialize secure session
     */
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a flash message
     */
    public static function setFlash(string $key, string $message): void
    {
        self::initSession();
        $_SESSION['flash_' . $key] = $message;
    }

    /**
     * Get and clear a flash message
     */
    public static function getFlash(string $key): ?string
    {
        self::initSession();
        $fullKey = 'flash_' . $key;
        if (isset($_SESSION[$fullKey])) {
            $msg = $_SESSION[$fullKey];
            unset($_SESSION[$fullKey]);
            return $msg;
        }
        return null;
    }

    /**
     * Redirect to an internal route
     */
    public static function redirect(string $path, array $flash = []): void
    {
        foreach ($flash as $k => $v) {
            self::setFlash($k, $v);
        }
        header('Location: ' . self::url($path));
        exit;
    }

    /**
     * Send JSON response with CORS headers
     */
    public static function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, X-Requested-With');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Render a PHP view template
     */
    public static function render(string $viewPath, array $data = [], bool $useLayout = true): void
    {
        self::initSession();
        $viewsDir = dirname(__DIR__, 2) . '/resources/views';
        $fullViewPath = $viewsDir . '/' . ltrim($viewPath, '/') . '.php';

        if (!file_exists($fullViewPath)) {
            http_response_code(404);
            echo "<h1>View not found: " . htmlspecialchars($viewPath) . "</h1>";
            exit;
        }

        // Extract variables for view
        extract($data);

        // Flash messages
        $flashSuccess = self::getFlash('success');
        $flashError = self::getFlash('error');
        $authUser = Auth::user();

        if ($useLayout) {
            ob_start();
            include $fullViewPath;
            $content = ob_get_clean();

            $layoutFile = $viewsDir . '/layouts/admin.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
            } else {
                echo $content;
            }
        } else {
            include $fullViewPath;
        }
        exit;
    }
}
