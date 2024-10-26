<?php

/**
 * Converts characters by using all available rules, except latin and ascii.
 *
 * This table could be used to have guaranty that all known characters were
 * transliterated. Unfortunatelly it does not cover all UNICODE characters :(
 *
 * @package translit
 * @author  Alexey Shtokalo <alexey@shtokalo.net>
 */

return array_merge(
    include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cyrillic.php'),
    include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'el.php'),
    include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'hy.php'),
    include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'kk.php'),
    include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mk.php'));
