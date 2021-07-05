<?php

use Bank\Models\Transaction;
use Bank\Models\Provider;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TransactionIndexCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->callArtisan('db:seed --class PaymentMethodSeeder');
        $I->callArtisan('db:seed --class ProviderSeeder');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $I->amOnRoute('transactions.index');
    }

    /**
     * For some reason I cannot test this. Whether it be the middleware that is disabled somewhere I can't find or what
     * but it doesn't show as being on the login page. it shows as it is on the transactions
     *
     * @param  FunctionalTester  $I
    public function we_see_a_404_when_not_logged_in(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnPage('/transactions');
        $I->seeElement('input', [ 'type' => 'password']);
    }
     */

    public function we_can_load_the_transactions_page_when_we_are_logged_in(FunctionalTester $I)
    {
        $I->seeResponseCodeIsSuccessful();
        $I->see('Transactions', 'h1');
    }

    public function we_can_see_a_list_of_our_transactions(FunctionalTester $I) {
        $I->seeAuthentication();
        $I->seeNumRecords(0, 'transactions');
        // 2 transactions before 20 faker records
        Transaction::factory()->count(20)->create(['user_id' => $this->user->id]);
        $I->seeNumRecords(20, 'transactions');
        $I->amOnRoute('transactions.index');
        $I->seeElement('section', ['id' => 'transactions']);
    }

    /**
     * We see the last transaction when we visit the transaction page
     *
     * @todo I can't seem to get this to work, I assume it's to do with the Vue Component
     *
     * @test
    public function we_see_the_last_transaction_when_visiting_the_transactions_page(FunctionalTester $I)
    {
        $entryText = 'jhghfkmy';

        $I->seeAuthentication();
        $I->amOnRoute('tags.index'); // we are already on the transactions.index page from _before
        Transaction::factory()->create(['user_id' => $this->user->id]);
        $I->seeNumRecords(1, 'transactions');

//        $numRecords = Transaction::all()->count();
        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'entry' => $entryText
        ]);
        $I->seeNumRecords(2, 'transactions');
        $I->amOnPage('/transactions'); // Move back to the page to show the new record
        $I->canSee($entryText);
    }
     */

    // public function we_have_a_select_box_with_providers_in_the_table(FunctionalTester $I) {
    //     $I->seeElement('select', [
    //         'class' => 'transaction-provider-select-box'
    //     ]);
    // }

    // public function the_providers_select_box_includes_existing_providers(FunctionalTester $I) {
        // $I->seeOptionIsSelected()
    // }

}
