<?php

class RegisterCest
{
    protected $invalidDetails = [
        'email' => 'invalidemail@false.com',
        'password' => 'password321'
    ];

    protected $validDetails = [
        'email' => 'validemail@true.com',
        'name' => 'John Doe',
        'password' => 'password123'
    ];


    public function make_sure_we_cant_login_when_passwords_dont_match(FunctionalTester $I): void
    {
        $I->callArtisan('migrate:fresh');
        $I->amOnPage('/register');

        // Fill the form as normal
        $I->fillField('name', $this->validDetails['name']);
        $I->fillField('E-Mail Address', $this->validDetails['email']);
        $I->fillField('password', $this->validDetails['password']);
        // but use a different confirmatory password
        $I->fillField('password_confirmation', $this->invalidDetails['password']);
        $I->click('Register Now');

        // We should see an error; the old email and name, but no passwords
        $I->see('The password confirmation does not match.');
        $I->seeInField('email', $this->validDetails['email']);
        $I->seeInField('name', $this->validDetails['name']);
        $I->seeInField('password', '');
        $I->seeInField('password_confirmation', '');
    }
}
