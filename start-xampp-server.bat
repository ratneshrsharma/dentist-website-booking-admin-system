@echo off
title Advanced Dental Clinic - XAMPP Local Server
echo ======================================================================
echo  Starting XAMPP Apache and MySQL for Advanced Dental Clinic
echo ======================================================================

echo Checking / Starting MySQL...
tasklist /fi "imagename eq mysqld.exe" | find /i "mysqld.exe" >nul
if errorlevel 1 (
    echo Starting MySQL on port 3306...
    start /b "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --standalone
) else (
    echo MySQL is already running.
)

echo Checking / Starting Apache...
tasklist /fi "imagename eq httpd.exe" | find /i "httpd.exe" >nul
if errorlevel 1 (
    echo Starting Apache on port 80...
    start /b "" "C:\xampp\apache\bin\httpd.exe"
) else (
    echo Apache is already running.
)

echo ======================================================================
echo  XAMPP Local Server is Active!
echo  Patient Website: http://localhost/advanced-dental-clinic/
echo  AdminLTE Portal: http://localhost/advanced-dental-clinic/admin/
echo  REST API Status: http://localhost/advanced-dental-clinic/api/v1/ping
echo ======================================================================
pause
