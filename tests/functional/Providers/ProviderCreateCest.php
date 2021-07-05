<?php

use Bank\Models\User;

class ProviderCreateCest
{
    protected $user;

    protected $app;

    protected $validFormData = [
        'name' => 'Walmart PLC',
//        'logo' => 'http://google.com',
        'remarks' => 'Nothing further to add',
        'payment_method_id' => '1',
        'regular_expressions' => '^Halifax.*$',
    ];

    protected $invalidFormData = [
        'name' => 'f',
//        'logo' => 'file:///home/john/image.jpg',
        'remarks' => '',
        'payment_method_id' => '0',
        'regular_expressions' => 'f',
    ];


    /**
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->callArtisan('db:seed --class PaymentMethodSeeder');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
    }

    public function we_can_see_a_form_to_add_a_provider(FunctionalTester $I)
    {
        $I->amOnPage('/providers/create');
//        $I->makeHtmlSnapshot();
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('input', ['id' => 'name', 'required' => 'required']);
        $I->seeElement('select', ['id' => 'payment_method_id']);
        $I->seeElement('input', ['id' => 'remarks']);
//        $I->seeElement('input', ['id' => 'logo', 'type' => 'url']);
        $I->seeElement('textarea', ['id' => 'regular_expressions']);
        $I->seeElement('button', ['type' => 'submit', 'id' => 'submit']);
        $I->seeElement('input', ['type' => 'hidden', 'name' => '_token']);
    }

    public function we_should_only_see_the_providers_page_when_logged_in(FunctionalTester $I)
    {
        $I->amOnPage('/providers/create');
        $I->see('Hi, '.$this->user->name);
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('see your account');
        $I->dontSeeAuthentication('web');
        $I->amOnPage('/providers/create');
        $I->seeInCurrentUrl('login');
    }

    public function we_see_errors_when_empty_providers_form_submitted(FunctionalTester $I)
    {
        $I->amOnPage('/providers/create');
        $I->click('Add Provider');
        $I->see('The name must be between 2 and 100 characters.');
    }

    public function we_see_errors_when_failed_providers_form_submitted(FunctionalTester $I)
    {
        $I->amOnPage('/providers/create');
        $I->fillField('remarks', 'g');
//        $I->fillField('logo', 'g');
        $I->fillField('regular_expressions', 'g');
        $I->click('Add Provider');
        $I->makeHtmlSnapshot();
        $I->see('The name must be between 2 and 100 characters.');
        $I->see('The remarks must be between 2 and 255 characters.');
//        $I->see('The logo format is invalid.');
    }

    public function we_can_successfully_submit_the_providers_form(FunctionalTester $I)
    {
        $I->amOnPage('/providers/create');
        $this->correctlyFillInForm($I);
        $I->click('Add Provider');
        $I->makeHtmlSnapshot();
        $I->seeNumRecords(1, 'providers');
        $I->seeRecord('providers', [
            'name' => $this->validFormData['name'],
            'remarks' => $this->validFormData['remarks'],
            'payment_method_id' => '1',
//            'logo' => $this->validFormData['logo'],
            'regular_expressions' => $this->validFormData['regular_expressions']
        ]);
    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function correctlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('name', $this->validFormData['name']);
        $I->fillField('remarks', $this->validFormData['remarks']);
//        $I->fillField('logo', $this->validFormData['logo']);
        $I->fillField('regular_expressions', $this->validFormData['regular_expressions']);
        $I->selectOption('payment_method_id', $this->validFormData['payment_method_id']);
    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function incorrectlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('nextDue', $this->invalidFormData['nextDue']);
        $I->fillField('description', $this->invalidFormData['description']);
        $I->fillField('amount', $this->invalidFormData['amount']);
        $I->fillField('remarks', $this->invalidFormData['remarks']);
        $I->fillField('regular_expressions', $this->invalidFormData['regular_expressions']);
        $I->checkOption('estimated');
        $I->selectOption('type', 'Standing Order');
        $I->selectOption('days', 'Annually');
    }
}
