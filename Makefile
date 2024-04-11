install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests


test:
	composer exec --verbose phpunit tests

testCoverage:
	XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html reports