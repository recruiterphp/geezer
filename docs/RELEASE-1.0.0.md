# Geezer 1.0.0

## ✨ Initial Release

- **Robust command framework** - Tools for building robust long-running PHP processes
- **Leadership strategies** - Anarchy and Dictatorship patterns for distributed process coordination
- **Wait strategies** - Exponential backoff and other timing strategies for resilient operations
- **Process management** - Signal handling and graceful shutdown capabilities

## 🏗️ Core Components

### Command Framework
- **`RobustCommand`** - Interface for commands that can run continuously with error recovery
- **`RobustCommandRunner`** - Core runner that handles command lifecycle, retries, and error handling

### Leadership Strategies
- **`Anarchy`** - No coordination, all instances run independently
- **`Dictatorship`** - MongoDB-based distributed locking for single leader election

### Timing Strategies
- **`ExponentialBackoffStrategy`** - Exponential backoff for retry logic
- **`WaitStrategy`** - Interface for custom timing strategies

## 🔧 Features

- **Signal handling** - Graceful shutdown on SIGTERM and SIGINT
- **Memory management** - Garbage collection every 100 cycles to prevent memory leaks
- **Error recovery** - Automatic retry with configurable backoff strategies
- **MongoDB integration** - Distributed locking via MongoDB for coordination
- **Logging integration** - PSR-3 logger support for monitoring and debugging

## 🛠️ Development Tools

- **PHP-CS-Fixer** - Code style enforcement
- **PHPUnit** - Unit testing framework
- **Composer** - Dependency management with explicit platform requirements

## 📦 Requirements

- PHP 7.1+
- MongoDB extension for distributed locking features
- PCntl extension for signal handling

## Full Changelog

https://github.com/recruiterphp/geezer/releases/tag/1.0.0