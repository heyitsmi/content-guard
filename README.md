
# IndoGuard

**IndoGuard** is a robust PHP content sanitization library specifically designed for the **Indonesian** web ecosystem. It helps developers filter out online gambling spam (*judi online*), profanity, and hate speech with advanced detection capabilities.

Unlike simple string replacement tools, IndoGuard uses an intelligent **Regex Engine** to detect "Leet Speak" (visual masking) commonly used by spammers (e.g., detecting `s10t g4c0r` as `slot gacor`).

## Features

-   ✅ **Smart Detection:** Catch masked words like `g4c0r`, `s.l.o.t`, `judi`, etc.
-   ✅ **Pre-built Dictionary:** Comes with a comprehensive database of Indonesian gambling terms and profanity.
-   ✅ **Laravel Ready:** Includes Service Provider and Facade for seamless integration.
-   ✅ **Customizable:** Add your own blocklist and configure strictness.
-   ✅ **Zero Dependencies:** Lightweight and fast.

## Installation

You can install the package via composer:

```bash
composer require heyitsmi/indo-guard
```
## Configuration (Laravel)

If you are using Laravel, you can publish the configuration file to customize the behavior (e.g., changing the mask character or adding custom keywords).

Run the following command:
```bash
php artisan vendor:publish --tag="indo-guard-config"
```
This will create a `config/indo-guard.php` file in your application.

## Usage

### 1. Using Laravel Facade (Recommended for Laravel)

You can use the `IndoGuard` facade anywhere in your controllers, jobs, or blade directives.
```php
use Heyitsmi\IndoGuard\Facades\IndoGuard;

// 1. Check if text contains bad words (returns boolean)
$isSpam = IndoGuard::hasBadWords("Ayo main s10t g4c0r hari ini!"); 

if ($isSpam) {
    return back()->withErrors(['message' => 'Your comment contains restricted content.']);
}

// 2. Sanitize text (returns clean string)
$cleanText = IndoGuard::sanitize("Jangan main judi online!");
// Output: "Jangan main **** ******!"
```
### 2. Standalone PHP Usage

If you are not using Laravel, you can instantiate the class directly.
```php
use Heyitsmi\IndoGuard\IndoGuard;

$guard = new IndoGuard();

$input = "Situs g.a.c.o.r terpercaya";

if ($guard->hasBadWords($input)) {
    echo "Spam detected!";
}

echo $guard->sanitize($input);
```
## How It Works

IndoGuard converts standard keywords into flexible Regex patterns based on a Substitution Map.

-   **Input:** `slot`
    
-   **Regex Generated:** `/\b(s|5|\$|z)[\W_]*(l|1|!|\|)[\W_]*(o|0|@|ø)[\W_]*(t|7|\+)\b/i`
    
-   **Matches:** `slot`, `s1ot`, `s.l.o.t`, `s-l-o-t`, `sl0t`, etc.
    

## Testing

To run the unit tests included in this package:
```bash
composer test
```
## Contributing

Contributions are welcome! If you find new slang words or spam patterns popular in Indonesia, please submit a Pull Request to update the `src/Dictionary` files.

## License

The MIT License (MIT). Please see License File for more information.
