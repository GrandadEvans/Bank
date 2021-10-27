<?php

use Bank\Models\Provider;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class ProviderApiCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    /**
     * We should NOT be able to get a simple list of providers if we are logged out
     *
     * @param  FunctionalTester  $I
     */
    public function we_should_be_able_to_get_a_list_of_providers_if_not_logged_in(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->amOnRoute('providers.index');
        $this->seeLoginForm($I);
    }

    public function we_can_load_the_page_when_we_are_logged_in(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $I->amOnRoute('providers.index');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Product & service providers', 'h1');
    }

    public function we_can_see_a_list_of_providers(FunctionalTester $I) {
        $I->callArtisan('migrate:fresh --seed');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $I->amOnRoute('providers.index');
        $I->seeNumRecords(20, 'providers'); // ProviderSeeder contains 20 rows = 2 rows with dedicated attributes
        $I->amOnRoute('providers.index');
        $I->seeAuthentication();
        $I->seeElement('table', ['id' => 'providersTable']);
        $I->seeNumberOfElements('tr', 21);
    }

    public function we_see_the_provider_details_in_the_table(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh --seed');
//        $I->callArtisan('db:seed --class ProviderSeeder');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $provider = Provider::all()->first();
        Provider::factory()->create(['name' => 'Tesco Plc']);
        $I->expect($provider->name === "N/A");
        $I->amOnRoute('providers.index');
        $I->see($provider->name);
        $I->see('Tesco Plc');
    }

    public function we_can_eager_load_the_payment_methods(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh --seed');
        $all = Provider::all()->first()->toArray();
        $I->expect(6 === count($all['payment_method'])); // no additional call to payment_method attribute
    }

}
