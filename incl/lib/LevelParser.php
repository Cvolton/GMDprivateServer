<?php

class LevelParser {
    public $data = [];

    public function __construct($levelString)
    {
        $this->data = self::map($levelString, ':');
    }

    /**
     * Convert GD's weird "keyed" array strings to dictionary. Works with out-of-order keys.
     *
     * @param $list string
     * @param $separator string
     * @return array
     */
    public static function map($list, $separator) {
        $bits = explode($separator, $list);
        $array = [];
        for ($i = 1; $i < count($bits); $i += 2) {
            $array[$bits[$i - 1]] = $bits[$i];
        }
        return $array;
    }

    /**
     * Flatten dictionary to single delimited string
     *
     * @param $dict array|object
     * @param $separator string
     * @return string
     */
    public static function demap($dict, $separator) {
        $string = '';
        foreach ($dict as $key => $value) {
            $string[] .= "${separator}${key}${separator}${value}";
        }
        return $string;
    }

    /**
     * @param $string string
     * @return false|string
     */
    public static function base64_urlencode($string) {
        return base64_encode(strtr($string, '+/', '-_'));
    }

    /**
     * @param $string string
     * @return false|string
     */
    public static function base64_urldecode($string) {
        return base64_decode(strtr($string, '-_', '+/'), true);
    }

    /**
     * Validates level data for various things (currently only ACE exploit)
     *
     * @return bool
     */
    public function validate() {
        // Ocular Miracle ain't happening
        $max_level_size = 50 * 1024 * 1024; // 50 MB Max uncompressed size
        $objs = explode(';', zlib_decode(self::base64_urldecode($this->data[4]), $max_level_size));
        // Skip level header
        for ($i = 1; $i < 2; $i++) {
            $obj = self::map($objs[$i], ',');
            // Check for pickup trigger exploit
            if ($obj[1] == 1817) {
                $id = intval($obj[80]);
                if ($id > 1099 || $id < 0) return false;
            }
        }

        return true;
    }
}