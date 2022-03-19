<?php

namespace Bank\UtilityClasses;

use InvalidArgumentException;

/**
 *General PHP methods to do with colour for the project to use
 */
class ColorUtilities
{
    public const INVALID_HEX_CODE_PASSED_MESSAGE = 'An invalid hex code has been passed. Bugging out!';

    /**
     * Get the contrasted color
     *
     * The initial version of this came from https://www.jonasjohn.de/snippets/php/color-inverse.htm,
     * but I threw in a few fail-safes
     *
     * @param string $startColor
     * @param string $case
     *
     * @return string
     */
    public static function contrastedColor(string $startColor, string $case = 'upper'): string
    {
        $startColor = str_replace('#', '', $startColor);

        if (3 === strlen($startColor)) {
            $startColor = self::duplicateChar($startColor);
        }

        if (6 !== strlen($startColor)) {
            throw new InvalidArgumentException(self::INVALID_HEX_CODE_PASSED_MESSAGE);
        }

        self::validateHexChar($startColor);

        $rgb = '';
        for ($x=0; $x<3; $x++) {
            $segment = 255 - hexdec(substr($startColor, (2*$x), 2));
            $segment = ($segment < 0) ? 0 : dechex($segment);
            $rgb .= (strlen($segment) < 2) ? '0'.$segment : $segment;
        }

        $case = strtolower($case);
        $correctCase = ('upper' === $case) ? strtoupper($rgb) : strtolower($rgb);

        return '#' . $correctCase;
    }

    /**
     * Convert a 3 character code to 6 characters
     *
     * @param string $char
     *
     * @return string
     */
    public static function duplicateChar(string $char): string
    {
        return str_repeat($char, 2);
    }

    /**
     * Make sure we have hex characters
     *
     * @param string $string
     *
     * @return void
     */
    public static function validateHexChar(string $string): void
    {
        $validChars = ['a','b','c','d','e','f','0','1','2','3','4','5','6','7','8','9'];
        $chars = str_split(strtolower($string));

        foreach ($chars as $char) {
            if (!in_array($char, $validChars)) {
                throw new InvalidArgumentException();
            }
        }
    }

    /**
     * Analyse the RGB components and decide between black or white contrasting colour
     *
     * @param string $hex
     *
     * @return string
     */
    public static function blackWhiteContrast(string $hex): string
    {
        $hexColor = str_replace('#', '', $hex);

        $red = hexdec(substr($hexColor, 0, 2));
        $green = hexdec(substr($hexColor, 2, 2));
        $blue = hexdec(substr($hexColor, 4, 2));
        $yiq = (($red*299)+($green*587)+($blue*114))/1000;

        return ($yiq >= 128) ? 'black' : 'white';
    }
}
