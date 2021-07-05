<?php

namespace Bank\UtilityClasses;


use Exception;
use InvalidArgumentException;

class ColorUtilities
{
    const INVALID_HEX_CODE_PASSED_MESSAGE = 'An invalid hex code has been passed. Bugging out!';

    /**
     * Get the contrasted color
     *
     * The initial version of this came from https://www.jonasjohn.de/snippets/php/color-inverse.htm
     * but I threw in a few fail-safes
     *
     * @param string $startColor
     * @param string $case
     *
     * @return string
     */
    public static function getContrastedColor(string $startColor, string $case = 'upper'): string
    {
            $startColor = str_replace('#', '', $startColor);

            if (3 === strlen($startColor)) {
                $startColor = self::duplicateCharacters($startColor);
            }

            if (6 !== strlen($startColor)) {
                throw new InvalidArgumentException(self::INVALID_HEX_CODE_PASSED_MESSAGE);
            }

            self::validateHexCharacters($startColor);

            $rgb = '';
            for ($x=0;$x<3;$x++){
                $c = 255 - hexdec(substr($startColor,(2*$x),2));
                $c = ($c < 0) ? 0 : dechex($c);
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
            }

            $case = strtolower($case);
            $correctCase = ('upper' === $case) ? strtoupper($rgb) : strtolower($rgb);

            return '#' . $correctCase;
    }

    /**
     * Convert a 3 character code to 6 characters
     *
     * @param string $in
     *
     * @return string
     */
    public static function duplicateCharacters(string $in): string
    {
        return str_repeat($in, 2);
    }

    /**
     * Make sure we have hex characters
     *
     * @param string $string
     *
     * @return void
     */
    public static function validateHexCharacters(string $string): void
    {
        $validChars = ['a','b','c','d','e','f','0','1','2','3','4','5','6','7','8','9'];
        $chars = str_split(strtolower($string));

        foreach($chars as $char) {
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
    public static function getBlackOrWhiteForeground(string $hex): string
    {
        $hexcolor = str_replace('#', '', $hex);

        $r = hexdec(substr($hexcolor,0,2));
        $g = hexdec(substr($hexcolor,2,2));
        $b = hexdec(substr($hexcolor,4,2));
        $yiq = (($r*299)+($g*587)+($b*114))/1000;

        return ($yiq >= 128) ? 'black' : 'white';
    }
}
