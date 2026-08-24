<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\RequestModel;
use Illuminate\Support\Facades\Schema;
use Mockery;

class RequestsTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_request(): void
    {

        $response = $this->postJson('/api/saveRequest', [
            'id_material' => 1,
            'email' => 'test@example.com',
            'phone' => '+79999999999',
            'contact_person' => 'Иван Иванов',
            'test_basis' => 'ГОСТ 12345',
            'batch_number' => 'PART-001',
            'sample_quantity' => '10',
        ]);

        $response->dump();

        $response->assertStatus(201);

        $response->assertJson([
            'status' => 'success',
            'message' => 'Заявка успешно создана',
        ]);

        $response->assertJsonStructure([
            'status',
            'message',
            'request_id',
        ]);

        $this->assertDatabaseHas('requests', [
            'id' => $response->json('request_id'),
            'id_material' => 1,
            'email' => 'test@example.com',
            'phone' => '+79999999999',
            'contact_person' => 'Иван Иванов',
            'test_basis' => 'ГОСТ 12345',
            'batch_number' => 'PART-001',
            'sample_quantity' => '10',
            'id_status' => 1,
        ]);
    }

    public function test_without_id_material(): void
    {

        $response = $this->postJson('/api/saveRequest', [
            'email' => 'test@example.com',
            'phone' => '+79999999999',
            'contact_person' => 'Иван Иванов',
            'test_basis' => 'ГОСТ 12345',
            'batch_number' => 'PART-001',
            'sample_quantity' => '10',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'id_material',
        ]);

        $this->assertDatabaseCount('requests', 0);
    }

    public function test_request_creation_error_returns_500(): void
    {

        Schema::drop('requests');

        $response = $this->postJson('/api/saveRequest', [
            'id_material' => 1,
            'email' => 'test@example.com',
            'phone' => '+79999999999',
            'contact_person' => 'Иван Иванов',
            'test_basis' => 'ГОСТ 12345',
            'batch_number' => 'PART-001',
            'sample_quantity' => '10',
        ]);

        $response->assertStatus(500);

        $response->assertJson([
            'status' => 'error',
            'message' => 'Не удалось создать заявку',
        ]);
    }
}
