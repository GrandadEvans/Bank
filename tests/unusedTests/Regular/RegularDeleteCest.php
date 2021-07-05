<?php

use Bank\BaseModel;
use Bank\Regular;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class RegularDeleteCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    private $selectedRegular;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = factory(User::class)->create();
        $I->amLoggedAs($this->user);
        factory(Regular::class)->create();
        $this->selectedRegular = [
            'nextDue' => '2015-12-31',
            'description' => 'A Test Description',
            'provider_id' => 1,
            'amount' => '-12.99',
            'remarks' => 'test remarks'
        ];
        factory(Regular::class)->create($this->selectedRegular);
        factory(Regular::class)->create();
    }

     /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_delete_a_record(FunctionalTester $I)
    {
        $I->seeNumRecords(3, 'regulars');
        $I->amOnPage('/regulars');
        $I->makeHtmlSnapshot();
        $I->see($this->selectedRegular['description']);
        $I->click('#delete-form-button-2');
        $I->cantSee($this->selectedRegular['description']);
        $I->seeNumRecords(2, 'regulars');
        $I->seeCurrentRouteIs('regulars.index');
    }

    /**
     * We should not be able to update a regular we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_regular_to_delete_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('regulars', $I);
        $I->amOnRoute('regulars.update', [1]);
        $I->see('This is not your transaction to delete');
    }

}
