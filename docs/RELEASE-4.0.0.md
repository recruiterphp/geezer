# Geezer 4.0.0

## 🚀 Breaking Changes

- **Namespace migration** - Migrated from `Geezer\` to `Recruiter\Geezer\` namespace to avoid collisions
- **Dependency updates** - Updated to use recruiterphp organization libraries instead of legacy versions
- **Package organization** - Renamed project to align with recruiterphp organization structure

## 📦 Dependencies

### Updated
- Migrated to `recruiterphp/concurrency` and `recruiterphp/clock` packages
- Updated namespace imports to use `Recruiter\` instead of `RecruiterPhp\`

## 🔧 Breaking Changes

- **All class imports** - Update imports from `Geezer\*` to `Recruiter\Geezer\*`
- **Dependency imports** - Update concurrency imports from `RecruiterPhp\Concurrency\*` to `Recruiter\Concurrency\*`
- **Autoloading** - Update PSR-4 autoload configuration in consuming projects

## 🛠️ Migration Guide

1. **Update namespace imports:**
   ```php
   // Before
   use Geezer\Command\RobustCommand;
   use Geezer\Leadership\Dictatorship;
   
   // After
   use Recruiter\Geezer\Command\RobustCommand;
   use Recruiter\Geezer\Leadership\Dictatorship;
   ```

2. **Update composer dependencies** to use recruiterphp organization packages

## Full Changelog

https://github.com/recruiterphp/geezer/compare/3.0.1...4.0.0