# Geezer 5.0.2

## ✨ New Features

- **Process termination control** - Added `hasTerminated()` method to `RobustCommand` interface for better process lifecycle management
- **Enhanced command runner** - `RobustCommandRunner` now properly detects when work is complete and can terminate gracefully

## 🛠️ Improvements

- **Better resource management** - Commands can now signal completion, preventing unnecessary resource usage
- **Improved process control** - Enhanced ability to manage long-running processes with proper termination detection

## 🔧 Breaking Changes

- **Interface extension** - `RobustCommand` interface now requires implementation of `hasTerminated()` method

## Full Changelog

https://github.com/recruiterphp/geezer/compare/5.0.1...5.0.2