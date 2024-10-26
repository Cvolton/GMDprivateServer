<?php

namespace ashtokalo\translit;

/**
 * Transliteration data for Belarusian (BE)
 *
 * Data taken from http://en.wikipedia.org/wiki/Romanization_of_Belarusian,
 * column "National 2007".
 *
 * @author Alexey Shtokalo <alexey@shtokalo.net>
 */

class TranslitBe
{
    public $alphabet = array (
        // upper case
        'А' => 'A',     'Б' => 'B',     'В' => 'V',     'Г' => 'H',
        'Д' => 'D',     'ДЖ' => 'Dž',   'ДЗ' => 'Dz',   'Е' => 'Ie',
        'Ё' => 'Io',    'Ж' => 'Ž',     'З' => 'Z',     'І' => 'I',
        'Й' => 'J',     'К' => 'K',     'Л' => 'L',     'М' => 'M',
        'Н' => 'N',     'О' => 'O',     'П' => 'P',     'Р' => 'R',
        'СЬ' => 'Ś',    'С' => 'S',     'Т' => 'T',     'У' => 'U',
        'Ў' => 'Ǔ',     'Ф' => 'F',     'Х' => 'Ch',    'Ц' => 'C',
        'Ч' => 'Č',     'Ш' => 'Š',     'Ы' => 'Y',     'Ь' => '\'',
        'Э' => 'E',     'Ю' => 'Iu',    'Я' => 'Ia',    '’' => '',
        // lower case
        'а' => 'a',     'б' => 'b',     'в' => 'v',     'г' => 'h',
        'д' => 'd',     'дж' => 'dž',   'дз' => 'dz',   'е' => 'ie',
        'ё' => 'io',    'ж' => 'ž',     'з' => 'z',     'і' => 'i',
        'й' => 'j',     'к' => 'k',     'л' => 'l',     'м' => 'm',
        'н' => 'n',     'о' => 'o',     'п' => 'p',     'р' => 'r',
        'сь' => 'ś',    'с' => 's',     'т' => 't',     'у' => 'u',
        'ў' => 'ǔ',     'ф' => 'f',     'х' => 'ch',    'ц' => 'c',
        'ч' => 'č',     'ш' => 'š',     'ы' => 'y',     'ь' => '\'',
        'э' => 'e',     'ю' => 'iu',    'я' => 'ia',    '\'' => '',
    );

    public function convert($text)
    {
        $sRe = '/(?<=^|\s|\'|’|[IЭЫAУО])';
        return str_replace(
            array_keys($this->alphabet),
            array_values($this->alphabet),
            preg_replace(
                // For е, ё, ю, я, the digraphs je, jo, ju, ja are used
                // word-initially, and after a vowel, apostrophe (’),
                // separating ь, or ў.
                array (
                    $sRe . 'Е/i', $sRe . 'Ё/i', $sRe . 'Ю/i', $sRe . 'Я/i',
                    $sRe . 'е/i', $sRe . 'ё/i', $sRe . 'ю/i', $sRe . 'я/i',
                ),
                array (
                    'Je', 'Jo', 'Ju', 'Ja', 'je', 'jo', 'ju', 'ja',
                ),
                $text)
        );
    }
}
