#!/bin/bash

# Использование: ./check_port.sh [host] [port]

# Значения по умолчанию
HOST=${1:-"localhost"}
PORT=${2:-"22"}
LOG_FILE="check_port.log"

# Проверка доступности порта
if nc -z -w 3 "$HOST" "$PORT" 2>/dev/null; then
    echo "Порт $HOST:$PORT доступен"
else
    echo "Порт $HOST:$PORT недоступен"
    # Запись в лог при недоступности
    echo "$(date '+%Y-%m-%d %H:%M:%S') - Порт $HOST:$PORT недоступен" >> "$LOG_FILE"
fi
