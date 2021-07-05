<?php

namespace Tests\Unit;

use Bank\Models\Tag;
use Bank\UtilityClasses\ColorUtilities;
use InvalidArgumentException;
use Tests\TestCase;

/**
 * Class ColorUtilitiesTest
 * @package Tests\Unit
 */
class ColorUtilitiesTest extends TestCase
{
    /**
     * Run before each test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * We can convert mysql dates such as 2019-06-13 to a format such as Thu, 13 Jun 2019
     *
     * @test
     */
    public function we_can_can_a_contrasted_color(): void
    {
        $startColor = '#000000';
        $expectedResult = '#FFFFFF';

        $actualResult = ColorUtilities::getContrastedColor($startColor);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * We should be able to specify what case we want the color in
     *
     * @test
     */
    public function we_should_be_able_to_specify_what_case_we_want_the_color_in(): void
    {
        $lowerCaseWhite = ColorUtilities::getContrastedColor('#000000', 'lower');
        $this->assertEquals('#ffffff', $lowerCaseWhite);

        $upperCaseWhite = ColorUtilities::getContrastedColor('#000000', 'upper');
        $this->assertEquals('#FFFFFF', $upperCaseWhite);

        $lowerCaseWhite = ColorUtilities::getContrastedColor('#000000', 'LOWER');
        $this->assertEquals('#ffffff', $lowerCaseWhite);

        $upperCaseWhite = ColorUtilities::getContrastedColor('#000000', 'UPPER');
        $this->assertEquals('#FFFFFF', $upperCaseWhite);

        $upperCaseByDefault = ColorUtilities::getContrastedColor('#000000');
        $this->assertEquals('#FFFFFF', $upperCaseByDefault);
    }

    /**
     * We should be able to pass in 3 characters and assume they are going to be duplicated
     *
     * @test
     */
    public function we_can_pass_in_just_three_character_color(): void
    {
        $startColor = '#fff';
        $expected = '#000000';
        $actual = ColorUtilities::getContrastedColor($startColor);

        $this->assertEquals($expected, $actual);
    }

    /**
     * We should only be able to pass in 3 or 6 character hex codes
     *
     * @test
     */
    public function we_should_detect_invalid_amounts_of_characters(): void
    {
        $shortCode = '#000';
        $longCode  = '#000000';
        $expected = '#FFFFFF';
        $invalidCode = '#00';

        $this->assertEquals($expected, ColorUtilities::getContrastedColor($shortCode));
        $this->assertEquals($expected, ColorUtilities::getContrastedColor($longCode));

        $this->expectException(InvalidArgumentException::class);
        ColorUtilities::getContrastedColor($invalidCode);
    }

    /**
     * We should detect invalid characters
     *
     * @test
     */
    public function we_should_detect_non_hex_characters(): void
    {
        $valid = ['1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f'];
        $invalid = ['g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

        foreach($valid as $char) {
            $fullString = str_repeat($char, 6);
            $this->assertIsString(ColorUtilities::getContrastedColor($fullString));
        }

        foreach($invalid as $char) {
            $fullString = str_repeat($char, 6);
            $this->expectException(InvalidArgumentException::class);
            ColorUtilities::getContrastedColor($fullString);
        }
    }

    /**
     * The font color for the model should be the inverse of the background color of the tag
     *
     * @test
     */
    public function font_colour_should_contrast_background_color(): void
    {
        $tag = new Tag([
            'tag' => 'randomTagName',
            'default_color' => '#000000',
            'created_by_user_id' => 1
        ]);
        $this->assertEquals('white', $tag->contrasted_tag_color);
    }

}

