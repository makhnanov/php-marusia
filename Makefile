up-all:
	docker-compose build && docker-compose up -d
run-shell:
	docker-compose run marusia-workspace bash