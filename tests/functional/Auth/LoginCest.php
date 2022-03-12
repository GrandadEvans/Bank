<?php

use Bank\Models\User;

class LoginCest
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


    public function we_should_not_be_able_to_login_with_incorrect_details(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->logout();
        $I->amOnPage('/login');
        $I->fillField('email',    $this->invalidDetails['email']);
        $I->fillField('password', $this->invalidDetails['password']);
        $I->click('Login Now');

        // Now we should get an error and our email back
        $I->see('These credentials do not match our records.');
        $I->seeInField('email', $this->invalidDetails['email']);
        $I->dontSeeInField('password', $this->invalidDetails['password']);
        $I->seeCurrentUrlEquals('/login');
    }

    public function we_should_not_be_able_to_login_with_a_correct_email_but_false_password(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $user = new User([
            'email' => $this->validDetails['email'],
            'password' => bcrypt($this->validDetails['password'])
        ]);

        $I->amOnPage('/login');
        $I->fillField('email', $this->validDetails['email']);
        $I->fillField('password', $this->invalidDetails['password']);
        $I->click('Login Now');

        // We should still get an error and our email, but no password
        $I->see('These credentials do not match our records.');
        $I->seeInField('email', $this->validDetails['email']);
        $I->dontSeeInField('password', $this->invalidDetails['password']);
        $I->seeCurrentUrlEquals('/login');
    }
}
