<?php

namespace Heyitsmi\IndoGuard;

use Illuminate\Support\Str;

class IndoGuard
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
        $userKeywords           = config('indo-guard.keywords', []);
        $this->badWords         = array_merge($gamblingList, $profanityList, $userKeywords);
        $this->substitutionMap  = config('indo-guard.substitution_map', []);
        $this->maskChar         = config('indo-guard.mask_char', '*');
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
            
            // Execute replacement
            // We use a callback to maintain the length of the original matched string
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

        // Join characters with a pattern allowing symbols/spaces in between
        // [\W_]* allows for things like "j.u.d.i" or "j-u-d-i"
        $innerPattern = implode('[\W_]*', $patternBuilder);

        // Add Word Boundaries (\b) to prevent false positives (e.g., 'anal' in 'analysis')
        // We use lookahead/lookbehind or standard \b depending on complexity, 
        // but for now standard \b is safer.
        return '/\b' . $innerPattern . '\b/i';
    }
}