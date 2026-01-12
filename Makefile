.PHONY: up bash php

up:
	docker compose up -d

bash:
	docker compose exec app bash

php:
	docker compose exec app php $(filter-out $@, $(MAKECMDGOALS))
%:
	@: