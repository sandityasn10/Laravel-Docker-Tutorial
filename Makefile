.PHONY: up bash artisan tinker php

up:
	docker compose up -d

bash:
	docker compose exec app bash

artisan:
	docker compose exec app php artisan $(cmd)

tinker:
	docker compose exec app php artisan tinker

php:
	docker compose exec app php $(filter-out $@, $(MAKECMDGOALS))