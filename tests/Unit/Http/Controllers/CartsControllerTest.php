<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Checkout\Models\Cart;
use Tipoff\StaffBookings\Tests\TestCase;
use Tipoff\Support\Contracts\Checkout\Discounts\DiscountInterface;
use Tipoff\TestSupport\Models\TestSellable;

class CartsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function show()
    {
        TestSellable::createTable();

        $user = User::factory()->create();

        $cart = Cart::activeCart($user->id);
        $cart->upsertItem(
            Cart::createItem(TestSellable::factory()->create(), 'item-id', 1234, 2)
        );

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-vendor/booking/users/{$user->id}/cart")
            ->assertOk();

        $this->assertEquals(2468, $response->json('data.item_amount_total'));
        $this->assertEquals(1234, $response->json('data.items.data.0.amount_each_original'));
    }

    /** @test */
    public function add_code_no_services()
    {
        TestSellable::createTable();

        $user = User::factory()->create();

        $cart = Cart::activeCart($user->id);
        $cart->upsertItem(
            Cart::createItem(TestSellable::factory()->create(), 'item-id', 1234, 2)
        );

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this
            ->postJson("nova-vendor/booking/{$user->id}/add-code", [
                'code' => 'abcd',
            ])
            ->assertStatus(422);

        $this->assertEquals("Code not found", $response->json('errors.code.0'));
    }

    /** @test */
    public function add_code_with_service()
    {
        $this->logToStderr();
        $service = \Mockery::mock(DiscountInterface::class);
        $service->shouldReceive('findByCode')
            ->once()
            ->with('abcd')
            ->andReturnSelf();
        $service->shouldReceive('applyToCart')->andReturnSelf();
        $service->shouldReceive('getCodesForCart')->andReturn([$service]);
        $service->shouldReceive('getCode')->andReturn('abcd');
        $service->shouldReceive('calculateAdjustments')->andReturn();
        $this->app->instance(DiscountInterface::class, $service);

        TestSellable::createTable();

        $user = User::factory()->create();

        $cart = Cart::activeCart($user->id);
        $cart->upsertItem(
            Cart::createItem(TestSellable::factory()->create(), 'item-id', 1234, 2)
        );

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this
            ->postJson("nova-vendor/booking/{$user->id}/add-code", [
                'code' => 'abcd',
            ])
            ->assertOk();

        $this->assertEquals(2468, $response->json('data.item_amount_total'));
    }
}
