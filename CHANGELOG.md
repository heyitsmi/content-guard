# Changelog

All notable changes to `indo-guard` will be documented in this file.

## [Unreleased] - Work in Progress

### Added
- New **Profanity Dictionary** (`src/Dictionary/profanity.php`) to filter toxic comments, hate speech, and dirty words.
- Logic to merge multiple dictionaries automatically in `IndoGuard` class.
- Added single keywords ('slot', 'judi', 'gacor') to `gambling.php` for stricter filtering.

### Changed
- Updated README.md with better English documentation.
- Improved `composer.json` keywords for better SEO on Packagist.

## [v1.0.0] - 2025-11-29
### Added
- Initial release.
- Core Regex Engine for Leet Speak detection (e.g., `s1ot`, `g4c0r`).
- Gambling dictionary support.
- Laravel Service Provider and Facade.
- Unit Testing with PHPUnit.