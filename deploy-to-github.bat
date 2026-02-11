@echo off
echo ========================================
echo    EDUCARE - DEPLOY TO GITHUB SCRIPT
echo ========================================
echo.

REM Check if Git is installed
git --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Git is not installed or not in PATH
    echo Please install Git from: https://git-scm.com/download/win
    echo.
    pause
    exit /b 1
)

echo Git is installed. Proceeding with deployment...
echo.

REM Initialize Git repository if not exists
if not exist ".git" (
    echo Initializing Git repository...
    git init
    echo.
)

REM Add remote origin if not exists
git remote get-url origin >nul 2>&1
if %errorlevel% neq 0 (
    echo Adding remote origin...
    git remote add origin https://github.com/ekazahrosafitri6-dot/Educare_ukk2026.git
    echo.
)

REM Configure Git user (you may need to change these)
echo Configuring Git user...
git config user.name "EduCare Developer"
git config user.email "educare@example.com"
echo.

REM Add all files
echo Adding all files to Git...
git add .
echo.

REM Commit changes
echo Committing changes...
git commit -m "Initial commit: EduCare - Sistem Pengaduan Sarana dan Prasarana Sekolah

Features:
- Student portal for aspiration submission
- Admin panel with comprehensive management
- Dashboard analytics and reporting
- PDF/Excel export functionality
- Audit trail and security features
- Responsive design and modern UI
- Complete MVC architecture implementation

This is the initial release of EduCare system for UKK 2026 project."
echo.

REM Push to GitHub
echo Pushing to GitHub...
git branch -M main
git push -u origin main
echo.

if %errorlevel% equ 0 (
    echo ========================================
    echo   SUCCESS! Project pushed to GitHub
    echo ========================================
    echo.
    echo Repository URL: https://github.com/ekazahrosafitri6-dot/Educare_ukk2026
    echo.
    echo You can now:
    echo 1. View your project on GitHub
    echo 2. Share the repository link
    echo 3. Set up GitHub Pages for hosting
    echo.
) else (
    echo ========================================
    echo   ERROR: Failed to push to GitHub
    echo ========================================
    echo.
    echo Possible solutions:
    echo 1. Check your internet connection
    echo 2. Verify repository URL is correct
    echo 3. Make sure you have push access to the repository
    echo 4. Try running: git push origin main --force
    echo.
)

pause