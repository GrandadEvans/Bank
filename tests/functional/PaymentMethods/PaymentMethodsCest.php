<?php

use Bank\Models\PaymentMethod;

class PaymentMethodsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * We should get an associative array back from the model
     *art make:test --unit
     * @watch
     * @test
     * @param  FunctionalTester  $I
     */
    public function we_can_add_a_list_of_payment_methods(FunctionalTester $I)
    {
        $I->callArtisan('migrate:fresh');
        $data = PaymentMethod::factory()->create();

        PaymentMethod::list();

        $I->seeNumRecords(1, 'payment_methods');
        $I->seeRecord('payment_methods', [
            'abbreviation' => $data->abbreviation,
            'method'       => $data->method
        ]);
    }
}
