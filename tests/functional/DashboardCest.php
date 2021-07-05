<?php

use Tests\functional\FunctionalTestBase;

class DashboardCest
{
    use FunctionalTestBase;

    public function _before(FunctionalTester $I)
    {
        $this->validUser = [
            'name' => 'John Doe',
            'email' => 'john@valid.com',
            'password' => 'password123'
        ];
        $this->login($I);
    }

    /**
     ***************************************************
     *                  PROVIDERS
     ***************************************************
     */

    /**
     * Make sure we can see the Providers link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_providers_link(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Providers');
    }

    /**
     * Make sure clicking the Providers link takes us to the Providers page
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function when_we_click_the_providers_link_we_see_the_providers_page(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Providers');
        $I->canSeeCurrentRouteIs('providers.index');
    }

    /**
     * Make sure we can see the Providers.create link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_link_to_add_a_new_provider(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Create Provider');
    }

    /**
     * Make sure clicking the Providers.create link takes us to the correct page
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function make_sure_the_link_to_add_a_new_provider_works(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Create Provider');
        $I->canSeeCurrentRouteIs('providers.create');
    }


    /**
     ***************************************************
     *                  TRANSACTIONS
     ***************************************************
     */

    /**
     * Make sure we can see the Transactions link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_transactions_link(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Transactions');
    }

    /**
     * Make sure clicking the Transactions link takes us to the Transactions page
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function when_we_click_the_transactions_link_we_see_the_transactions_page(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Transactions');
        $I->canSeeCurrentRouteIs('transactions.index');
    }

    /**
     * Make sure we can see the Transactions.create link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_link_to_add_a_new_transaction(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Create Transaction');
    }

    /**
     * Make sure clicking the Transactions.create link takes us to the correct page
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function make_sure_the_link_to_add_a_new_transaction_works(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Create Transaction');
        $I->canSeeCurrentRouteIs('transactions.create');
    }


    /**
     ***************************************************
     *                  IMPORT
     ***************************************************
     */

    /**
     * Make sure we can see the Import link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_import_link(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Import Transactions');
    }

    /**
     * Make sure clicking the Import link takes us to Import page
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function when_we_click_the_import_link_we_see_the_import_page(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Import Transactions');
        $I->canSeeCurrentRouteIs('transactions.import');
    }


}
