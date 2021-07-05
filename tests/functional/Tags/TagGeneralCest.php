<?php

use Tests\functional\FunctionalTestBase;

class TagGeneralCest
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
    public function we_see_a_link_to_create_a_new_tag(FunctionalTester $I) :void {
        $I->seeLink('Create Tag');
    }

    /**
     * @test
     *
     * @param FunctionalTester $I
     */
    public function we_see_a_link_to_the_tags_index_page(FunctionalTester $I) :void
    {
        $I->seeLink('Tags', '/tags');
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

}
