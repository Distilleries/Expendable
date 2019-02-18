versions = 7.1 7.2 7.3
pwda = $(pwd)
test:
	@echo "Start testing"
	@echo "Docker is located at `which docker`"
	@echo "`docker -v`"
	$(foreach version,$(versions),echo "Running test on PHP $(version)"; docker build --build-arg TEST_PHP_VERSION=$(version) --tag="tests-$(version)" . && docker run --rm -v $(shell pwd):/app -w /app "tests-$(version)";)
