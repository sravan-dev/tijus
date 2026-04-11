#!/bin/bash
export PATH="/usr/local/bin:$PATH"
echo "Starting portable WordPress playground on http://localhost:8000"
echo "Using SQLite Database..."
echo "Server is running in the background. Check server.log for output."
php -S localhost:8000 router.php > server.log 2>&1 &
