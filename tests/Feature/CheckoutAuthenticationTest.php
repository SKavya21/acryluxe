<?php

namespace Tests\Feature;

use Tests\TestCase;

class CheckoutAuthenticationTest extends TestCase
{
    public function test_guests_are_sent_to_login_with_the_cart_backurl(): void
    {
        $response = $this->post(route('checkout.store'), [
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('login', [
            'backurl' => route('cart.index', absolute: false),
        ]));
    }
}