<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function authenticate()
    {
        $user = User::factory()->create();
        return $this->actingAs($user, 'sanctum');
    }

    public function test_customer_can_be_created()
    {
        $this->authenticate();

        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'iban' => $this->faker->iban('DE'),
        ];

        $response = $this->postJson('/api/customers', $payload);

        $response->assertCreated()
            ->assertJsonFragment([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'iban' => $payload['iban'],
            ]);
    }

    public function test_customers_can_be_listed()
    {
        $this->authenticate();

        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_customer_can_be_fetched()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();

        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertOk()
            ->assertJsonFragment([
                'email' => $customer->email,
                'iban' => $customer->iban,
            ]);
    }

    public function test_customer_can_be_updated()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();
        $newName = 'Updated Name';

        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => $newName,
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => $newName]);
    }

    public function test_customer_can_be_deleted()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
