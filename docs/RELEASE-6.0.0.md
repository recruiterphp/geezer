# Geezer 6.0.0

## ✨ New Features

- **Docker development environment** - Added complete Docker Compose setup with PHP 8.4
- **GitHub Actions CI** - Comprehensive testing pipeline with PHPUnit and code validation
- **Makefile workflow** - Standardized development commands for building, testing, and code formatting
- **Modern PHP-CS-Fixer configuration** - PSR-12 and Symfony coding standards with strict types enforcement
- **Enhanced command interface** - Added `hasTerminated()` method to `RobustCommand` for better process control

## 🛠️ Improvements

- **PHP 8.4 compatibility** - Full upgrade to modern PHP with typed properties and constants
- **Enhanced type safety** - Added `declare(strict_types=1)` across all source files
- **Improved error handling** - Better return types and exception handling in `RobustCommandRunner`
- **Sleep optimization** - Configurable sleep step with `SLEEP_STEP_USEC` constant (200ms)
- **Code modernization** - Readonly properties, proper type hints, and improved method signatures

## 📦 Dependencies

### Updated
- `php: ^8.4` (from ^7.2)
- `symfony/console: ^7.3` (from ~4.0)
- `recruiterphp/concurrency: ^4.0` (from ^3.0.0)
- `phpunit/phpunit: ^12.3` (from ^7)
- `phpstan/phpstan: ^2.1` (from ^0.10.5)

### Added
- `friendsofphp/php-cs-fixer: ^3.85` for code formatting
- `ergebnis/composer-normalize: ^2.47` for composer.json normalization
- `rector/rector: ^2.1` for automated code refactoring

### Removed
- `phpstan/phpstan-phpunit: ^0.10.0` (integrated into main PHPStan)

## 🐳 Docker & Development

- **Docker Compose** - Complete development environment with PHP 8.4-cli
- **Makefile commands** - Standardized commands: `build`, `test`, `phpstan`, `fix-cs`, `shell`
- **System dependencies** - Pre-installed MongoDB extension, and development tools
- **Composer integration** - Optimized autoloader and superuser permissions

## 🔧 Breaking Changes

- **Minimum PHP version** - Now requires PHP 8.4+
- **License change** - Updated from proprietary to MIT license
- **Namespace consistency** - All classes now use `Recruiter\Geezer` namespace
- **Method signatures** - Updated type hints and return types may require interface implementations to be updated
- **Constants** - Private constants now use typed declarations (`private const int`, `private const string`)

## 🏗️  Development Tools

- **PHPStan Level 10** - Maximum static analysis level for enhanced code quality
- **Rector configuration** - Automated code modernization and refactoring
- **GitHub Actions** - Automated testing on push and pull requests
- **Composer normalization** - Consistent composer.json formatting

## 🛡️  Security

- **Updated dependencies** - All dependencies updated to latest secure versions

## Full Changelog

https://github.com/recruiterphp/geezer/compare/5.0.3...v6.0.0
