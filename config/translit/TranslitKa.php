<?php

namespace ashtokalo\translit;

/**
 * Transliteration data for Georgian (KA)
 *
 * The class converts Georgian to latin chars according to data taken from
 * http://en.wikipedia.org/wiki/Georgian_national_system_of_romanization and
 * makes capital all first chars of sentences.
 *
 * @package translit
 * @author  Alexey Shtokalo <alexey@shtokalo.net>
 */
class TranslitKa
{
    protected $alphabet = array (
        'ა' => 'a',
        'ბ' => 'b',
        'გ' => 'g',
        'დ' => 'd',
        'ე' => 'e',
        'ვ' => 'v',
        'ზ' => 'z',
        'თ' => 't',
        'ი' => 'i',
        'კ' => 'k',
        'ლ' => 'l',
        'მ' => 'm',
        'ნ' => 'n',
        'ო' => 'o',
        'პ' => 'p\'',
        'ჟ' => 'zh',
        'რ' => 'r',
        'ს' => 's',
        'ტ' => 't\'',
        'უ' => 'u',
        'ფ' => 'p',
        'ქ' => 'k',
        'ღ' => 'gh',
        'ყ' => 'q\'',
        'შ' => 'sh',
        'ჩ' => 'ch',
        'ც' => 'ts',
        'ძ' => 'dz',
        'წ' => 'ts\'',
        'ჭ' => 'ch\'',
        'ხ' => 'kh',
        'ჯ' => 'j',
        'ჰ' => 'h',
    );

    public function convert($text)
    {
        return str_replace(
            array_keys($this->alphabet),
            array_values($this->alphabet),
            preg_replace_callback(
                // make capital from first chars of sentences
                '/(^|[\.\?\!]\s*)([a-z])/s',
                function ($m) {
                    return $m[1] . strtoupper($m[2]);
                },
                $text)
        );
    }
}
