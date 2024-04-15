install:
	composer install

lint:
	./vendor/bin/phpcs -- -v --standard=PSR12 src tests


test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html reports