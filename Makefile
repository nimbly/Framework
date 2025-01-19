.PHONY: setup validate test coverage analyze shell docs
-include .env

setup:
	cp example.env .env
	composer install
	php cmd setup

validate:
	vendor/bin/php-openapi validate openapi.json

test:
	vendor/bin/phpunit --display-deprecations

coverage:
	php -d xdebug.mode=coverage vendor/bin/phpunit --display-deprecations --coverage-clover=build/tests/clover.xml

analyze:
	vendor/bin/psalm

shell:
	php cmd shell

docs:
	npx @redocly/cli build-docs openapi.json --output build/docs/index.html