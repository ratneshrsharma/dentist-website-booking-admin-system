<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

/**
 * Advanced Dental Clinic - Standalone Production Fallback Runner
 * Serves AdminLTE 4 Management Portal & REST APIs when Composer vendor is absent on shared hosting
 */
class StandaloneRunner
{
    private static ?PDO $pdo = null;
    private static array $env = [];

    public static function run(): void
    {
        self::loadEnv();
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        // Strip subfolder prefix if present (e.g. /advanced-dental-clinic)
        $uri = preg_replace('#^/advanced-dental-clinic#', '', $uri);
        $uri = '/' . ltrim($uri, '/');

        // 1. API Endpoints
        if (str_starts_with($uri, '/api/')) {
            self::handleApi($uri);
            return;
        }

        // 2. Admin Portal Endpoints
        if (str_starts_with($uri, '/admin')) {
            self::handleAdmin($uri);
            return;
        }

        // Default redirect to admin dashboard
        header('Location: /advanced-dental-clinic/admin/dashboard');
        exit;
    }

    private static function loadEnv(): void
    {
        $envFile = dirname(__DIR__) . '/.env';
        if (!file_exists($envFile)) {
            $envFile = dirname(__DIR__) . '/.env.example';
        }
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }
                if (str_contains($line, '=')) {
                    [$k, $v] = explode('=', $line, 2);
                    self::$env[trim($k)] = trim(trim($v), '"\'');
                }
            }
        }
    }

    private static function getPdo(): ?PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        $host = self::$env['DB_HOST'] ?? '127.0.0.1';
        $port = self::$env['DB_PORT'] ?? '3306';
        $db   = self::$env['DB_DATABASE'] ?? 'u499464314_advanceddental';
        $user = self::$env['DB_USERNAME'] ?? 'u499464314_dental_user';
        $pass = self::$env['DB_PASSWORD'] ?? '';

        try {
            self::$pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return self::$pdo;
        } catch (PDOException $e) {
            return null;
        }
    }

    private static function handleApi(string $uri): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        if ($uri === '/api/v1/ping' || $uri === '/api/ping') {
            echo json_encode([
                'success' => true,
                'status'  => 'online',
                'service' => 'Advanced Dental Clinic Headless API',
                'timestamp' => date('c'),
                'database' => self::getPdo() !== null ? 'connected' : 'disconnected (check .env DB_PASSWORD)',
            ]);
            exit;
        }

        if ($uri === '/api/v1/theme/settings') {
            $pdo = self::getPdo();
            if ($pdo) {
                $stmt = $pdo->query("SELECT `key`, `value` FROM theme_settings");
                $rows = $stmt->fetchAll();
                $data = [];
                foreach ($rows as $row) {
                    $val = json_decode($row['value'], true);
                    $data[$row['key']] = $val !== null ? $val : $row['value'];
                }
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => true, 'data' => [
                    'primary' => ['hex' => '#0D9488', 'label' => 'Clinical Teal'],
                    'secondary' => ['hex' => '#14B8A6', 'label' => 'Mint Accent'],
                    'accent' => ['hex' => '#0284C7', 'label' => 'Sky Clinical'],
                    'surface' => ['hex' => '#FFFFFF', 'label' => 'Pure Surface'],
                ]]);
            }
            exit;
        }

        if ($uri === '/api/v1/cms/treatments') {
            $pdo = self::getPdo();
            if ($pdo) {
                $stmt = $pdo->query("SELECT id, title, title AS name, slug, category, overview, overview AS short_description, cost_estimate, cost_estimate AS starting_price, duration, duration AS duration_minutes, recovery_time, hero_image FROM cms_treatments WHERE is_published = 1 ORDER BY sort_order ASC");
                $data = $stmt->fetchAll();
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => true, 'data' => []]);
            }
            exit;
        }

        if ($uri === '/api/v1/cms/navigation') {
            $pdo = self::getPdo();
            if ($pdo) {
                $stmt = $pdo->query("SELECT id, title, slug, category, overview AS description, hero_image FROM cms_treatments WHERE is_published = 1 ORDER BY sort_order ASC");
                $treatments = $stmt->fetchAll();
                $categories = [];
                foreach ($treatments as $t) {
                    $cat = $t['category'];
                    if (!isset($categories[$cat])) {
                        $categories[$cat] = [];
                    }
                    $categories[$cat][] = $t;
                }
                echo json_encode(['success' => true, 'data' => ['categories' => $categories]]);
            } else {
                echo json_encode(['success' => true, 'data' => ['categories' => []]]);
            }
            exit;
        }

        if (str_starts_with($uri, '/api/v1/seo/metadata')) {
            $slug = trim(str_replace('/api/v1/seo/metadata', '', $uri), '/');
            $slug = $slug === '' ? 'home' : $slug;
            $pdo = self::getPdo();
            if ($pdo) {
                $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE entity_slug = :slug LIMIT 1");
                $stmt->execute(['slug' => $slug]);
                $meta = $stmt->fetch();
                if (!$meta) {
                    $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE entity_slug = 'home' LIMIT 1");
                    $stmt->execute();
                    $meta = $stmt->fetch();
                }
                echo json_encode(['success' => true, 'data' => $meta]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database offline']);
            }
            exit;
        }

        if ($uri === '/api/v1/seo/redirects') {
            $pdo = self::getPdo();
            if ($pdo) {
                $stmt = $pdo->query("SELECT source_url, target_url, status_code FROM seo_redirects WHERE is_active = 1");
                $redirects = $stmt->fetchAll();
                echo json_encode(['success' => true, 'data' => $redirects]);
            } else {
                echo json_encode(['success' => true, 'data' => []]);
            }
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Endpoint not found', 'path' => $uri]);
        exit;
    }

    private static function handleAdmin(string $uri): void
    {
        $action = trim(preg_replace('#^/admin/?#', '', $uri), '/');
        if ($action === '' || $action === 'dashboard') {
            self::renderView('dashboard');
            return;
        }

        if ($action === 'theme-customizer') {
            self::renderView('theme-customizer');
            return;
        }

        if ($action === 'seo-manager') {
            self::renderView('seo-manager');
            return;
        }

        if ($action === 'seo-redirects') {
            self::renderView('seo-redirects');
            return;
        }

        if ($action === 'appointments/calendar') {
            self::renderView('calendar');
            return;
        }

        if ($action === 'emr/odontogram') {
            self::renderView('odontogram');
            return;
        }

        self::renderView('dashboard');
    }

    private static function renderView(string $viewName): void
    {
        $viewsDir = dirname(__DIR__) . '/resources/views';
        $layoutFile = $viewsDir . '/layouts/admin.blade.php';

        $layoutHtml = file_exists($layoutFile) ? file_get_contents($layoutFile) : '';

        // Determine view file
        $viewFile = match ($viewName) {
            'dashboard' => $viewsDir . '/admin/dashboard.blade.php',
            'theme-customizer' => $viewsDir . '/admin/theme/customizer.blade.php',
            'seo-manager' => $viewsDir . '/admin/seo/index.blade.php',
            'seo-redirects' => $viewsDir . '/admin/seo/redirects.blade.php',
            'calendar' => $viewsDir . '/admin/appointments/calendar.blade.php',
            'odontogram' => $viewsDir . '/admin/emr/odontogram.blade.php',
            default => $viewsDir . '/admin/dashboard.blade.php',
        };

        $contentHtml = file_exists($viewFile) ? file_get_contents($viewFile) : '<h2>View not found</h2>';

        // Extract sections from child view
        $sections = [];
        preg_match_all("/@section\('([^']+)',\s*'([^']*)'\)/", $contentHtml, $inlineSections, PREG_SET_ORDER);
        foreach ($inlineSections as $sec) {
            $sections[$sec[1]] = $sec[2];
        }

        preg_match_all("/@section\('([^']+)'\)(.*?)@endsection/s", $contentHtml, $blockSections, PREG_SET_ORDER);
        foreach ($blockSections as $sec) {
            $sections[$sec[1]] = trim($sec[2]);
        }

        // Render layout
        $rendered = $layoutHtml;

        // Replace @yield directives
        $rendered = preg_replace_callback("/@yield\('([^']+)',?\s*'?(.*?)'?\)/", function ($matches) use ($sections) {
            $key = $matches[1];
            $default = $matches[2] ?? '';
            return $sections[$key] ?? $default;
        }, $rendered);

        // Replace Blade helpers and URLs
        $rendered = str_replace([
            '{{ url(\'/admin/appointments/calendar\') }}',
            '{{ url(\'/admin/emr/odontogram\') }}',
            '{{ url(\'/admin/theme-customizer\') }}',
            '{{ url(\'/admin/seo-manager\') }}',
            '{{ url(\'/admin/seo-redirects\') }}',
            '{{ url(\'/admin/dashboard\') }}',
            '{{ url(\'/\') }}',
        ], [
            '/advanced-dental-clinic/admin/appointments/calendar',
            '/advanced-dental-clinic/admin/emr/odontogram',
            '/advanced-dental-clinic/admin/theme-customizer',
            '/advanced-dental-clinic/admin/seo-manager',
            '/advanced-dental-clinic/admin/seo-redirects',
            '/advanced-dental-clinic/admin/dashboard',
            '/advanced-dental-clinic/',
        ], $rendered);

        // Extract push blocks from child view (e.g. @push('styles') ... @endpush)
        $stacks = [];
        preg_match_all("/@push\('([^']+)'\)(.*?)@endpush/s", $contentHtml, $pushBlocks, PREG_SET_ORDER);
        foreach ($pushBlocks as $push) {
            $stacks[$push[1]] = ($stacks[$push[1]] ?? '') . "\n" . trim($push[2]);
        }

        // Replace @stack directives with pushed content
        $rendered = preg_replace_callback("/@stack\('([^']+)'\)/", function ($matches) use ($stacks) {
            return $stacks[$matches[1]] ?? '';
        }, $rendered);

        // Render rich mock audit data for SEO and Redirects in standalone mode
        $sampleSeoAudit = '<div class="list-group-item p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-dark">/ (Home Page)</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Configured</span>
            </div>
            <div class="text-truncate text-secondary mb-1" style="max-width: 280px;">Pain-Free Restorations. Confident Smiles for Life.</div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-muted border">Dentist</span>
                <span class="badge bg-info-subtle text-info border">Scripts</span>
            </div>
        </div>
        <div class="list-group-item p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-dark">/treatments/dental-implants</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Configured</span>
            </div>
            <div class="text-truncate text-secondary mb-1" style="max-width: 280px;">Dental Implants Overview | Advanced Dental Clinic</div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-muted border">MedicalProcedure</span>
            </div>
        </div>
        <div class="list-group-item p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-dark">/contact</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Configured</span>
            </div>
            <div class="text-truncate text-secondary mb-1" style="max-width: 280px;">Contact & Practice Locations | Advanced Dental Clinic</div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-muted border">MedicalBusiness</span>
            </div>
        </div>';

        $sampleRedirects = '<tr>
            <td class="ps-3 font-monospace text-danger fw-bold">/services/dental-implants</td>
            <td class="font-monospace text-success fw-bold">/treatments/dental-implants</td>
            <td><span class="badge bg-success-subtle text-success border border-success-subtle">301 Permanent</span></td>
            <td><span class="badge bg-light text-dark border">420</span></td>
            <td class="text-muted">Nov 01, 2026</td>
            <td class="text-end pe-3">
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" title="Delete Rule"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
        <tr>
            <td class="ps-3 font-monospace text-danger fw-bold">/booking-online</td>
            <td class="font-monospace text-success fw-bold">/book-appointment</td>
            <td><span class="badge bg-success-subtle text-success border border-success-subtle">301 Permanent</span></td>
            <td><span class="badge bg-light text-dark border">184</span></td>
            <td class="text-muted">Nov 02, 2026</td>
            <td class="text-end pe-3">
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" title="Delete Rule"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
        <tr>
            <td class="ps-3 font-monospace text-danger fw-bold">/contact-us.html</td>
            <td class="font-monospace text-success fw-bold">/contact</td>
            <td><span class="badge bg-success-subtle text-success border border-success-subtle">301 Permanent</span></td>
            <td><span class="badge bg-light text-dark border">92</span></td>
            <td class="text-muted">Nov 03, 2026</td>
            <td class="text-end pe-3">
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" title="Delete Rule"><i class="bi bi-trash"></i></button>
            </td>
        </tr>';

        $rendered = preg_replace("/@forelse\(\\\$seoList as \\\$seo\).*?@endforelse/s", $sampleSeoAudit, $rendered);
        $rendered = preg_replace("/@forelse\(\\\$redirects as \\\$rule\).*?@endforelse/s", $sampleRedirects, $rendered);

        // Strip session alert blocks if no active session flash
        $rendered = preg_replace("/@if\(session\('success'\)\).*?@endif/s", '', $rendered);
        $rendered = preg_replace("/@if\(session\('error'\)\).*?@endif/s", '', $rendered);
        $rendered = preg_replace("/@if\(session\('status'\)\).*?@endif/s", '', $rendered);

        // Strip remaining Blade directives safely
        $rendered = preg_replace('/@stack\([^\)]+\)/', '', $rendered);
        $rendered = preg_replace('/@push\([^\)]+\)/', '', $rendered);
        $rendered = preg_replace('/@endpush/', '', $rendered);
        $rendered = preg_replace('/@extends\([^\)]+\)/', '', $rendered);
        $rendered = preg_replace('/\{\{.*?\}\}/', '', $rendered);
        $rendered = preg_replace('/@csrf/', '', $rendered);
        $rendered = preg_replace('/@method\([^\)]+\)/', '', $rendered);
        $rendered = preg_replace('/@if\((?:[^)(]+|\((?:[^)(]+|\([^)(]*\))*\))*\)/', '', $rendered);
        $rendered = preg_replace('/@endif/', '', $rendered);
        $rendered = preg_replace('/@foreach\(.*?\)/', '', $rendered);
        $rendered = preg_replace('/@endforeach/', '', $rendered);
        $rendered = preg_replace('/@forelse\(.*?\)/', '', $rendered);
        $rendered = preg_replace('/@empty/', '', $rendered);
        $rendered = preg_replace('/@endforelse/', '', $rendered);

        header('Content-Type: text/html; charset=utf-8');
        echo $rendered;
        exit;
    }
}
