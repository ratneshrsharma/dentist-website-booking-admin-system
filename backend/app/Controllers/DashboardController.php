<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ThemeService;
use App\Services\CmsService;

class DashboardController
{
    public function index(): void
    {
        Auth::requireAuth();

        $theme = ThemeService::getTheme();
        $pages = CmsService::getPages();
        $homeData = CmsService::getHomePageData();

        App::render('admin/dashboard/index', [
            'theme' => $theme,
            'pages' => $pages,
            'homeData' => $homeData,
            'pageTitle' => 'Practice Management Dashboard',
            'activeNav' => 'dashboard',
        ]);
    }
}
