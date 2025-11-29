<?php

namespace Heyitsmi\IndoGuard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Heyitsmi\IndoGuard\IndoGuardServiceProvider;

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
            IndoGuardServiceProvider::class,
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
        $app['config']->set('indo-guard.mask_char', '*');
        
        $app['config']->set('indo-guard.substitution_map', [
            'a' => '(a|4|@)',
            'i' => '(i|1|!)',
            'o' => '(o|0)',
            'l' => '(l|1|!)', 
            's' => '(s|5|\\$)',
            't' => '(t|7|\\+)',
        ]);

        $app['config']->set('indo-guard.keywords', [
            'judi',
            'slot',
            'kasar'
        ]);
    }
}