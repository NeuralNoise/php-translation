<?php

namespace ShouldBee\Translation;

class Translator
{
    /**
     * @var string[]
     */
    private $catalogues = [];

    /**
     * @var string[]
     */
    private $defaultCatalogue = [];

    /**
     * @var string
     */
    private $language;

    /**
     * @param string[] $defaultCatalogue
     */
    public function __construct(array $defaultCatalogue)
    {
        $this->defaultCatalogue = $defaultCatalogue;
    }

    /**
     * @param string $language
     * @param string[] $catalogue
     */
    public function setCatalogue($language, array $catalogue)
    {
        $this->catalogues[$language] = $catalogue;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param string $key
     * @param string ... $value
     * @return string
     */
    public function translate($key, $value = null)
    {
        if (
            array_key_exists($this->language, $this->catalogues)
            and array_key_exists($key, $this->catalogues[$this->language])
        ) {
            $message = $this->catalogues[$this->language][$key];
        } elseif (array_key_exists($key, $this->defaultCatalogue) === true) {
            // default fallback
            $message = $this->defaultCatalogue[$key];
        } else {
            // can't translate
            return $key;
        }

        if (func_num_args() == 1) {
            return $message;
        }

        $params = array_slice(func_get_args(), 1);

        foreach ($params as $i => $param) {
            $message = str_replace('{' . $i . '}', $param, $message);
        }

        return $message;
    }
}
