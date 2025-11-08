<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\ClientController
 */
class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function it_can_display_the_clients_index_page()
    {
        Client::factory()->count(3)->create();

        $response = $this->get(route('clients.index'));

        $response->assertOk();
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients');
        $this->assertCount(3, $response->viewData('clients'));
    }

    /**
     * @test
     */
    public function it_can_filter_clients_by_search_term()
    {
        $client1 = Client::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        $client2 = Client::factory()->create(['first_name' => 'Jane', 'last_name' => 'Smith']);

        $response = $this->get(route('clients.index', ['search' => 'John']));

        $response->assertOk();
        $response->assertSee($client1->first_name);
        $response->assertDontSee($client2->first_name);
    }

    /**
     * @test
     */
    public function it_can_display_the_create_client_form()
    {
        $response = $this->get(route('clients.create'));

        $response->assertOk();
        $response->assertViewIs('clients.form');
    }

    /**
     * @test
     */
    public function it_can_store_a_new_client()
    {
        $clientData = Client::factory()->make()->toArray();
        
        // The factory doesn't include these fields which are in the validation rules
        $clientData['title'] = 'Mr';
        $clientData['gender'] = 'MALE';

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', ['email' => $clientData['email']]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_client()
    {
        $client = Client::factory()->create();

        $response = $this->get(route('clients.show', $client));

        $response->assertOk();
        $response->assertViewIs('clients.show');
        $response->assertSee($client->first_name);
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_client_form()
    {
        $client = Client::factory()->create();

        $response = $this->get(route('clients.edit', $client));

        $response->assertOk();
        $response->assertViewIs('clients.form');
        $response->assertSee($client->first_name);
    }

    /**
     * @test
     */
    public function it_can_update_a_client()
    {
        $client = Client::factory()->create();
        $updateData = Client::factory()->make()->toArray();
        $updateData['title'] = 'Mrs';
        $updateData['gender'] = 'FEMALE';


        $response = $this->put(route('clients.update', $client), $updateData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', ['id' => $client->id, 'email' => $updateData['email']]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}