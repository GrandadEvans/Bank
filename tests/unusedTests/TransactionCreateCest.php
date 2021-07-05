<?php

use Bank\BaseModel;
use Bank\Dates;
use Bank\Transaction;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class TransactionCreateCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    protected $validFormData = [
        'date' => '25-06-2019',
        'entry' => 'A test company',
        'amount' => '-12.34',
        'balance' => '54.61',
        'remarks' => 'Nothing further to add',
        'type' => 'dd'
    ];

    protected $invalidFormData = [
        'date' => '25/06/2019',
        'entry' => 'a',
        'amount' => 'a pound',
        'balance' => 'two pounds',
        'remarks' => 'a',
        'type' => 'pd'
    ];


    /**
     * Get an HTML snapshot at the current location. I want to use this for easier debugging
     *
     * @param  FunctionalTester  $I
     *
     * @return mixed|null
     */
    protected function getHtml(FunctionalTester $I) {
        return $I->makeHtmlSnapshot();
    }


    /**
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
    }

    public function we_can_see_a_form_to_add_manual_transaction(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/transactions/create');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('input', ['id' => 'date', 'required' => 'required']);
        $I->seeElement('input', ['id' => 'entry', 'required' => 'required']);
        $I->seeElement('input', ['id' => 'amount', 'required' => 'required']);
        $I->seeElement('input', ['id' => 'balance', 'required' => 'required']);
        $I->seeElement('input', ['id' => 'remarks']);
        $I->seeElement('select', ['id' => 'provider_id']);
        $I->seeElement('option', ['value' => '1']);
        $I->seeElement('select', ['id' => 'type']);
        $I->seeElement('option', ['value' => 'dd']);
        $I->seeElement('option', ['value' => 'so']);
        $I->seeElement('option', ['value' => 'tfr']);
        $I->seeElement('option', ['value' => 'csh']);
        $I->seeElement('button', ['type' => 'submit', 'id' => 'submit']);
        $I->seeElement('input', ['type' => 'hidden', 'name' => '_token']);
    }

    public function we_should_only_see_the_transactions_page_when_logged_in(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/transactions/create');
        $I->see('Hi, '.$this->user->name);
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('see your account');
        $I->dontSeeAuthentication('web');
        $I->amOnPage('/transactions/create');
        $I->seeInCurrentUrl('login');
    }

    public function we_see_errors_when_empty_transactions_form_submitted(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/transactions/create');
        $I->seeNumRecords(0, 'transactions');
        $I->click('Add Transaction');
        $I->see('The date is not a valid date.');
        $I->see('The entry must be a string.');
        $I->see('The amount field is required.');
        $I->see('The balance field is required.');
    }

    public function we_see_errors_when_failed_transactions_form_submitted(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/transactions/create');
        $I->seeNumRecords(0, 'transactions');
        $I->click('Add Transaction');
        $I->see('The date is not a valid date.');
        $I->see('The entry must be a string.');
        $I->see('The amount field is required.');
        $I->see('The balance field is required.');
    }

    public function we_can_successfully_submit_the_transactions_form(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->have(User::class);
        $I->amLoggedAs($this->user);
        $I->amOnPage('/transactions/create');
        $I->seeNumRecords(0, 'transactions');
        $this->correctlyFillInForm($I);
        $I->click('Add Transaction');
        $I->seeNumRecords(1, 'transactions');
        $I->seeRecord('transactions', [
            'user_id' => $this->user->id,
            'date' => Dates::convertBritishDateToMysql($this->validFormData['date']),
            'entry' => $this->validFormData['entry'],
            'provider_id' => 1,
            'amount' => $this->validFormData['amount'],
            'balance' => $this->validFormData['balance'],
            'type' => $this->validFormData['type'],
            'remarks' => $this->validFormData['remarks']
        ]);
    }


    public function make_sure_we_only_get_transaction_records_we_own_user1(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Transaction::factory()->create(['user_id' => $user1->id]);
        Transaction::factory()->create(['user_id' => $user1->id]);
        Transaction::factory()->create(['user_id' => $user2->id]);
        $I->seeNumRecords(2, 'transactions', ['user_id' => $user1->id]);
        $I->seeNumRecords(1, 'transactions', ['user_id' => $user2->id]);
        $I->amLoggedAs($user1);
        $I->amOnPage('/transactions');
        $I->seeNumberOfElements('tr', 3);
    }

    public function make_sure_we_only_get_transaction_records_we_own_user2(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Transaction::factory()->create(['user_id' => $user1->id]);
        Transaction::factory()->create(['user_id' => $user1->id]);
        Transaction::factory()->create(['user_id' => $user2->id]);
        $I->seeNumRecords(2, 'transactions', ['user_id' => $user1->id]);
        $I->seeNumRecords(1, 'transactions', ['user_id' => $user2->id]);
        $I->amLoggedAs($user2);
        $I->amOnPage('/transactions');
        $I->makeHtmlSnapshot();
        $I->seeNumberOfElements('tr', 2);
    }


    /**
     * @param  FunctionalTester  $I
     */
    protected function correctlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('date', $this->validFormData['date']);
        $I->fillField('entry', $this->validFormData['entry']);
        $I->selectOption('provider_id', 'N/A');
        $I->fillField('amount', $this->validFormData['amount']);
        $I->fillField('balance', $this->validFormData['balance']);
        $I->fillField('remarks', $this->validFormData['remarks']);
        $I->selectOption('type', 'Direct Debit');
    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function incorrectlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('date', $this->invalidFormData['date']);
        $I->fillField('entry', $this->invalidFormData['entry']);
        $I->fillField('amount', $this->invalidFormData['amount']);
        $I->fillField('balance', $this->invalidFormData['balance']);
        $I->fillField('remarks', $this->invalidFormData['remarks']);
        $I->selectOption('type', 'Standing Order');
    }
}
