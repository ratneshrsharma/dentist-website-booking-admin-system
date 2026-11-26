<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\PatientService;
use App\Services\ServicesService;
use App\Services\BookingService;
use App\Services\ActivityLogService;

class PatientsController
{
    public function index(): void
    {
        Auth::requirePermission('patients');
        $search = strtolower(trim((string) ($_GET['q'] ?? '')));
        $patients = PatientService::getAllPatientsEnriched();

        if ($search !== '') {
            $patients = array_values(array_filter($patients, static function ($p) use ($search) {
                $hay = strtolower(($p['name'] ?? '') . ' ' . ($p['phone'] ?? '') . ' ' . ($p['email'] ?? '') . ' ' . ($p['patient_key'] ?? ''));
                return str_contains($hay, $search);
            }));
        }

        App::render('admin/patients/index', [
            'pageTitle' => 'Patients Management',
            'activeNav' => 'patients',
            'patients' => $patients,
            'search' => $search,
            'canAccessAccounts' => Auth::can('accounts'),
        ]);
    }

    public function create(): void
    {
        Auth::requirePermission('patients');
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $created = PatientService::createPatient($_POST);
            ActivityLogService::log('Created patient ' . $created['name'], 'Patients', 'Success', ['patient_key' => $created['patient_key']]);
            App::flash('success', 'Patient record created (' . $created['patient_key'] . ').');
            App::redirect('/admin/patients/' . urlencode($created['patient_key']));
            return;
        }

        App::render('admin/patients/form', [
            'pageTitle' => 'Add New Patient',
            'activeNav' => 'patients',
            'patient' => [],
            'isEdit' => false,
        ]);
    }

    public function view(string $patientKey): void
    {
        Auth::requirePermission('patients');
        $patient = PatientService::findByKey($patientKey);
        if (!$patient) {
            App::flash('error', 'Patient record not found.');
            App::redirect('/admin/patients');
        }

        App::render('admin/patients/view', [
            'pageTitle' => 'Patient File: ' . ($patient['name'] ?? ''),
            'activeNav' => 'patients',
            'patient' => $patient,
            'services' => ServicesService::getAllServices(true),
            'doctors' => BookingService::getDefaultDoctors(),
            'canAccessAccounts' => Auth::can('accounts'),
        ]);
    }

    public function edit(string $patientKey): void
    {
        Auth::requirePermission('patients');
        $patient = PatientService::findByKey($patientKey);
        if (!$patient) {
            App::flash('error', 'Patient record not found.');
            App::redirect('/admin/patients');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            PatientService::updatePatient($patientKey, $_POST);
            ActivityLogService::log('Updated patient ' . ($_POST['name'] ?? $patientKey), 'Patients', 'Success', ['patient_key' => $patientKey]);
            App::flash('success', 'Patient details updated.');
            App::redirect('/admin/patients/' . urlencode($patientKey));
            return;
        }

        App::render('admin/patients/form', [
            'pageTitle' => 'Edit Patient: ' . ($patient['name'] ?? ''),
            'activeNav' => 'patients',
            'patient' => $patient,
            'isEdit' => true,
        ]);
    }

    public function addTreatment(string $patientKey): void
    {
        Auth::requirePermission('patients');
        PatientService::addTreatmentRecord($patientKey, $_POST);
        ActivityLogService::log('Added treatment record for patient ' . $patientKey, 'Patients', 'Success', ['service' => $_POST['service'] ?? '']);
        App::flash('success', 'Treatment & clinical note added to patient history.');
        App::redirect('/admin/patients/' . urlencode($patientKey));
    }

    public function delete(string $patientKey): void
    {
        Auth::requirePermission('patients');
        PatientService::deletePatient($patientKey);
        ActivityLogService::log('Deleted patient ' . $patientKey, 'Patients', 'Warning', ['patient_key' => $patientKey]);
        App::flash('success', 'Patient record deleted.');
        App::redirect('/admin/patients');
    }
}
