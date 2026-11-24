<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ThemeService;
use App\Services\BookingService;

class DashboardController
{
    public function index(): void
    {
        Auth::requireAuth();

        $theme = ThemeService::getTheme();
        $kpi = BookingService::getDashboardKpiStats();
        $patientStats = BookingService::getPatientStats();
        $leavesSummary = BookingService::getUpcomingDoctorLeavesSummary();
        $upcomingAppointments = BookingService::getUpcomingAppointments(8);

        App::render('admin/dashboard/index', [
            'theme' => $theme,
            'kpi' => $kpi,
            'patientStats' => $patientStats,
            'leavesSummary' => $leavesSummary,
            'upcomingAppointments' => $upcomingAppointments,
            'pageTitle' => 'Clinical Operations & Practice Dashboard',
            'activeNav' => 'dashboard',
        ]);
    }
}
