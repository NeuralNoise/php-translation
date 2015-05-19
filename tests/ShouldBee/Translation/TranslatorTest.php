<?php

namespace ShouldBee\Translation;

class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    public function testTranslation()
    {
        $defaultCatalogue = json_decode(file_get_contents(__DIR__ . '/catalogue-default.json'), true);
        $englishCatalogue = json_decode(file_get_contents(__DIR__ . '/catalogue-en.json'), true);
        $japaneseCatalogue = json_decode(file_get_contents(__DIR__ . '/catalogue-ja.json'), true);

        $translator = new Translator($defaultCatalogue);
        $translator->setCatalogue('ja', $japaneseCatalogue);
        $translator->setCatalogue('en', $englishCatalogue);

        // no key to translate
        $message = $translator->translate('foo.bar');
        $this->assertSame($message, 'foo.bar');

        // output default catalogue translation, as no language is specified.
        $message = $translator->translate('delete.confirm');
        $this->assertSame($message, 'delete ok?');

        // set English to current language.
        $translator->setLanguage('en');
        $this->assertSame($translator->getLanguage(), 'en');
        $message = $translator->translate('user.name');
        $this->assertSame($message, 'User name');

        // replace placeholders
        $message1 = $translator->translate("hello.user", "alice");
        $message2 = $translator->translate("files.summary", 12114, "Macintosh HD");
        $this->assertSame($message1, 'Hello, alice');
        $this->assertSame($message2, 'The disk Macintosh HD contains 12114 file(s).');

        // output default catalogue translation, as there is no English translation for the key.
        $message = $translator->translate("delete.confirm");
        $this->assertSame($message, 'delete ok?');

        // set Japanese to current language.
        $translator->setLanguage('ja');
        $this->assertSame($translator->getLanguage(), 'ja');
        $message1 = $translator->translate("user.name");
        $message2 = $translator->translate("files.summary", 12114, "Macintosh HD");
        $this->assertSame($message1, 'ユーザ名');
        $this->assertSame($message2, 'ディスクMacintosh HDに12114個のファイル');
    }
} 