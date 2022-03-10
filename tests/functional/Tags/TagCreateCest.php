<?php

use Bank\Models\Tag;
use Bank\Models\User;

class TagCreateCest
{
    protected $user;

    protected $app;

    protected $validFormData = [
        'tag' => 'Socks',
        'default_color' => '#FF00FF',
        'icon' => 'fa fa-socks'
    ];

    protected $invalidFormData = [
        'tag' => 'f',
        'default_color' => '#abcdeg'
    ];


    /**
     * @param  FunctionalTester  $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $I->callArtisan('db:seed');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
    }

    public function we_can_see_a_form_to_add_a_tag(FunctionalTester $I)
    {
        $I->amOnPage('/tags/create');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('input', ['id' => 'tag', 'required' => 'required']);
        $I->seeElement('input', ['id' => 'default_color']);
        $I->seeElement('button', ['type' => 'submit', 'id' => 'submit']);
        $I->seeElement('input', ['type' => 'hidden', 'name' => '_token']);
    }


    public function we_see_errors_when_empty_tags_form_submitted(FunctionalTester $I)
    {
        $I->amOnPage('/tags/create');
        $I->click('Add Tag');
        $I->see('The tag must be between 2 and 100 characters.');
    }

    public function we_see_errors_when_failed_tags_form_submitted(FunctionalTester $I)
    {
        $I->amOnPage('/tags/create');
        $I->fillField('tag', $this->invalidFormData['tag']);
        $I->fillField('default_color', $this->invalidFormData['default_color']);
        $I->click('Add Tag');
        $I->see('The tag must be between 2 and 100 characters.');
        $I->see('The default color format is invalid.');
    }

    public function we_can_successfully_submit_the_tags_form(FunctionalTester $I)
    {
        $number_tags_prior = Tag::all()->count();
        $I->amOnPage('/tags/create');
        $this->correctlyFillInForm($I);
        $I->click('Add Tag');
        $I->makeHtmlSnapshot();
        $I->seeNumRecords($number_tags_prior + 1, 'tags');
        $I->seeRecord('tags', [
            'tag' => $this->validFormData['tag'],
            'default_color' => $this->validFormData['default_color'],
            'created_by_user_id' => $this->user->id
        ]);
    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function correctlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('tag', $this->validFormData['tag']);
        $I->fillField('default_color', $this->validFormData['default_color']);
        $I->fillField('icon', $this->validFormData['icon']);
    }

    /**
     * @param  FunctionalTester  $I
     */
    protected function incorrectlyFillInForm(FunctionalTester $I): void
    {
        $I->fillField('tag', $this->invalidFormData['tag']);
        $I->fillField('default_color', $this->invalidFormData['default_color']);
    }
}
