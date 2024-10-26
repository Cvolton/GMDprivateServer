<?php

namespace ashtokalo\translit;

use Exception;

/**
 * Translit
 *
 * Provide interface to transliterate text into Roman (Latin) characters. Class
 * could be used as singleton or object itself. It's delivered with a few
 * transliteration tables and classes:
 * - ru - Russian cyrillic chars,
 * - uk - Ukrainian cyrillic chars,
 * - be - Belarusian cyrillic chars (converted to latin with diacritical),
 * - bg - Bulgarian cyrillic chars (converted to latin with diacritical),
 * - kk - Kazakh cyrillic chars (converted to latin with diacritical),
 * - ka - Georgian chars,
 * - hy - Armenian chars (converted to latin with diacritical),
 * - el - Greek chars (converted to latin with diacritical),
 * - cyrillic - all cyrillic chars according to ISO 9:1995,
 * - latin - only latin chars without diacritical marks,
 * - ascii - ASCII chars only, other chars will be replaced with question mark.
 *
 * Language codes could be combined by comma to handle more cases, e.g.
 *
 *      echo Translit::object()->convert('Беларусь', 'be') . ' vs ' .
 *          Translit::object()->convert('Беларусь', 'be,latin');
 *
 * produce output:
 *
 *      Bielaruś vs Bielarus
 *
 * By default wrong language codes ignored. But this behavior could be
 * changed by using string mode for really required language code. Just put
 * exclamation mark before language code. For example:
 *
 *      // following code do nothing because handler ru_ru not defined
 *      echo Translit::object()->convert('Привет', 'ru_ru');
 *      // but next code fires Exception, because transliteration required
 *      echo Translit::object()->convert('Привет', '!ru_ru');
 *
 * @package translit
 * @version 0.1
 * @author  Alexey Shtokalo <alexey@shtokalo.net>
 */

class Translit
{
    /**
     * Path to directory with data files.
     *
     * @var string empty string by default assumes directory "data" located at
     * directory with current class
     */
    public $dataPath = '';

    /**
     * @var array list of classes used to transliterate language
     */
    public $classes = [
        'be' => TranslitBe::class,
        'ka' => TranslitKa::class,
        'uk' => TranslitUk::class,
        'ascii' => TranslitAscii::class,
    ];

    /**
     * Converts given text to the Roman (Latin) script.
     *
     * The method accept a few codes at once. In this case codes must be splited
     * by command and will be applied in order they noted. For example
     * 'ru,cyrillic,ascii' converts russian cyrillic chars, then all other
     * cyrillic chars and finally produce clean ascii without diacritical marks.
     *
     * @param string $text text to convert
     * @param $code $code language code or a few codes by comma
     *
     * @return string converted text
     * @throws Exception if handler not available or wrong (strict mode only)
     */
    public function convert(string $text, string $code): string
    {
        foreach (explode(',', $code) as $code)
        {
            $language = $this->getLanguage($code);

            if (is_object($language))
            {
                $text = $language->convert($text);
            }
            else if (is_array($language))
            {
                $text = str_replace($language['from'], $language['to'], $text);
            }
        }

        return $text;
    }

    /**
     * Returns Translit object, used to avoid global variables
     *
     * @param string $dataPath
     *
     * @return Translit
     */
    public static function object(string $dataPath = '')
    {
        static $object = null;

        if (!is_object($object))
        {
            $object = new Translit();
            if ($dataPath) $object->dataPath = $dataPath;
        }

        return $object;
    }

    public function __invoke()
    {
        print_r(func_get_args());
    }

    /**
     * Returns language handler - array or object.
     *
     * The object must have method convert. Array must have two sub arrays
     * identified by keys "from" and "to".
     *
     * @param string $code language code
     *
     * @return object|array
     *
     * @throws Exception if handler not available or wrong (strict mode only)
     */
    protected function getLanguage(string $code)
    {
        // all language codes prepended with exclamation mark really required
        $strict = false;
        if (strncmp($code, '!', 1) === 0)
        {
            $code = substr($code, 1);
            $strict = true;
        }

        if ($code && !isset($this->languages[$code]))
        {
            if (class_exists($className = isset($this->classes[$code]) ? $this->classes[$code] : ''))
            {
                $language = new $className;
                if (method_exists($language, 'convert'))
                {
                    if (property_exists($language, 'translit'))
                    {
                        $language->translit = $this;
                    }
                    $this->languages[$code] = $language;
                }
                else if ($strict)
                {
                    throw new Exception(
                        sprintf('class "%s" does not have convert() method',
                            $className));
                }
            }
            else if (file_exists($dataFile = $this->getDataPath() . $code . '.php'))
            {
                $language = include $dataFile;
                if (is_array($language))
                {
                    $this->languages[$code] = array (
                        'from' => array_keys($language),
                        'to' => array_values($language),
                    );
                }
                else if ($strict)
                {
                    throw new Exception(
                        sprintf('expected array with alphabet, but %s found',
                            gettype($language)));
                }
            }
            else if ($strict)
            {
                throw new Exception(
                    sprintf('language "%s" does not have handlers', $code));
            }
        }

        return @$this->languages[$code];
    }

    /**
     * Returns path to data directory
     *
     * @return string
     */
    protected function getDataPath(): string
    {
        if (!$this->dataPath)
        {
            $this->dataPath = __DIR__ . DIRECTORY_SEPARATOR .
                'data' . DIRECTORY_SEPARATOR;
        }

        return $this->dataPath;
    }

    /**
     * Cached language handlers, could be an associative array or object.
     *
     * The object must have method convert. Array must have two sub arrays
     * identified by keys "from" and "to".
     *
     * @var array
     */
    protected $languages = array ();
}