<?php

use Bank\Models\User;
use Illuminate\Http\Response;

class SearchCest
{
    private $user;

    /**
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh --seed');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
    }
}
