<?php

namespace ShouldBee\Translation;


class Negotiation
{
    /**
     * @param string[] $availableLanguages
     * @return string
     */
    public static function negotiate(array $availableLanguages)
    {
        $language = $availableLanguages[0];
        $language = self::negotiateByAcceptLanguage($availableLanguages, $language);
        $language = self::negotiateByQueryString($availableLanguages, $language);
        $language = self::negotiateByCookie($availableLanguages, $language);

        return $language;
    }

    /**
     * @param string $language
     * @param string $cookieDomain
     */
    public static function remember($language, $cookieDomain = null)
    {
        setcookie('language', $language, strtotime('+1 year'), '/', $cookieDomain);
    }

    /**
     * @param array $languages
     * @param $defaultLanguage
     * @return int|string
     */
    private static function negotiateByAcceptLanguage(array $languages, $defaultLanguage)
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) === false){
            return $defaultLanguage;
        }

        $acceptLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($acceptLanguages as $acceptLanguageInfo) {
            $acceptLanguage = explode(';', $acceptLanguageInfo)[0];

            foreach ($languages as $language) {
                if (stripos($language, $acceptLanguage) === 0) {
                    return $language;
                }
            }
        }

        return $defaultLanguage;
    }

    /**
     * @param array $languages
     * @param string $defaultLanguage
     * @return string
     */
    private static function negotiateByQueryString(array $languages, $defaultLanguage)
    {
        if (isset($_GET['language']) === false) {
            return $defaultLanguage;
        }

        $parameterLanguage = strtolower($_GET['language']);

        if (in_array($parameterLanguage, $languages) === false) {
           return $defaultLanguage;
        }

        return $parameterLanguage;
    }

    /**
     * @param array $languages
     * @param string $defaultLanguage
     * @return string
     */
    private static function negotiateByCookie(array $languages, $defaultLanguage)
    {
        if (isset($_COOKIE['language']) === false) {
            return $defaultLanguage;
        }

        $cookieLanguage = strtolower($_COOKIE['language']);

        if (in_array($cookieLanguage, $languages) === false) {
            return $defaultLanguage;
        }

        return $cookieLanguage;
    }
}

