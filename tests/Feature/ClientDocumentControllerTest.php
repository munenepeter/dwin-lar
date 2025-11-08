<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientDocument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\ClientDocumentController
 */
class ClientDocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->client = Client::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function it_can_store_a_new_document()
    {
        Storage::fake('documents');

        $documentData = [
            'client_id' => $this->client->id,
            'document_type' => 'PASSPORT',
            'document_name' => 'John Doe Passport',
            'document_path' => UploadedFile::fake()->create('passport.pdf'),
            'notes' => 'Some notes about the passport.',
        ];

        $response = $this->post(route('clients.documents.store', $this->client), $documentData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('client_documents', [
            'client_id' => $this->client->id,
            'document_name' => 'John Doe Passport'
        ]);
    }

    /**
     * @test
     */
    public function it_can_display_a_document()
    {
        $document = ClientDocument::factory()->create(['client_id' => $this->client->id]);

        $response = $this->get(route('documents.show', $document));

        $response->assertOk();
        $response->assertViewIs('client-documents.show');
        $response->assertSee($document->document_name);
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_document_form()
    {
        $document = ClientDocument::factory()->create(['client_id' => $this->client->id]);

        $response = $this->get(route('documents.edit', $document));

        $response->assertOk();
        $response->assertViewIs('client-documents.edit');
        $response->assertSee($document->document_name);
    }

    /**
     * @test
     */
    public function it_can_update_a_document()
    {
        $document = ClientDocument::factory()->create(['client_id' => $this->client->id]);

        $updateData = [
            'client_id' => $this->client->id,
            'document_type' => 'DRIVERS_LICENSE',
            'document_name' => 'Updated Driver License',
            'is_verified' => true,
        ];

        $response = $this->put(route('documents.update', $document), $updateData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('client_documents', [
            'id' => $document->id,
            'document_name' => 'Updated Driver License',
            'is_verified' => 1,
        ]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_document()
    {
        $document = ClientDocument::factory()->create(['client_id' => $this->client->id]);

        $response = $this->delete(route('documents.destroy', $document));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('client_documents', ['id' => $document->id]);
    }
}
