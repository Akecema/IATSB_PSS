#!/bin/sh
set -e

# APP_DEBUG=true switches on error display for local development. Leave it
# unset/false in any shared or production environment.
if [ "${APP_DEBUG:-false}" = "true" ]; then
    cat > /usr/local/etc/php/conf.d/zz-app-debug.ini <<'EOF'
display_errors = On
error_reporting = E_ALL
EOF
else
    rm -f /usr/local/etc/php/conf.d/zz-app-debug.ini
fi

exec "$@"
