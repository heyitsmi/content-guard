<?php

namespace Heyitsmi\IndoGuard\Tests\Unit;

use Heyitsmi\IndoGuard\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IndoGuardTest extends TestCase
{
    #[Test]
    public function it_can_detect_basic_bad_words()
    {
        $guard = app('indo-guard');
        $text = "Jangan main judi disini";

        $this->assertTrue($guard->hasBadWords($text));
        $this->assertStringContainsString('****', $guard->sanitize($text));
    }

    #[Test]
    public function it_can_detect_leet_speak_variations()
    {
        $guard = app('indo-guard');
        
        $text1 = "Situs s1ot terpercaya";
        $this->assertTrue($guard->hasBadWords($text1), "Failed detecting 's1ot'");

        $text2 = "Ayo main j.u.d.i bola";
        $this->assertTrue($guard->hasBadWords($text2), "Failed detecting 'j.u.d.i'");
    }

    #[Test] 
    public function it_can_detect_profanity_and_toxic_words()
    {
        $guard = app('indo-guard');
        
        $text = "Dasar anj1ng lu!";
        $this->assertTrue($guard->hasBadWords($text), "Gagal mendeteksi kata kasar/profanity");
        
        $clean = $guard->sanitize($text);
        $this->assertStringContainsString('******', $clean);
    }

    #[Test]
    public function it_can_detect_single_gambling_keywords()
    {
        $guard = app('indo-guard');
        
        $text = "Ayo main slot sekarang";
        $this->assertTrue($guard->hasBadWords($text), "Gagal mendeteksi single keyword 'slot'");
    }

    #[Test]
    public function it_does_not_flag_safe_words_containing_bad_substrings()
    {
        $guard = app('indo-guard');
        $safeText = "Saya beli kasur di makasar";
        
        $this->assertFalse($guard->hasBadWords($safeText));
        $this->assertEquals($safeText, $guard->sanitize($safeText));
    }

    #[Test]
    public function it_can_use_facade_accessor()
    {
        $text = "Halo dunia";
        $clean = app('indo-guard')->sanitize($text); 
        
        $this->assertEquals($text, $clean);
    }
}