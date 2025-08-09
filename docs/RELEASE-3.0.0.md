# Geezer 3.0.0

## 🚀 Breaking Changes

- **MongoDB driver modernization** - Updated concurrency library to remove dependencies on legacy MongoDB driver
- **Dependency requirements** - Now requires modern MongoDB extension (no more legacy `mongo` driver support)

## 📦 Dependencies

### Updated
- Updated `concurrency` library to version that supports modern MongoDB drivers only

## 🛠️ Migration Guide

- Ensure your MongoDB extension is up to date (use `ext-mongodb` instead of legacy `ext-mongo`)
- Update any MongoDB-related code to use modern driver APIs

## Full Changelog

https://github.com/recruiterphp/geezer/compare/2.0.4...3.0.0