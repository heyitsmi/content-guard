<?php

namespace Heyitsmi\ContentGuard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Heyitsmi\ContentGuard\ContentGuardServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ContentGuardServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('content-guard.mask_char', '*');
        
        $app['config']->set('content-guard.substitution_map', [
            'a' => '(a|4|@)',
            'i' => '(i|1|!)',
            'o' => '(o|0)',
            'l' => '(l|1|!)', 
            's' => '(s|5|\\$)',
            't' => '(t|7|\\+)',
        ]);

        $app['config']->set('content-guard.keywords', [
            'judi',
            'slot',
            'kasar'
        ]);
    }
}