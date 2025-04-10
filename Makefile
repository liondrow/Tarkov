xdebug-on:
	docker exec -it tarkov-php mv /usr/local/etc/php/conf.d/99-xdebug.ini.disabled /usr/local/etc/php/conf.d/99-xdebug.ini && docker restart tarkov-php

xdebug-off:
	docker exec -it tarkov-php mv /usr/local/etc/php/conf.d/99-xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini.disabled && docker restart tarkov-php