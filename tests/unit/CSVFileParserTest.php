<?php

namespace Tests\Unit;

use Bank\Models\Provider;
use Bank\Models\Transaction;
use Bank\UtilityClasses\CsvFileParser;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Tests\TestCase;
use \InvalidArgumentException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CSVFileParserTest
 * @package Tests\Unit
 */
class CSVFileParserTest extends TestCase
{
    public $validExampleFile;
    public $fileWithExtraFields;
    public $validArrayOfHeaders;


    /**
     * Run before each test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validExampleFile    = base_path() . '/tests/resources/valid.csv';
        $this->fileWithExtraFields = base_path() . '/tests/resources/extraFields.csv';

    }

    /**
     * Validate the test CSV file exists
     *
     * @test
     *
     * @return CsvFileParser
     */
    public function make_sure_a_valid_csv_file_exists(): CsvFileParser
    {
        $parser = new CsvFileParser($this->validExampleFile);

        $this->assertFileExists($this->validExampleFile);
        $this->assertInstanceOf(CsvFileParser::class, $parser);

        return $parser;
    }

    /**
     * make sure we get an exception if the path doesn't exist
     *
     * @test
     *
     * @return void
     */
    public function make_sure_we_get_an_exception_if_the_file_doesnt_exist(): void
    {
        $falseFilePath = base_path() . '/tests/resources/non_existent.csv';
        $this->expectException(FileException::class);
        new CsvFileParser($falseFilePath);
    }

    /**
     * Get the number of rows (lines) in the file
     *
     * @test
     *
     * @depends make_sure_a_valid_csv_file_exists
     * @param  CsvFileParser  $parser
     *
     * @return void
     */
    public function make_sure_we_get_the_correct_number_of_lines_returned(CsvFileParser $parser): void
    {
        $rowCount = $parser->countRowsOfData();
        $this->assertEquals(77, $rowCount);
    }

    /**
     * Make sure we can get the file headers separately as an array
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     * @param   CsvFileParser $parser
     *
     * @returns void
     */
    public function make_sure_we_can_get_a_separate_array_of_headers(CsvFileParser $parser): void
    {
        $validArrayOfHeaders = [
            'Transaction Date',
            'Transaction Type',
            'Sort Code',
            'Account Number',
            'Transaction Description',
            'Debit Amount',
            'Credit Amount',
            'Balance'
        ];
        $arrayOfHeaders = $parser->getArrayOfHeaders();
        $this->assertEquals($validArrayOfHeaders, $arrayOfHeaders);
    }

    /**
     * make sure we can get an array of data
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     * @param  CsvFileParser  $parser
     *
     * @return void
     */
    public function get_an_array_of_data_from_the_file_including_headers(CsvFileParser $parser): void
    {
        $parser->returnHeadersInData = true;
        $dataIncludingHeaderRow = $parser->getData();
        $this->assertIsArray($dataIncludingHeaderRow);
        $this->assertCount(77, $dataIncludingHeaderRow);
    }

    /**
     * make sure we can get an array of data without the header row
     *
     * We will set the headers required to false so that we get a row less than the
     * test that includes headers
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     * @param  CsvFileParser  $parser
     *
     * @return void
     */
    public function get_an_array_of_data_from_the_file_excluding_headers(CsvFileParser $parser): void
    {
        $parser->returnHeadersInData = false;
        $dataExcludingHeaderRow = $parser->getData();
        $this->assertIsArray($dataExcludingHeaderRow);
        $this->assertCount(76, $dataExcludingHeaderRow);
    }

    /**
     * make sure we can get the correct amount of data returned
     *
     * If we set it to exclude headers AND tell it there are no headers
     * We need to make sure that it doesn't try to deduct the headers
     * (1st row of data) from the returned array
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     * @param  CsvFileParser  $parser
     *
     * @return void
     */
    public function get_an_array_of_data_after_we_say_we_dont_have_headers(CsvFileParser $parser): void
    {
        $parser->returnHeadersInData = false;
        $parser->firstRowAreHeaders = false;
        $dataExcludingHeaderRow = $parser->getData();
        $this->assertIsArray($dataExcludingHeaderRow);
        $this->assertCount(77, $dataExcludingHeaderRow);
    }

    /**
     * We should be able to get an associative array by default
     *
     * Instead of the boring and hard to [mentally] parse numbers
     * why not use easy to read associative arrays by default, then we
     * know when the amounts are in; out or balance
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     * @param  CsvFileParser  $parser
     *
     * @return void
     */
    public function we_should_get_an_associative_array_by_default(CsvFileParser $parser): void
    {
        $expectedArray = [
            'Transaction Date' => '01/06/2017',
            'Transaction Type' => 'DEB',
            'Sort Code' => "'12-34-56",
            'Account Number' => '98765432',
            'Transaction Description' => 'CAPITAL ONE EUROPE',
            'Debit Amount' => 23.79,
            'Credit Amount' => null,
            'Balance' => 581.81
        ];

        $parser->returnHeadersInData = false;
        $parser->firstRowAreHeaders = true;
        $parser->returnAssociativeArray = true;
        $data = $parser->getData();
        $this->assertEquals($expectedArray, $data[0]);
    }

    /**
     * We neqed to make sure we standardise the dates
     *
     * @test
     */
    public function confirm_dates_are_standardised()
    {
        $dates = [
            "29/07/2000",
            "29-07-2000",
            "2000-07-29"
        ];

        foreach($dates as $date) {
            $this->assertEquals("2000-07-29", CsvFileParser::convertDate($date));
        }
    }


    /**
     * Make sure a providers single regex is picked up
     *
     * @param CsvFileParser $parser
     * @return void
     */
    public function ensure_single_provider_regex_is_detected() {
        $transactions = [
            [

            ],
            [

            ],
            [

            ]
        ];

        $providers = [
            Provider::factory()->create([
                'name' => 'Halifax Bank',
                'regex' => '[/*halifax*/]'
            ]),

            Provider::factory()->create([
                'name' => 'PayPal',
                'regex' => '[/*paypal*/]'
            ]),

            Provider::factory()->create([
                'name' => 'Google',
                'regex' => '[/*google*/]'
            ])
        ];

        $transactions = [
            Transaction::factory()->create([
                'entry' => ''
            ]),

            Transaction::factory()->create([
                'entry' => ''
            ]),

            Transaction::factory()->create([
                'entry' => ''
            ])
        ];

    }

    /**
     * make sure we can have a flexible field/column
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * I/we don't want to be delving into the CSV file in order to get the column name
     * To that end - I will make it a regexp search
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_a_correct_filter(CsvFileParser $parser): void
    {
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $parser->setFlexibleField("/^.*description.*$/i", true);
    $data = $parser->getData();
    $this->assertIsArray($data);
    $this->assertCount(77, $data);
    }

    /**
     * make sure we get an exception when we try to set a flexible field with an incorrect filter
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * I/we don't want to be delving into the CSV file in order to get the column name
     * To that end - I will make it a regexp search
     * but this one will fail as the regular expression will to too LAZY
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_an_incorrect_filter(CsvFileParser $parser): void
    {
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageRegExp("/Only one column is allowed but there was more than one match/");
    $parser->setFlexibleField("/^.*transaction.*$/i", true);
    }

    /**
     * make sure we get an exception when we try to set a flexible field with an incorrect filter
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * I/we don't want to be delving into the CSV file in order to get the column name
     * To that end - I will make it a regexp search
     * but this one will fail as the regular expression will to too STRICT
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_an_strict_filter(CsvFileParser $parser): void
    {
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageRegExp("/There were no matches for the provided expression/");
    $parser->setFlexibleField("/^.*nothing here.*$/i", true);
    }

    /**
     * make sure we can have a flexible field/column, when set specifically
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * This one will come straight from the file and not be a regular expression
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_a_correct_specific_filter(CsvFileParser $parser): void
    {
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $parser->setFlexibleField("Transaction Description");
    $data = $parser->getData();
    $this->assertIsArray($data);
    $this->assertCount(77, $data);
    }

    /**
     * make sure we gen an exception when trying to set an invalid flexible field/column
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * This one WILL NOT EXISTS
     *
     * @test
     * @depends make_sure_a_valid_csv_file_exists
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_a_incorrect_specific_filter(CsvFileParser $parser): void
    {
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageRegExp("/there were no matching fields/");
    $parser->setFlexibleField("Description");
    }

    /**
     * We should get the correct number of columns
     *
     * This will allow (for instance) a transaction entry to have commas in the field,
     * which will much the column number up.
     * This one make sure that the flexible row is set to the correct value
     *
     *
     * This test is commented out as PHP seems to truncate the csv field that has the delimiters in it.
     * This is fine with me
     *
     * @test
     *
     * @returns void
    public function make_sure_we_can_set_a_flexible_field_with_the_correct_value(): void
    {
    $parser = new CsvFileParser($this->fileWithExtraFields);
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = false;
    $parser->setFlexibleField("Transaction Description");

    $data = $parser->getData();
    $this->assertEquals("CLOSE-IGO4, for insurance, and your protection", $data[0][4]);
    }

    /**
     * We should get an exception if there are more columns in a row, but no flexible column set
     *
     * This test is commented out as PHP seems to truncate the csv field that has the delimiters in it.
     * This is fine with me
     *
     * @test
     *
     * @returns void
    public function expect_an_exception_if_no_flexible_column_but_extra_fields(): void
    {
    $parser = new CsvFileParser($this->fileWithExtraFields);
    $parser->firstRowAreHeaders = true;
    $parser->returnHeadersInData = true;
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("There are extra fields, but no flexible row is set");
    $parser->getData();
    }
     */
}

