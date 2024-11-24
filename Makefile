DOCKER_COMPOSE_RUN = docker compose run --rm --build vending-machine
DOCKER_CONSOLE = $(DOCKER_COMPOSE_RUN) bin/console

install-dependencies:
	$(DOCKER_COMPOSE_RUN) composer install

create_db:
	$(DOCKER_CONSOLE) doctrine:database:create
	$(DOCKER_CONSOLE) doctrine:schema:create

enter:
	$(DOCKER_COMPOSE_RUN) bash

service-products:
	$(DOCKER_CONSOLE) vending:service "$(cat products.json)"




