<?php

namespace Heyitsmi\ContentGuard;

use Illuminate\Support\Str;

class ContentGuard
{
    /**
     * The list of blocked keywords.
     * @var array
     */
    protected array $badWords = [];

    /**
     * The character map for leet speak detection.
     * @var array
     */
    protected array $substitutionMap = [];

    /**
     * The replacement character.
     * @var string
     */
    protected string $maskChar;

    public function __construct()
    {
        $gamblingList           = require __DIR__ . '/Dictionary/gambling.php';
        $profanityPath          = __DIR__ . '/Dictionary/profanity.php';
        $profanityList          = file_exists($profanityPath) ? require $profanityPath : [];
        $userKeywords           = config('content-guard.keywords', []);
        $this->badWords         = array_merge($gamblingList, $profanityList, $userKeywords);
        $this->substitutionMap  = config('content-guard.substitution_map', []);
        $this->maskChar         = config('content-guard.mask_char', '*');
    }

    /**
     * Sanitize the given text by masking blocked words.
     *
     * @param string $text
     * @return string
     */
    public function sanitize(string $text): string
    {
        foreach ($this->badWords as $word) {
            $pattern = $this->generateRegexPattern($word);
            
            $text = preg_replace_callback($pattern, function ($matches) {
                return str_repeat($this->maskChar, strlen($matches[0]));
            }, $text);
        }

        return $text;
    }

    /**
     * Check if the text contains any blocked content.
     *
     * @param string $text
     * @return bool
     */
    public function hasBadWords(string $text): bool
    {
        foreach ($this->badWords as $word) {
            $pattern = $this->generateRegexPattern($word);
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate a flexible Regex pattern for a specific word.
     * Handles leet speak and separators.
     * * Example: "judi" becomes /\b(j)([\W_]*)(u|v...)([\W_]*)(d)...etc/i
     *
     * @param string $word
     * @return string
     */
    private function generateRegexPattern(string $word): string
    {
        $escapedWord = preg_quote($word, '/');
        $chars = str_split($escapedWord);
        
        $patternBuilder = [];

        foreach ($chars as $char) {
            $lowerChar = strtolower($char);
            
            // Check if we have a substitution for this character
            if (isset($this->substitutionMap[$lowerChar])) {
                $patternBuilder[] = $this->substitutionMap[$lowerChar];
            } else {
                $patternBuilder[] = $char;
            }
        }

        $innerPattern = implode('[\W_]*', $patternBuilder);
        return '/\b' . $innerPattern . '\b/i';
    }

    /**
     * Wrap bad words with HTML tags for front-end blurring/masking.
     *
     * @param string $text
     * @param string|null $type ('blur', 'mask', or null to use default)
     * @return string
     */
    public function wrap(string $text, ?string $type = null): string
    {
        $type = $type ?? config('content-guard.default_wrap_type', 'blur');

        foreach ($this->badWords as $word) {
            $pattern = $this->generateRegexPattern($word);
            
            $text = preg_replace_callback($pattern, function ($matches) use ($type) {
                return '<span class="cg-word cg-' . $type . '" data-cg-word="' . htmlspecialchars($matches[0]) . '"><span class="cg-inner">' . $matches[0] . '</span></span>';
            }, $text);
        }

        return $text;
    }

    /**
     * Output the necessary CSS for ContentGuard masking.
     *
     * @return string
     */
    public function styles(): string
    {
        // Check if helper function 'asset' exists (Laravel)
        if (function_exists('asset')) {
            return '<link rel="stylesheet" href="' . asset('vendor/content-guard/css/content-guard.css') . '">';
        }
        
        return '<!-- ContentGuard: asset() helper not found. Please include CSS manually. -->';
    }

    /**
     * Output the necessary JavaScript for ContentGuard masking.
     *
     * @return string
     */
    public function scripts(): string
    {
        if (function_exists('asset')) {
            return '<script src="' . asset('vendor/content-guard/js/content-guard.js') . '"></script>';
        }

        return '<!-- ContentGuard: asset() helper not found. Please include JS manually. -->';
    }
}