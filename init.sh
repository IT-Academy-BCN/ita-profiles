#!/bin/bash

echo "Starting supervisord..."
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf &

# Función para verificar si un servicio está listo
wait_for_service() {
  local host=$1
  local port=$2
  local max_retries=30
  local retries=0

  echo "Waiting for $host:$port..."
  while ! nc -z $host $port; do
    retries=$((retries + 1))
    if [ $retries -ge $max_retries ]; then
      echo "Service $host:$port not ready after $max_retries attempts, exiting."
      exit 1
    fi
    sleep 2
  done
  echo "$host:$port is ready!"
}

# Esperar a que los servicios estén listos
wait_for_service "127.0.0.1" 3306  # MariaDB
wait_for_service "127.0.0.1" 6379  # Redis

echo "Executing entrypoint scripts..."
/bin/sh /root/entrypoint.sh
/bin/sh /root/entrypoint_node.sh

echo "Initialization complete. Supervisord will manage all services."

# Mantener el contenedor activo gestionado por supervisord
wait
