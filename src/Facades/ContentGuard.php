<?php

namespace Heyitsmi\ContentGuard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string sanitize(string $text)
 * @method static bool hasBadWords(string $text)
 * * @see \Heyitsmi\ContentGuard\ContentGuard
 */
class ContentGuard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // This matches the bind key in your ServiceProvider
        return 'content-guard';
    }
}