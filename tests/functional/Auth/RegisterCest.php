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

    public function the_page_displays_ok(FunctionalTester $I)
    {
        // reset the db
        $I->callArtisan('migrate:fresh');

        $I->amOnPage('/');
        $I->seeLink('Register');
        $I->click('Register');
        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/register');
    }

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

    public function we_can_successfully_register(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        // As before, but...
        $I->amOnPage('/register');
        $I->fillField('name', $this->validDetails['name']);
        $I->fillField('email', $this->validDetails['email']);
        $I->fillField('password', $this->validDetails['password']);
        // use the correct confirmatory password
        $I->fillField('password_confirmation', $this->validDetails['password']);
        $I->click('Register Now');

        // The home page should display ok, with our name, a record in the DB that is authenticated and a logout link
        $I->seeCurrentUrlEquals('/home');
        $I->seeResponseCodeIs(200);
        $I->seeRecord('\Bank\Models\User', [
            'name' => $this->validDetails['name'],
            'email' => $this->validDetails['email']
        ]);
        $I->seeAuthentication();
        $I->seeLink('Logout');
    }
}
