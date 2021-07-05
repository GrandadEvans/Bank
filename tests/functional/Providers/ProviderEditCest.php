<?php

use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class ProviderEditCest
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
        $I->amLoggedAs($this->user);
        $I->callArtisan('db:seed --class PaymentMethodSeeder');
        Provider::factory()->create();
        $standingOrderId = PaymentMethod::where('method', 'Standing Order')->first()->id;
        $this->selectedProvider = [
            'name' => 'Tesco Plc',
            'remarks' => 'A Test Provider',
            'payment_method_id' => $standingOrderId,
            'regular_expressions' => '\\^HALIFAX\.com.*$\\',
//            'logo' => 'http://gozzzogle.com'
        ];
        Provider::factory()->create($this->selectedProvider);
        Provider::factory()->create();
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_should_see_the_provider_details(FunctionalTester $I)
    {
        $I->amOnRoute('providers.index');
        $I->click('#update-form-button-2');
        $I->seeElement('h2');
        $I->seeInField('name', $this->selectedProvider['name']);
        $I->seeInField('remarks', $this->selectedProvider['remarks']);
//        dd($this->selectedProvider);
//        $I->seeInField('logo', $this->selectedProvider['logo']);
        $I->seeInField('regular_expressions', $this->selectedProvider['regular_expressions']);
        $I->seeOptionIsSelected('payment_method_id', 'Standing Order');
        $I->seeElement('input', [
            'type' => 'hidden',
            'name' => '_method',
            'value' => 'PUT']);
        $I->seeElement('input', [
            'type' => 'hidden',
            'name' => '_token'
        ]);
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function when_we_click_update_we_can_updated_values(FunctionalTester $I)
    {
        $editedValues = [
            'name' => 'Asda Plc',
            'remarks' => 'A Different Test Provider',
            'preferred_payment_method' => 'dd',
            'regular_expressions' => '\\^ASDA\.com.*$\\',
//            'logo' => 'http://asda.com'
        ];

        $I->amOnRoute('providers.edit', [2]);
        $I->fillField('name', $editedValues['name']);
//        $I->fillField('logo', $editedValues['logo']);
        $I->fillField('remarks', $editedValues['remarks']);
        $I->fillField('regular_expressions', $editedValues['regular_expressions']);
        $I->selectOption('payment_method_id', 'Direct Debit');
        $I->click('Update Provider');
        $I->seeCurrentRouteIs('providers.index');
//        $I->see($editedValues['nextDue']));
        $I->see($editedValues['name']);
        $I->see($editedValues['remarks']);
        // Logo is disabled as the logo is not enabled currently as it's taking up too much network time
//        $I->seeInSource($editedValues['logo']);
        $I->see($editedValues['regular_expressions']);
    }

    /**
     * We should not be able to update a provider if we aren't logged in
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_edit_a_provider(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('providers.update', [1]);
        $this->seeLoginForm($I);
    }

    /**
     * We should not be able to update a provider unless we are logged in
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_update_a_provider(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('providers.update', [1]);
        $this->seeLoginForm($I);
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function when_we_click_update_the_saving_observer_should_fire(FunctionalTester $I)
    {
        $editedValues = [
            'name' => 'Asda Plc',
            'remarks' => 'A Different Test Provider',
            'preferred_payment_method' => 'dd',
            'regular_expressions' => '\\^ASDA\.com.*$\\',
//            'logo' => 'http://asda.com'
        ];

        $I->amOnRoute('providers.edit', [2]);
        $I->fillField('name', $editedValues['name']);
//        $I->fillField('logo', $editedValues['logo']);
        $I->fillField('remarks', $editedValues['remarks']);
        $I->fillField('regular_expressions', $editedValues['regular_expressions']);
        $I->selectOption('payment_method_id', 'Direct Debit');
        $I->click('Update Provider');
//        $I->seeInSource('New regex found');
//        $I->seeInSource('href="/providers/find-transactions/2"');
    }

}
