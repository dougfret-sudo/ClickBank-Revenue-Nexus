@echo off
echo ==========================================
echo   ClickBank Revenue Nexus - Setup Logic
echo ==========================================

:: Check if Python is installed
python --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Python not found. Please install Python.
    pause
    exit /b
)

:: Initialize Database if it doesn't exist
if not exist nexus_data.db (
    echo Initializing SQL Database...
    python -c "import sqlite3; conn = sqlite3.connect('nexus_data.db'); f = open('schema.sql', 'r'); conn.executescript(f.read()); conn.close();"
    echo [SUCCESS] Database created from schema.sql.
)

:: Start the Engine in a new window
echo Starting Nexus Engine...
start cmd /k "python engine.py"

:: Launch the Dashboard
echo Opening Dashboard...
start "" "index.html"

echo ==========================================
echo   SYSTEM ACTIVE.
echo ==========================================
pause
