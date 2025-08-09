# Geezer 2.0.0

## 🚀 Breaking Changes

- **Sleep timing units** - Sleep time is now specified in milliseconds instead of seconds for more precise control
- **Signal handling** - Enhanced signal handling including SIGHUP for better process control

## ✨ New Features

- **Command shutdown lifecycle** - Added `shutdown()` method to `RobustCommand` interface called before process termination
- **Exception injection** - Shutdown handler now receives any exceptions that occurred during execution
- **Enhanced signal handling** - Added SIGHUP signal handling for better process control

## 🛠️ Improvements

- **Lock management optimization** - Instead of releasing and acquiring locks at every cycle, locks are now refreshed
- **Better resource management** - More efficient lock handling reduces MongoDB operations
- **Enhanced testing** - Added comprehensive tests for `ExponentialBackoffStrategy`

## 🔧 Breaking Changes

- **RobustCommand interface** - Now requires implementation of `shutdown(Exception $e = null)` method
- **Timing units** - All sleep/wait times are now in milliseconds instead of seconds

## 🛠️ Migration Guide

1. **Update RobustCommand implementations** - Add `shutdown(Exception $e = null)` method
2. **Update timing values** - Convert any hardcoded sleep times from seconds to milliseconds (multiply by 1000)

## Full Changelog

https://github.com/recruiterphp/geezer/compare/1.0.0...2.0.0