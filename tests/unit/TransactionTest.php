<?php

namespace Tests\Unit;

use Bank\Models\Transaction;
use Tests\TestCase;

/**
 * Class TransactionTest
 * @package Tests\Unit
 */
class TransactionTest extends TestCase
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
     * We can create a single amount from a debit and credit
     *
     * @test
     */
    public function we_can_create_a_single_amount_from_a_debit_and_credit()
    {
        $start = 12.34;
        $debit = 56.48;
        $credit = 98.76;

        $result = ($start + $credit - $debit);
        $actual = Transaction::setAmount($credit, $debit, $start);

        $this->assertEquals($result, $actual);
    }
}

