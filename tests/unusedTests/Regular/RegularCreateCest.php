<?php

use Bank\BaseModel;
use Bank\Dates;
use Bank\Regular;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class RegularCreateCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    protected $validFormData = [
        'nextDue' => '25-06-2019',
        'description' => 'A test company',
        'amount' => '-12.34',
        'remarks' => 'Nothing further to add',
        'estimated' => 1,
        'payment_method_id' => '3',
        'days' => '1w',
    ];

    protected $invalidFormData = [
        'nextDue' => '25/06/2019',
        'description' => 'a',
        'amount' => 'a pound',
        'remarks' => 'a',
        'estimated' => 1,
        'type' => 'pd',
        'days' => '1s',
    ];


    /**
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh --seed');
        $this->user = factory(User::class)->create();
        $I->amLoggedAs($this->user);
    }

    public function we_can_see_a_form_to_add_regular_entries(FunctionalTester $I)
    {
        $I->amOnPage('/regulars/create');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('input',  ['id' => 'nextDue', 'required' => 'required']);
        $I->seeElement('input',  ['id' => 'description', 'required' => 'required']);
        $I->seeElement('input',  ['id' => 'amount', 'required' => 'required']);
        $I->seeElement('input',  ['id' => 'remarks']);
        $I->seeElement('input',  ['id' => 'estimated']);
        $I->seeElement('select', ['id' => 'provider_id']);
        $I->seeElement('select', ['id' => 'payment_method_id']);
        $I->seeElement('select', ['id' => 'days']);
        $I->seeElement('button', ['type' => 'submit', 'id' => 'submit']);
        $I->seeElement('input', ['type' => 'hidden', 'name' => '_token']);
    }

    public function we_should_only_see_the_page_when_logged_in(FunctionalTester $I)
    {
        $I->amOnPage('/regulars/create');
        $I->see('Hi, '.$this->user->name);
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('see your account');
        $I->dontSeeAuthentication('web');
        $I->amOnPage('/regulars/create');
        $I->seeInCurrentUrl('login');
    }

    public function we_see_errors_when_empty_form_submitted(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->amOnPage('/regulars/create');
        $I->click('Add Transaction');
        $I->see('The next due is not a valid date.');
        $I->see('The description must be a string.');
        $I->see('The amount field is required.');
    }

    public function we_see_errors_when_failed_form_submitted(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->amOnPage('/regulars/create');
        $I->click('Add Transaction');
        $I->see('The next due is not a valid date.');
        $I->see('The description must be a string.');
//        $I->see('The description field is required.');
        $I->see('The amount field is required.');
    }

    public function we_can_successfully_submit_the_form(FunctionalTester $I)
    {
        $I->amOnPage('/regulars/create');
        $I->seeNumRecords(20, 'regulars');
        $this->correctlyFillInForm($I);
        $I->click('Add Transaction');
        $I->seeNumRecords(21, 'regulars');
        $I->seeRecord('regulars', [
            'nextDue' => Dates::convertBritishDateToMysql($this->validFormData['nextDue']),
            'description' => $this->validFormData['description'],
            'provider_id' => 1,
            'amount' => $this->validFormData['amount'],
            'estimated' => '1',
            'payment_method_id' => $this->validFormData['payment_method_id'],
            'days' => $this->validFormData['days'],
            'remarks' => $this->validFormData['remarks']
        ]);
    }

    public function make_sure_we_only_get_records_we_own_user1(FunctionalTester $I)
    {
        $user2 = factory(User::class)->create();
        factory(Regular::class)->create(['user_id' => $this->user->id]);
        factory(Regular::class)->create(['user_id' => $this->user->id]);
        factory(Regular::class)->create(['user_id' => $user2->id]);
        $I->seeNumRecords(2, 'regulars', ['user_id' => $this->user->id]);
        $I->amOnPage('/regulars');
        $I->seeNumberOfElements('tr', 3);
    }

    public function make_sure_we_only_get_records_we_own_user2(FunctionalTester $I)
    {
        $user2 = factory(User::class)->create();
        $I->amLoggedAs($user2);
        factory(Regular::class)->create(['user_id' => $this->user->id]);
        factory(Regular::class)->create(['user_id' => $this->user->id]);
        factory(Regular::class)->create(['user_id' => $user2->id]);
        $I->seeNumRecords(1, 'regulars', ['user_id' => $user2->id]);
        $I->amOnPage('/regulars');
        $I->seeNumberOfElements('tr', 2);
    }

    /**
     * When we create a regular we need to choose a provider
     *
     * @test
     */
    public function we_need_to_choose_a_provider_when_creating_regulars(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = factory(User::class)->create();
        $I->amLoggedAs($this->user);


    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function correctlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('nextDue', $this->validFormData['nextDue']);
        $I->fillField('description', $this->validFormData['description']);
        $I->fillField('amount', $this->validFormData['amount']);
        $I->fillField('remarks', $this->validFormData['remarks']);
        $I->selectOption('provider_id', 'N/A');
        $I->checkOption('estimated');
        $I->selectOption('payment_method_id', 3);
        $I->selectOption('days', 'Weekly');
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
        $I->checkOption('estimated');
        $I->selectOption('payment_method_id', 2);
        $I->selectOption('days', 'Annually');
    }
}
