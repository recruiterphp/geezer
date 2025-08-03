# Geezer

PHP tools to build robust long-running processes.

## Description

Geezer is a PHP library that provides tools for building and managing robust long-running processes. It uses Docker for development environment setup and includes a comprehensive set of development tools for testing, code analysis, and maintenance.

## Requirements

- PHP ^8.4
- ext-pcntl extension

## Development Requirements

- Docker

## Dependencies

- **recruiterphp/concurrency** ^5.0 - For concurrent processing
- **symfony/console** ^7.3 - For command-line interface

## Installation

Clone the repository and install dependencies:

```bash
git clone <repository-url>
cd geezer
make install
```

## Development Commands

The project includes a comprehensive Makefile with the following targets:

### Docker Management

- `make build` - Build the Docker image
- `make up` - Start the services in detached mode
- `make down` - Stop the services
- `make clean` - Clean up containers and volumes

### Dependency Management

- `make install` - Install composer dependencies
- `make update` - Update composer dependencies

### Testing and Code Quality

- `make test` - Run all PHPUnit tests
- `make phpstan` - Run PHPStan static analysis
- `make rector` - Run Rector for code refactoring
- `make fix-cs` - Fix code style using PHP-CS-Fixer

### Development Tools

- `make shell` - Open a bash shell in the PHP container
- `make logs` - View PHP container logs in follow mode

## Usage

1. Start the development environment:
   ```bash
   make up
   ```

2. Run tests to ensure everything is working:
   ```bash
   make test
   ```

3. Access the container for development:
   ```bash
   make shell
   ```

## Code Quality

The project maintains high code quality standards using:

- **PHPUnit** for unit testing
- **PHPStan** for static analysis
- **PHP-CS-Fixer** for code formatting
- **Rector** for automated refactoring

Run all quality checks:
```bash
make test
make phpstan
make fix-cs
make rector
```
