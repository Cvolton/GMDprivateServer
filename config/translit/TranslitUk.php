<?php

namespace ashtokalo\translit;

/**
 * Transliteration data for Ukrainian (UK)
 *
 * Data taken from http://en.wikipedia.org/wiki/Romanization_of_Ukrainian,
 * column "National".
 *
 * @author Alexey Shtokalo <alexey@shtokalo.net>
 */

class TranslitUk
{
    public $alphabet = array (
        // upper case
        'А' => 'A',     'Б' => 'B',     'В' => 'V',     'Г' => 'H',
        'ЗГ' => 'Zgh',  'Зг' => 'Zgh',  'Ґ' => 'G',     'Д' => 'D',
        'Е' => 'E',     'Є' => 'IE',    'Ж' => 'Zh',    'З' => 'Z',
        'И' => 'Y',     'І' => 'I',     'Ї' => 'I',     'Й' => 'I',
        'К' => 'K',     'Л' => 'L',     'М' => 'M',     'Н' => 'N',
        'О' => 'O',     'П' => 'P',     'Р' => 'R',     'С' => 'S',
        'Т' => 'T',     'У' => 'U',     'Ф' => 'F',     'Х' => 'Kh',
        'Ц' => 'Ts',    'Ч' => 'Ch',    'Ш' => 'Sh',    'Щ' => 'Shch',
        'Ь' => '',      'Ю' => 'Iu',    'Я' => 'Ia',    '’' => '',
        // lower case
        'а' => 'a',     'б' => 'b',     'в' => 'v',     'г' => 'h',
        'зг' => 'zgh',  'ґ' => 'g',     'д' => 'd',     'е' => 'e',
        'є' => 'ie',    'ж' => 'zh',    'з' => 'z',     'и' => 'y',
        'і' => 'i',     'ї' => 'i',     'й' => 'i',     'к' => 'k',
        'л' => 'l',     'м' => 'm',     'н' => 'n',     'о' => 'o',
        'п' => 'p',     'р' => 'r',     'с' => 's',     'т' => 't',
        'у' => 'u',     'ф' => 'f',     'х' => 'kh',    'ц' => 'ts',
        'ч' => 'ch',    'ш' => 'sh',    'щ' => 'shch',  'ь' => '',
        'ю' => 'iu',    'я' => 'ia',    '\'' => '',
    );

    public function convert($text)
    {
        return str_replace(
            array_keys($this->alphabet),
            array_values($this->alphabet),
            preg_replace(
                // use alternative variant at the beginning of a word
                array (
                    '/(?<=^|\s)Є/', '/(?<=^|\s)Ї/', '/(?<=^|\s)Й/',
                    '/(?<=^|\s)Ю/', '/(?<=^|\s)Я/', '/(?<=^|\s)є/',
                    '/(?<=^|\s)ї/', '/(?<=^|\s)й/', '/(?<=^|\s)ю/',
                    '/(?<=^|\s)я/',
                ),
                array (
                    'Ye', 'Yi', 'Y', 'Yu', 'Ya', 'ye', 'yi', 'y', 'yu', 'ya',
                ),
                $text)
        );
    }
}
