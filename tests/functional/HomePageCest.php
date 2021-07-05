<?php

class HomePageCest
{
    protected $validUser = [];

    public function _before(FunctionalTester $I)
    {
        $this->validUser = [
            'name' => 'John Doe',
            'email' => 'john@valid.com',
            'password' => 'password123'
        ];
        $this->login($I);
    }

    protected function login(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->haveRecord('users', [
            'name'      => $this->validUser['name'],
            'email'     => $this->validUser['email'],
            'password'  => bcrypt($this->validUser['password'])
        ]);
        $I->amLoggedAs([
            'name'      => $this->validUser['name'],
            'email'     => $this->validUser['email'],
            'password'  => $this->validUser['password']
        ]);
        $I->amOnRoute('home', [
            'transactions' => []
        ]);
    }

    public function we_can_submit_the_form(FunctionalTester $I)
    {
        $I->attachFile('#file_input', '../resources/valid.csv');
        $I->click('#import_file_button');
        $I->amOnRoute('transactions.manual_import');
    }

    public function we_get_an_exception_if_no_file_passed(FunctionalTester $I)
    {
        $I->click('#import_file_button');
        $I->amOnRoute('transactions.manual_import');
        $I->see("The GET method is not supported for this route");
    }

    public function we_create_a_new_transaction_for_each_entry(FunctionalTester $I)
    {
        $I->attachFile('#file_input', '../resources/valid.csv');
        $I->click('#import_file_button');
        $I->amOnRoute('transactions.manual_import');
    }

}
