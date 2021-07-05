<?php

use Bank\BaseModel;
use Bank\Regular;
use Bank\User;
use Tests\functional\FunctionalTestBase;

class RegularEditCest
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
            'type' => 'so',
            'days' => '1w',
            'amount' => '-12.99',
            'remarks' => 'test remarks'
        ];
        factory(Regular::class)->create($this->selectedRegular);
        factory(Regular::class)->create();
    }

    /**
     * For some reason I cannot test this. Whether it be the middleware that is disabled somewhere I can't find or what
     * but it doesn't show as being on the login page. it shows as it is on the regulars
     *
     * @param  FunctionalTester  $I
    public function we_see_a_404_when_not_logged_in(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnPage('/regulars');
        $I->seeElement('input', [ 'type' => 'password']);
    }
     */

    /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_should_see_the_details(FunctionalTester $I)
    {
        $I->amOnRoute('regulars.index');
        $I->click('#update-form-button-2');
        $I->seeElement('h2');
//        $I->see($this->selectedRegular['nextDue']);
        $I->seeInField('description', $this->selectedRegular['description']);
        $I->seeInField('amount', $this->selectedRegular['amount']);
        if (key_exists('estimated', $this->selectedRegular)) {
            $I->seeCheckboxIsChecked('estimated');
        };
        $I->seeInField('remarks', $this->selectedRegular['remarks']);
        $I->seeOptionIsSelected('provider_id', 'N/A');
        $I->seeOptionIsSelected('type', 'Standing Order');
        $I->seeOptionIsSelected('days', 'Weekly');
        $I->seeElement('input', [
            'type' => 'hidden',
            'name' => '_method',
            'value' => 'PUT']);
        $I->seeElement('input', [
            'type' => 'hidden',
            'name' => '_token'
        ]);
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function when_we_click_update_we_can_updated_values(FunctionalTester $I)
    {

        $editedValues = [
            'nextDue' => '2020-01-01',
            'description' => 'A different description',
            'amount' => '99.99',
            'estimated' => 1,
            'remarks' => 'Another remark'
        ];

        $I->amOnRoute('regulars.edit', [2]);
        $I->fillField('nextDue', $editedValues['nextDue']);
        $I->fillField('description', $editedValues['description']);
        $I->fillField('amount', $editedValues['amount']);
        $I->checkOption('estimated');
        $I->fillField('remarks', $editedValues['remarks']);
        $I->selectOption('type', 'Direct Debit');
        $I->selectOption('days', 'Monthly');
        $I->selectOption('provider_id', 'N/A');
        $I->click('Update Transaction');
        $I->seeCurrentRouteIs('regulars.index');
//        $I->see($editedValues['nextDue']));
        $I->see($editedValues['description']);
        $I->see($editedValues['amount']);
        $I->see($editedValues['estimated']);
        $I->see($editedValues['remarks']);
    }

    /**
     * We should not be able to update a regular we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_regular_to_edit_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('regulars', $I);
        $I->amOnRoute('regulars.update', [1]);
        $I->see('This is not your transaction to edit');
    }

    /**
     * We should not be able to update a regular we don't own
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_own_a_regular_to_update_it(FunctionalTester $I)
    {
        $this->getReadyToTryToAccessSomebodyElsesRecord('regulars', $I);
        $I->amOnRoute('regulars.update', [1]);
        $I->see('This is not your transaction to update');
    }

}
