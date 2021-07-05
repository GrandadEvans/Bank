<?php

namespace Tests\Unit;

use Bank\Models\BaseModel;
use Bank\Models\Dates;
use Bank\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use Tests\TestCase;

/**
 * Class DatesTest
 * @package Tests\Unit
 */
class DatesTest extends TestCase
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
    public function we_can_convert_mysql_dates_to_a_standard_format_for_tables()
    {
        $mysqlDate = '2019-06-13';
        $tableDate = 'Thu, 13 Jun 2019';

        $result = Dates::formatDateForTable($mysqlDate);

        $this->assertEquals($tableDate, $result);
    }

    /**
     * We can convert Carbon dates to the correct format (Thu, 13 Jun 2019)
     *
     * @test
     */
    public function we_can_format_carbon_instances_to_a_standard_format_for_tables()
    {
        $carbonDate = new Carbon('2019-06-13');
        $tableDate = 'Thu, 13 Jun 2019';

        $result = Dates::formatDateForTable($carbonDate);

        $this->assertEquals($tableDate, $result);
    }

    /**
     * We should get false if we cannot format a date for out tables
     *
     * @test
     */
    public function we_should_have_false_returned_on_failure_to_format_date()
    {
        $falseDate = '13/06/2019';
        $result = Dates::formatDateForTable($falseDate);

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function we_can_convert_interval_shorthand_to_carbon_duration()
    {
        $days = [
            '3d' => '3 days',
            '5w' => '5 weeks',
            '2m' => '2 months',
            '3q' => '3 quarters',
            '2y' => '2 years',
            '1w' => '1 week'
        ];

        foreach($days as $short => $long) {
            $result = Dates::makeShortDurationReadable($short);
            $this->assertEquals($long, $result);
        }
    }


    /**
     * We can convert a British date into mysql format
     *
     * @test
     */
    public function we_can_convert_british_dates_to_mysql_format()
    {
        $britishDate = '31-12-2019';
        $convertedDate = Dates::convertBritishDateToMysql($britishDate);

        $this->assertEquals('2019-12-31', $convertedDate);
    }

    /**
     * As we are getting errors about it expecting a String and not an Object, lets fix it
     *
     * @test
     */
    public function we_should_be_able_to_pass_a_datetime_object_to_mysql_format()
    {
        $dateIn = new DateTime('2018-12-25');

        $result = Dates::convertBritishDateToMysql($dateIn);
        $this->assertEquals('2018-12-25', $result);
    }

}

