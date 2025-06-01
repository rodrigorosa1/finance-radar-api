#!/bin/bash
cd /var/www/html
chmod 777 -R storage/
# echo -e $OAUTH_PRIVATE_KEY > storage/oauth-private.key
# echo -e $OAUTH_PUBLIC_KEY > storage/oauth-public.key
#php artisan passport:keys
exec "$@"
