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
}
