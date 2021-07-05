<?php

use Bank\BaseModel;
use Bank\Transaction;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class TransactionDeleteCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    private $selectedTransaction;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->callArtisan('db:seed --class PaymentMethodSeeder');
        $I->callArtisan('db:seed --class ProviderSeeder');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        Transaction::factory()->create();
        $this->selectedTransaction = [
            'date' => '2015-12-31',
            'entry' => 'A Test Description',
            'type' => 'DD',
            'amount' => '-12.99',
            'balance' => '1526.79',
            'remarks' => 'test remarks'
        ];
        Transaction::factory()->create($this->selectedTransaction);
        Transaction::factory()->create();
    }

     /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_delete_a_transaction(FunctionalTester $I)
    {
        $I->seeNumRecords(3, 'transactions');
        $I->amOnPage('/transactions');
        $I->see($this->selectedTransaction['entry']);
        $I->click('#delete-form-button-2');
        $I->cantSee($this->selectedTransaction['entry']);
        $I->seeNumRecords(2, 'transactions');
        $I->seeCurrentRouteIs('transactions.index');
    }

    /**
     * We should not be able to delete a transaction we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_transaction_to_delete_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('transactions', $I);
        $I->amOnRoute('transactions.delete', [1]);
        $I->see('This is not your transaction to delete');
    }

}
