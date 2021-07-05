<?php

use Bank\Models\TagsTransactions;
use Bank\Models\Transaction;
use Bank\Models\Tag;
use Bank\Models\User;
use Tests\functional\FunctionalTestBase;

class TagTransactionIndexCest
{
    use FunctionalTestBase;

    protected $user;

    protected $app;

    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh --seed');
        $this->user = User::factory()->create();
        $I->amLoggedAs($this->user);
        $this->tag = Tag::factory()->create(['tag' => 'randomTagName', 'default_color' => '#000000', 'created_by_user_id' => \Illuminate\Support\Facades\Auth::id()]);
        $this->transaction = Transaction::factory()->create(['user_id' => $this->user->id]);
        $I->amLoggedAs($this->user);
        $I->amOnRoute('transactions.all');
$I->makeHtmlSnapshot();
    }

    /**
     * @param FunctionalTester $I
     * @test
     */
    public function make_sure_we_can_associate_tag_to_transaction(FunctionalTester $I)
    {
        $this->transaction->tags()->save($this->tag);
        $I->amOnRoute('transactions.all');
//        $I->makeHtmlSnapshot();
        $I->see($this->tag->tag);
    }
}
