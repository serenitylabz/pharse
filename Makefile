.PHONY: test docs

test:
	mkdir -p tmp
	docker run --rm -it -v `pwd`:/app -v `pwd`/tmp:/tmp --user `id -u`:`id -g` composer:1.6.5 /bin/bash -c "composer install && composer dumpautoload && ./vendor/bin/phpunit"
