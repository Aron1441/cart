init: docker-down docker-build docker-up
up: docker-up
down: docker-down

docker-build:
	docker-compose -f docker-compose.yaml build

docker-up:
	docker-compose -f docker-compose.yaml up -d

docker-down:
	docker-compose -f docker-compose.yaml down --remove-orphans

build: build-gateway build-api build-frontend

build-api:
	docker build --pull --file=api/docker/production --tag=${REGISTRY}/

build-gateway:
	docker build --pull --file=api/docker/production --tag=${REGISTRY}/

build-frontend:
	docker build --pull --file=api/docker/production --tag=${REGISTRY}/
