@echo off
title Sync to XAMPP - Advanced Dental Clinic
echo ======================================================================
echo  Building and Syncing Latest Patient Website ^& Backend to XAMPP
echo ======================================================================

cd /d "%~dp0frontend"
echo [1/3] Building Next.js Static Export...
call npm run build
if errorlevel 1 (
    echo Build failed!
    pause
    exit /b 1
)

echo [2/3] Deploying Static Pages to C:\xampp\htdocs\advanced-dental-clinic\...
if not exist "C:\xampp\htdocs\advanced-dental-clinic" mkdir "C:\xampp\htdocs\advanced-dental-clinic"
xcopy /E /I /Y "out\*" "C:\xampp\htdocs\advanced-dental-clinic\"

echo [3/3] Syncing Backend, .htaccess and Configuration...
xcopy /E /I /Y "..\backend" "C:\xampp\htdocs\advanced-dental-clinic\backend\"
copy /Y "..\.htaccess" "C:\xampp\htdocs\advanced-dental-clinic\.htaccess"
if not exist "C:\xampp\htdocs\advanced-dental-clinic\backend\.env" (
    copy /Y "..\backend\.env.example" "C:\xampp\htdocs\advanced-dental-clinic\backend\.env"
)

echo ======================================================================
echo  Deployment to XAMPP Complete!
echo  Visit: http://localhost/advanced-dental-clinic/
echo ======================================================================
pause
