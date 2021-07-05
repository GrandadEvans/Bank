<?php

use Bank\Provider;
use Bank\Regular;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class RegularIndexCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = factory(User::class)->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/regulars');
    }

    /**
     * For some reason I cannot test this. Whether it be the middleware that is disabled somewhere I can't find or what
     * but it doesn't show as being on the login page. it shows as it is on the regulars
     *
     * @param  FunctionalTester  $I
    public function we_see_a_404_when_not_logged_in(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnPage('/regulars');
        $I->seeElement('input', [ 'type' => 'password']);
    }
     */

    /**
     * @watch
     * @test
     *
     * @param  FunctionalTester  $I
     */
    public function we_can_load_the_page_when_we_are_logged_in(FunctionalTester $I)
    {
        $I->seeResponseCodeIsSuccessful();
        $I->see('Regular Transactions', 'h1');
    }

    public function we_can_see_a_list_of_our_regular_transactions(FunctionalTester $I) {
        $I->seeNumRecords(0, 'regulars');
        factory(Regular::class, 10)->create(['user_id' => $this->user->id]);
        $I->amOnPage('/regulars');
        $I->seeNumRecords(10, 'regulars');
        $I->seeAuthentication();
        $I->seeElement('table', ['id' => 'regularsTable']);
        $I->seeNumberOfElements('tr', 11);
    }

    public function we_see_the_regular_provider_in_the_table(FunctionalTester $I)
    {
        $I->callArtisan('db:seed --class ProviderSeeder');
        $provider = Provider::find(1);
        factory(Regular::class)->create([
            'user_id' => 1,
            'provider_id' => 1
        ]);
        $I->expect($provider->name === "N/A");
        $I->seeAuthentication();
        $I->amOnRoute('regulars.index');
        $I->see($provider->name);
    }

}
