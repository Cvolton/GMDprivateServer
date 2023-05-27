<?php

/**
 * In the future use this class for level validation. Data or other parameters.
 */
class LevelParser {
    public $data = [];
    const MAX_GROUPS_21 = 1099;
    const MAX_GROUPS_22 = 9999;

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
    public static function unmap($dict, $separator) {
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

    public static function decodeAllB64($string) {
        // https://www.debugpointer.com/regex/regex-for-base64
        // In case of emergency break glass. This may work as an alternative due to lenient php function or very large level string
        // if (preg_match('/^(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{4}|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{2}={2})$/'. $string)) {
        if (base64_encode(base64_decode($string, true)) === $string) {

        }

        if (strpos('-') === false || strpos('_') === false) {

        }
    }

    /**
     * Validates level data for various things (currently only ACE exploit)
     *
     * @return bool
     */
    public static function validate($levelString, $version) {
        include '../../config/security.php';
        try {
            $data = $levelString;
            // Decode (strict mode) if falsy then
            $decoded = self::base64_urldecode($levelString);
            if ($decoded !== false) $data = $decoded;

            // Check for zlib magic
            if(substr($data, 0, 3) === "\x1b\x8b\x08") {
                $data = zlib_decode($data, $maxUncompressedLevelSize);
                if (!$data) {
                    return false;
                }
            }
            // Check if result invalid (any character outside ascii range). Better heuristic for detecting junk?
            if (preg_match('/[^\x20-\x7e]/', $data)) return false;
            $objs = explode(';', $data);
            // Skip level header
            for ($i = 1; $i < 2; $i++) {
                $obj = self::map($objs[$i], ',');
                // Clamp groups based on version
                if (array_key_exists(80, $obj)) {
                    $id = intval($obj[80]);
                    if ($id > ($version > 21 ? self::MAX_GROUPS_22 : self::MAX_GROUPS_21) || $id < 0) return false;
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}