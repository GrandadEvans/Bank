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
     * Make sure we can see the Providers.create link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_link_to_add_a_new_provider(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Add Provider');
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
        $I->click('Add Provider');
        $I->canSeeCurrentRouteIs('providers.create');
    }


    /**
     ***************************************************
     *                  TRANSACTIONS
     ***************************************************
     */

    /**
     * Make sure we can see the Transactions.create link before we begin
     *
     * @param FunctionalTester $I
     * @return void
     */
    public function we_see_the_link_to_add_a_new_transaction(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Add Transaction');
    }

    /**
     * Make sure clicking the Transactions.create link takes us to the correct page
     *
     * @param  FunctionalTester  $I
     * @return void
     */
    public function make_sure_the_link_to_add_a_new_transaction_works(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Add Transaction');
        $I->canSeeCurrentRouteIs('transactions.create');
    }


    /**
     ***************************************************
     *                  TAGS
     ***************************************************
     */

    /**
     * Make sure we can see the Tags.create link before we begin
     *
     * @param  FunctionalTester  $I
     * @return void
     */
    public function we_see_the_link_to_add_a_new_tag(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeLink('Add Tag');
    }

    /**
     * Make sure clicking the Tags.create link takes us to the correct page
     *
     * @param  FunctionalTester  $I
     * @return void
     */
    public function make_sure_the_link_to_add_a_new_tag_works(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->click('Add Tag');
        $I->canSeeCurrentRouteIs('tags.create');
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
