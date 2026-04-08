#!/bin/bash
echo "=========================================="
echo "  ClickBank Revenue Nexus - Setup Logic"
echo "=========================================="

:: Initialize Database
if [ ! -f nexus_data.db ]; then
    echo "Initializing SQL Database..."
    python3 -c "import sqlite3; conn = sqlite3.connect('nexus_data.db'); f = open('schema.sql', 'r'); conn.executescript(f.read()); conn.close();"
fi

:: Start Engine and Dashboard
python3 engine.py &
open index.html

echo "System Active."
