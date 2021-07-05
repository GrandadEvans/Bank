<?php

namespace Tests\functional;


use Bank\Models\User;
use FunctionalTester;
use Illuminate\Support\Facades\Auth;

trait FunctionalTestBase
{
    protected array $validUser = [];

    /**
     * @param  FunctionalTester  $I
     */
    protected function getReadyToTryToAccessSomebodyElsesRecord(string $table, FunctionalTester $I): void
    {
        $I->seeRecord($table, [
            'id' => 1,
            'user_id' => 1
        ]);
        $I->logout();
        $I->dontSeeAuthentication();
        $user2 = User::factory()->create();
        $I->amLoggedAs($user2);
        $I->expect(Auth::id() == 2);
    }

    protected function seeLoginForm(FunctionalTester $I)
    {
        $I->seeElement('input', [
            'type' => 'email',
            'name' => 'email'
        ]);
        $I->seeElement('input', [
            'type' => 'password'
        ]);
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
