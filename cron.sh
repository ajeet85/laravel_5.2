#!/bin/bash
export PATH="/usr/local/bin:/usr/bin:/bin";
eval "$(docker-machine env default)" &&
docker exec trackerapp php /var/www/html/artisan schedule:run;
