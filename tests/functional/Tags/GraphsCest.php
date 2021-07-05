<?php

use Bank\Models\Tag;
use Bank\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\functional\FunctionalTestBase;

class GraphsCest
{
    use FunctionalTestBase;


    public function _before(FunctionalTester $I)
    {
        $this->validUser = [
            'name' => 'John Doe',
            'email' => 'john@valid.com',
            'password' => 'password123'
        ];
        $this->login($I);
    }

    /**
     * @test
     *
     * @param FunctionalTester $I
     */
    public function we_have_a_workable_db_query_for_pie_chary(FunctionalTester $I): void
    {
       $I->callArtisan('migrate:fresh --seed');
       $I->amLoggedAs(User::find(1));

    }
}
