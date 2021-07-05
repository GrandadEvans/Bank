<?php

use Bank\Models\BaseModel;
use Bank\Models\Provider;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class ProviderDeleteCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    private $selectedProvider;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->callArtisan('db:seed --class PaymentMethodSeeder');
        $I->amLoggedAs($this->user);
        Provider::factory()->create();
        $this->selectedProvider = [
            'name' => 'Tesco Plc',
            'remarks' => 'A Test Provider',
            'payment_method_id' => '1',
            'regular_expressions' => '\\^HALIFAX\.com.*$\\',
            'logo' => 'http://google.com'
        ];
        Provider::factory()->create($this->selectedProvider);
        Provider::factory()->create();
    }

     /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_delete_a_provider(FunctionalTester $I)
    {
        $I->seeNumRecords(3, 'providers');
        $I->amOnRoute('providers.index');
        $I->see($this->selectedProvider['name']);
        $I->click('#delete-form-button-2');
                $I->makeHtmlSnapshot();

        $I->cantSee($this->selectedProvider['name']);
        $I->seeNumRecords(2, 'providers');
        $I->seeCurrentRouteIs('providers.index');
    }

    /**
     * We should be logged in to delete a provider
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_delete_a_provider(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('providers.index');
        $this->seeLoginForm($I);
    }

    /**
     * But we can see the providers list when we are logged in
     */
    public function we_can_see_the_list_of_providers_when_logged_in(FunctionalTester $I)
    {
        $I->amOnRoute('providers.index');
        $I->see('Product & service providers', 'h1');
    }

}
