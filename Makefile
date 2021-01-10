run:
	@docker-compose run --rm phpcli bash

exec:
	@docker-compose run --rm phpcli php $(type)/$(pattern).php
