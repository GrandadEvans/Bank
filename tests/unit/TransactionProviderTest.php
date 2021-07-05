<?php

namespace Tests\Unit;

use Bank\Models\Provider;
use Bank\Models\Transaction;
use Bank\UtilityClasses\CsvFileParser;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use stdClass;
use UnitTester;

/**
 * Class TransactionProviderTest
 * @package Tests\Unit
 */
class TransactionProviderTest extends TestCase
{
    protected $single_providers_with_slashes = [];
    protected $single_providers_with_no_slashes = [];
    protected $all_providers = [];

    public function setUp() : void
    {
        parent::setUp();
        $provider1 = new stdClass;
        $provider1->id = 1;
        $provider1->regular_expression = '
            /google/i
        ';

        $provider2 = new stdClass;
        $provider2->id = 2;
        $provider2->regular_expression = '
            /halifax/i
            /tmpp/i
        ';

        $provider3 = new stdClass;
        $provider3->id = 3;
        $provider3->regular_expression = '
            /denplan/
        ';

        $provider4 = new stdClass;
        $provider4->id = 4;
        $provider4->regular_expression = '
            /denplan/
        ';

        $provider5 = new stdClass;
        $provider5->id = 5;
        $provider5->regular_expression = '
            google
        ';

        $provider6 = new stdClass;
        $provider6->id = 6;
        $provider6->regular_expression = '
            halifax
            tmpp
        ';

        $this->single_providers_with_slashes = [
            $provider1,
            $provider2,
            $provider3
        ];

        $this->single_providers_with_no_slashes = [
            $provider4,
            $provider5,
            $provider6
        ];

    }

    /**
     * Tests
     * =====
     *
     * we can get an array of ids and regular expressions from a list of providers
     *
     * transaction should be able to match the following regular expressions:
     *     an array with a single regex (with slashes)
     *     an array with a single regex (with NO slashes)
     *     an array with multiple regular expressions in it
     *     a single regex
     *     all of the above with or without the surrounding boundary slashes
     */

     /**
      * Match a single entry where the user has provided slashes around the regular expression
      *
      * @test
      *
      * @return void
      */
    public function match_a_single_regex_entry_with_slashes() {
        $transaction = new stdClass();
        $transaction->id = 1;
        $transaction->entry = 'A Google Transaction';
        $transaction = [ $transaction ];

        $provider = new stdClass;
        $provider->id = 2;
        $provider->name = 'Provider Name 1';
        $provider->logo = 'https://google.com/logo.jpg';
        $provider->remarks = 'Remarks text 1';
        $provider->regular_expressions = '
            /google/i
        ';
        $provider = collect([ $provider ]);

        // Get the results to verify against
        $results = CsvFileParser::getTransactionsProviders('A Google Transaction', $provider);

        $this->assertIsIterable($results);

        // There should only be a single result
        $this->assertCount(1, $results);

        // The transaction_id should be null
        $this->assertNull($results[0]['transaction_id']);

        return $results;
    }

     /**
      * Match a single entry where the user has NOT provided slashes around the regular expression
      *
      * @expected
      * @test
      *
      * @return void
      */
    public function match_a_single_regular_expression_entry_with_no_slashes() {
        $provider = new stdClass;
        $provider->id = 2;
        $provider->name = 'Provider Name 2';
        $provider->logo = 'https://google.com/logo.png';
        $provider->remarks = 'Remarks text 2';
        $provider->regular_expressions = '
            google
        ';
        $provider = collect([ $provider ]);

        $results = CsvFileParser::getTransactionsProviders('A Google Transaction', $provider);
        $this->assertIsIterable($results);
        $this->assertCount(1, $results);
        $this->assertNull($results[0]['transaction_id']);
    }

}

