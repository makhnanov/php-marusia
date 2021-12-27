DOCKER_COMPOSE = docker compose
run-build:
	$(DOCKER_COMPOSE) build
run-up:
	$(DOCKER_COMPOSE) up -d
run-shell:
	$(DOCKER_COMPOSE) run marusia-workspace bash
