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
        $I->seeLink('Add Tag');
    }

}
