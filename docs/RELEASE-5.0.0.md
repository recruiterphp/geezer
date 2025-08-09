# Geezer 5.0.0

## 🛠️ Improvements

- **Fatal error handling** - Enhanced error handling to properly catch fatal errors and release locks
- **Resource cleanup** - Improved resource management ensuring locks are released even after fatal errors
- **Process reliability** - Better fault tolerance for long-running processes

## 🔧 Breaking Changes

- **Error handling changes** - Modified error handling behavior in `RobustCommand` and `RobustCommandRunner`
- **Interface modifications** - Minor adjustments to command interface for better error handling

## Full Changelog

https://github.com/recruiterphp/geezer/compare/4.0.2...5.0.0