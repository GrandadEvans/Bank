<?php

use Bank\Models\BaseModel;
use Bank\Models\PaymentMethod;
use Bank\Models\Transaction;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TransactionEditCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    private $selectedRegular;
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
        Transaction::factory()->create(['user_id' => 1]);
        $this->selectedTransaction = [
            'user_id' => 1,
            'date' => '2015-12-31',
            'entry' => 'A Test Description',
            'amount' => '-12.99',
            'balance' => '1234.99',
            'payment_method_id' => '1'
        ];
        Transaction::factory()->create($this->selectedTransaction);
        Transaction::factory()->create(['user_id' => 1]);
    }

    /**
     * We should not be able to edit a transaction we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_transaction_to_edit_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('transactions', $I);
        $I->amOnRoute('transactions.edit', [1]);
        $I->seeResponseCodeIs(401);
    }

    /**
     * We should not be able to update a transaction we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_transaction_to_update_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('transactions', $I);
        $I->amOnRoute('transactions.update', [1]);
        $I->seeResponseCodeIs(401);
    }

    /**
     * @param  FunctionalTester  $I
     *
     * @test
     */
    public function when_we_click_update_we_can_updated_transaction_values(FunctionalTester $I)
    {

        $editedValues = [
            'date' => '2020-01-01',
            'entry' => 'A different entry',
            'amount' => '99.99',
            'balance' => '987.59',
            'payment_method_id' => '3'
        ];

        $I->amOnRoute('transactions.edit', [2]);
        $I->fillField('date', $editedValues['date']);
        $I->fillField('entry', $editedValues['entry']);
        $I->fillField('amount', $editedValues['amount']);
        $I->fillField('balance', $editedValues['balance']);
        $I->selectOption('payment_method_id', $editedValues['payment_method_id']);
        $I->click('Update Transaction');
        $I->seeCurrentRouteIs('transactions.index');
        $I->amOnRoute('transactions.edit', [2]);
//        $I->see($editedValues['date']));
        $I->seeInField('entry', $editedValues['entry']);
        $I->seeInField('amount', $editedValues['amount']);
        $I->seeInField('balance', $editedValues['balance']);
        $I->seeOptionIsSelected('payment_method_id', PaymentMethod::find($editedValues['payment_method_id'])->method);
    }

}
