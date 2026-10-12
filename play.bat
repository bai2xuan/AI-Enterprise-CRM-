@echo off
setlocal EnableExtensions
title AI Enterprise CRM - Play

:: ============================================================
::  AI Enterprise CRM  --  one-click launcher  (Windows)
:: ------------------------------------------------------------
::  Just double-click this file after cloning the repository.
::  It starts the portable MariaDB and the PHP web server that
::  ship with the project, then opens the application.
::
::  Stop the application by closing the two minimised windows
::  it opens (titles: AIECRM-MariaDB / AIECRM-Web), or run
::  stop-project.bat from the workspace root.
::
::  NOTE: this repository contains the customisation only.
::  The runtime (tools\) and the SuiteCRM upstream sources
::  (crm\) are NOT included and must be prepared once - see
::  deploy\native\README.md, section "1.1".
:: ============================================================

set "REPO=%~dp0"
if "%REPO:~-1%"=="\" set "REPO=%REPO:~0,-1%"

set "PHP_EXE=%REPO%\tools\php\php.exe"
set "MARIA_EXE=%REPO%\tools\mariadb-10.11.19-winx64\bin\mysqld.exe"
set "MARIA_INI=%REPO%\tools\mariadb-10.11.19-winx64\my.ini"
set "DB_DATA=%REPO%\data\mysql"
set "WEB_DIR=%REPO%\crm"
set "URL=http://localhost:8080/index.php"

echo ============================================================
echo   AI Enterprise CRM  --  Play
echo ============================================================
echo.
echo   Repo : %REPO%
echo.

:: ---------- 1. runtime check -------------------------------------------
set "MISSING="
if not exist "%PHP_EXE%"                 set "MISSING=%MISSING% tools\php\php.exe"
if not exist "%MARIA_EXE%"               set "MISSING=%MISSING% tools\mariadb-10.11.19-winx64\bin\mysqld.exe"
if not exist "%MARIA_INI%"               set "MISSING=%MISSING% tools\mariadb-10.11.19-winx64\my.ini"
if not exist "%WEB_DIR%\index.php"       set "MISSING=%MISSING% crm\index.php"

if defined MISSING (
    echo [ERROR] Runtime is not ready. Missing:%MISSING%
    echo.
    echo   This repository ships the customisation only - the portable
    echo   runtime and the SuiteCRM upstream sources are NOT included.
    echo   Prepare them once, into exactly these paths:
    echo.
    echo     tools\php\                        PHP 8.3.x  NTS x64
    echo     tools\mariadb-10.11.19-winx64\   MariaDB 10.11.19 winx64
    echo     crm\                              SuiteCRM 7.15.2 sources
    echo.
    echo   Download links and the PHP extension list are in:
    echo     deploy\native\README.md      ^(section "1.1  How to get"^)
    echo.
    pause
    exit /b 1
)

:: ---------- 2. database check ------------------------------------------
if not exist "%DB_DATA%" (
    echo [ERROR] The database has never been initialised: data\mysql not found.
    echo.
    echo   Follow the first-time setup once:
    echo     deploy\native\README.md      ^(section "5.  First deployment"^)
    echo.
    pause
    exit /b 1
)

:: ---------- 3. already running? ----------------------------------------
netstat -ano | findstr /C:":8080 " | findstr /I "LISTENING" >nul 2>&1
if not errorlevel 1 (
    echo [INFO] Port 8080 is already listening - the application
    echo        looks like it is already running.
    echo.
    echo   Opening: %URL%
    start "" "%URL%"
    timeout /t 4 /nobreak >nul
    exit /b 0
)

:: ---------- 4. start services ------------------------------------------
echo [1/3] Starting MariaDB  ^(port 3307^) ...
start "AIECRM-MariaDB" /min "%MARIA_EXE%" --defaults-file="%MARIA_INI%"
timeout /t 8 /nobreak >nul

echo [2/3] Starting PHP Web server  ^(port 8080^) ...
start "AIECRM-Web" /min "%PHP_EXE%" -S 127.0.0.1:8080 -t "%WEB_DIR%"
timeout /t 5 /nobreak >nul

echo [3/3] Opening the browser ...
start "" "%URL%"

echo.
echo ============================================================
echo   Ready  :  %URL%
echo   Login  :  admin
echo   Password: see README section 11 / file data\.pw
echo.
echo   Always use  "localhost"  ^(NOT 127.0.0.1^), otherwise the
echo   session cookie is dropped and you bounce back to login.
echo.
echo   Two minimised windows were opened. Close them to stop.
echo ============================================================
echo.
pause
