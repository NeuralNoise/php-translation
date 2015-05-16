<?php

namespace ShouldBee\Translation;

class NegotiationTest extends \PHPUnit_Framework_TestCase
{
    public function testNegotiation()
    {
        $availableLanguages = ['en', 'ja', 'ko', 'zh'];

        // default
        $language = Negotiation::negotiate($availableLanguages);
        $this->assertSame('en', $language);

        // set Accept-Language.
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "ja-JP,ja;q=0.8,en;q=0.6";
        $language = Negotiation::negotiate($availableLanguages);
        $this->assertSame('ja', $language);

        // set query string.
        $_GET['language'] = 'ko';
        $language = Negotiation::negotiate($availableLanguages);
        $this->assertSame('ko', $language);

        // set cookie.
        $_COOKIE['language'] = 'zh';
        $language = Negotiation::negotiate($availableLanguages);
        $this->assertSame('zh', $language);
    }
} 