<?php

namespace Heyitsmi\IndoGuard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string sanitize(string $text)
 * @method static bool hasBadWords(string $text)
 * * @see \Heyitsmi\IndoGuard\IndoGuard
 */
class IndoGuard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // This matches the bind key in your ServiceProvider
        return 'indo-guard';
    }
}