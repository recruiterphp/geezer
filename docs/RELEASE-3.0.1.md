# Geezer 3.0.1

## ✨ New Features

- **Leadership event handling** - Added `LeadershipEventsHandler` interface for handling leadership status changes
- **Enhanced command lifecycle** - `RobustCommandRunner` now calls handler methods when leadership status changes

## 🛠️ Improvements

- **PSR compliance** - Renamed `RobustCommandLeadershipListener.php` to `LeadershipEventsHandler.php` for PSR naming standards
- **Better separation of concerns** - Improved event handling architecture for command lifecycle management

## 🔄 Refactoring

- Reverted and refined leadership hooks implementation with better design
- Enhanced error handling and event dispatch in command runner

## Full Changelog

https://github.com/recruiterphp/geezer/compare/3.0.0...3.0.1