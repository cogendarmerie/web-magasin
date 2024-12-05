docker-compose ?= $(shell which docker) compose -f docker-compose.yml
docker-exec ?= $(docker-compose) exec -it
sass ?= $(docker-exec) sass /bin/sh -c "sass ./assets/css/main.sass ./public/assets/css/main.css --no-source-map --style=compressed"

open-website ?= open http://localhost:8080

# Construire et lancer les containers Docker et compiler les fichiers CSS
.PHONY: build
build:
	# Lancer Docker
	$(docker-compose) up --build -d
	# Compiler les fichiers CSS
	$(sass)
	# Installer composer
	$(docker-exec) php /bin/bash -c "composer install"

# Migrer la base de donnée
.PHONY: migrate
migrate:
	$(docker-exec) php /bin/bash -c "php migrate.php"

# Lancer les containers et compiler les fichiers CSS
.PHONY: run
run:
	$(docker-compose) up -d
	$(sass)
	$(open-website)

# Stoper les containers Docker
.PHONY: stop
stop:
	$(docker-compose) down

# Compiler les fichiers CSS en mode watch
.PHONY: dev
dev:
	$(sass) --watch

# Se connecter au container en shell
.PHONY: php
php:
	$(docker-exec) php /bin/bash

.PHONY: sass
sass:
	$(docker-exec) sass /bin/sh

# Ouvrir le site internet dans le naviguateur web par défault
.PHONY: open
open:
	$(open-website)

.PHONY: test
test:
	$(docker-exec) php /bin/bash -c "php vendor/bin/phpunit --bootstrap tests/AlimentaireTest.php"