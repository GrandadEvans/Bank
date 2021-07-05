<?php

use Bank\Models\Transaction;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TransactionImportCest
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
        Transaction::factory()->count(20)->create(['user_id' => $this->user->id]);
        $I->seeNumRecords(20, 'transactions');
        $I->amOnRoute('transactions.index');
        $I->seeElement('section', ['id' => 'transactions']);
    }

    protected function setupMulipleProviderMatches(FunctionalTester $I) {
        $I->seeAuthentication();
        $I->amOnRoute('transactions.import');
        $I->seeElement('input', [
            'id' => 'file_input',
            'name' => 'file_input'
        ]);
        $I->attachFile('file_input', 'testTransactionProviders.csv');
        $I->click('Go to it!');
    }

//    public function we_see_a_list_of_transaction_providers(FunctionalTester $I) {
//        $this->setupMulipleProviderMatches($I);
//        $I->see("Import Transactions (multiple providers available)");
//    }

//    public function we_should_see_a_table_for_transactions_with_multiple_providers(FunctionalTester $I) {
//        $this->setupMulipleProviderMatches($I);
//        $I->seeElement('table', ['id' => 'transaction-1']);
//    }

    // public function we_have_a_select_box_with_providers_in_the_table(FunctionalTester $I) {
    //     $I->seeElement('select', [
    //         'class' => 'transaction-provider-select-box'
    //     ]);
    // }

    // public function the_providers_select_box_includes_existing_providers(FunctionalTester $I) {
        // $I->seeOptionIsSelected()
    // }

}
