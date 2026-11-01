#!/bin/sh
set -e

mkdir -p /tmp/storage/framework/views

exec frankenphp run --config /app/Caddyfile
