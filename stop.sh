#!/bin/bash

echo "Stopping portable WordPress playground..."
PID=$(pgrep -f "php -S localhost:8000")

if [ -n "$PID" ]; then
    kill $PID
    echo "Server stopped (PID: $PID)."
else
    echo "Server is not running on port 8000."
fi