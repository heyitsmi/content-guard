# Changelog

All notable changes to `content-guard` will be documented in this file.

## [1.2.0] - 2026-01-10
### Added
- New `wrap()` method for client-side content protection (blur and mask effects).
- Integrated CSS and JS assets for "click-to-reveal" experience.
- New `@contentGuardAssets` Blade directive for easy asset inclusion in Laravel.
- Isolation-based blur logic to prevent "filter bleeding" on UI elements.

## [1.1.0] - 2026-01-08
### Added
- New **Profanity Dictionary** (`src/Dictionary/profanity.php`) to filter toxic comments, hate speech, and dirty words.
- Logic to merge multiple dictionaries automatically in `ContentGuard` class.
- Added single keywords ('slot', 'judi', 'gacor') to `gambling.php` for stricter filtering.
- Renamed package from `IndoGuard` to `ContentGuard`.
- Changed namespace from `Heyitsmi\IndoGuard` to `Heyitsmi\ContentGuard`.

### Changed
- Updated README.md with better English documentation.
- Improved `composer.json` keywords for better SEO on Packagist.

## [1.0.0] - 2025-11-29
### Added
- Initial release.
- Core Regex Engine for Leet Speak detection (e.g., `s1ot`, `g4c0r`).
- Gambling dictionary support.
- Laravel Service Provider and Facade.
- Unit Testing with PHPUnit.