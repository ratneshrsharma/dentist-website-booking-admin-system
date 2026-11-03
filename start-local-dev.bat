@echo off
title DentaFlow Local Full-Stack (Next.js + PHP AdminLTE)
echo ======================================================================
echo  Starting DentaFlow Local Full-Stack Environment
echo  Patient Frontend: http://localhost:3000/advanced-dental-clinic/
echo  Admin EMR Portal: http://localhost:3000/advanced-dental-clinic/admin/
echo ======================================================================

cd /d "%~dp0frontend"
node scripts/dev-full.js
pause
