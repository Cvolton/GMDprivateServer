<?php

namespace ashtokalo\translit;

/**
 * Transliteration data to clean ASCII
 *
 * The class uses ICONV library to get clean ASCII text. All non-ascii
 * characters will be replaced with question mark or transliterated if possible.
 *
 * @package translit
 * @author  Alexey Shtokalo <alexey@shtokalo.net>
 */

class TranslitAscii
{
    public function convert($text)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    }
}