up-all:
	docker-compose build && docker-compose up
run-shell:
	docker-compose run marusia-workspace bash