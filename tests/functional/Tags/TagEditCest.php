<?php

use Bank\Models\Tag;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TagEditCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    protected $selectedTag = [
        'tag' => 'randomTagName',
        'default_color' => '#FFFF00'
    ];

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $I->callArtisan('db:seed');
        Tag::factory()->create();
        Tag::factory()->create($this->selectedTag);
        Tag::factory()->create();
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_should_see_the_tag_details(FunctionalTester $I)
    {
        $tagId = Tag::where('tag', $this->selectedTag['tag'])->first()->id;

        $I->amOnRoute('tags.index');
        $I->click('#update-form-button-'.$tagId);
        $I->seeElement('h2');
        $I->seeInField('tag', $this->selectedTag['tag']);
        $I->seeInField('default_color', $this->selectedTag['default_color']);
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
        $editedValues = ['tag' => 'normalTagName', 'default_color' => '#00FF00'];

        $I->amOnRoute('tags.edit', [2]);
        $I->fillField('tag', $editedValues['tag']);
        $I->fillField('default_color', $editedValues['default_color']);
        $I->click('Update Tag');
        $I->seeCurrentRouteIs('tags.index');
        $I->see($editedValues['tag']);
        $I->see($editedValues['default_color']);
    }

    /**
     * We should not be able to update a tag if we aren't logged in
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_edit_a_tag(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('tags.update', [1]);
        $this->seeLoginForm($I);
    }

    /**
     * We should not be able to update a tag unless we are logged in
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_update_a_tag(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('tags.update', [1]);
        $this->seeLoginForm($I);
    }

}
