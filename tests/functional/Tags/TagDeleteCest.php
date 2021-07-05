<?php

use Bank\Models\Tag;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TagDeleteCest
{
    use FunctionalTestBase;

    protected $user;
    /**
     * @var array
     */
    private $selectedTag;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $this->user = User::factory()->create();
        $I->callArtisan('db:seed');
        $I->amLoggedAs($this->user);
        Tag::factory()->create();
        $this->selectedTag = [
            'tag' => 'randomTagName',
            'default_color' => '#FF00FF'
        ];
        Tag::factory()->create($this->selectedTag);
        Tag::factory()->create();
    }

    /**
     * @param  FunctionalTester  $I
     */
    public function we_can_click_a_link_and_delete_a_tag(FunctionalTester $I)
    {
        $tagCount = Tag::all()->count();
        $tagId = Tag::where('tag', $this->selectedTag['tag'])->first()->id;

        $I->seeNumRecords($tagCount, 'tags');
        $I->amOnRoute('tags.index');
        $I->see($this->selectedTag['tag']);
        $I->click('#delete-form-button-'.$tagId);
        $I->cantSee($this->selectedTag['tag']);
        $I->seeNumRecords($tagCount - 1, 'tags');
        $I->seeCurrentRouteIs('tags.index');
    }

    /**
     * We should be logged in to delete a tag
     *
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_must_be_logged_in_to_delete_a_tag(FunctionalTester $I)
    {
        $I->logout();
        $I->amOnRoute('tags.index');
        $this->seeLoginForm($I);
    }

    /**
     * But we can see the tags list when we are logged in
     */
    public function we_can_see_the_list_of_tags_when_logged_in(FunctionalTester $I)
    {
        $I->amOnRoute('tags.index');
        $I->see('Tags', 'h1');
    }

}
