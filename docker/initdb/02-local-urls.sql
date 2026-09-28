-- Runs after the dump import (files run in name order). The app builds its post-login
-- redirects from this column, so point it at the local container instead of production.
UPDATE sys_setup_maintain SET urls_system = 'http://localhost:8100' WHERE status_system = 'AC';
