<?php

use Bank\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Tests\functional\FunctionalTestBase;

class TagIndexCest
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
    public function clicking_the_tags_home_link_takes_us_to_the_tags_home_page(FunctionalTester $I): void
    {
       $I->click('Tags');
       $I->seeCurrentRouteIs('tags.index');
       $I->canSeeElement('table', ['id' => 'TagsTable']);
    }

    /**
     * @test
     *
     * @param FunctionalTester $I
     */
    public function when_a_new_tag_is_added_it_should_appear_in_the_table(FunctionalTester $I): void
    {
        $this->createNewTag($I);
        $I->see('randomTagName');
    }

    /**
     * @test
     *
     * @param FunctionalTester $I
     */
    public function default_colour_td_should_have_that_color_background_and_contrasted_text(FunctionalTester $I): void
    {
        $this->createNewTag($I, '#000000');
        $this->createNewTag($I, '#FFFFFF');
        $I->seeElement('td', [
            'style' => 'background-color: #000000; color: white',
            'class' => 'dynamic_background_colour'
        ]);
        $I->seeElement('td', [
            'style' => 'background-color: #FFFFFF; color: black',
            'class' => 'dynamic_background_colour'
        ]);
        $I->makeHtmlSnapshot();
    }

    /**
     * @param FunctionalTester $I
     */
    protected function createNewTag(FunctionalTester $I, $defaultColour = '#00FFFF'): void
    {
        $I->amOnPage('/');
        Tag::create([
            'tag' => 'randomTagName',
            'default_color' => $defaultColour,
            'created_by_user_id' => Auth::id()
        ]);
        $I->amOnRoute('tags.index');
    }
}
