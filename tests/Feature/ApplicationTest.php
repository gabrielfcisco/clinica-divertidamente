<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CustomUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_user_is_authenticated()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticated();
    }

    public function test_login_view_can_be_accessed()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
    }

    public function test_crud_secretaria_view_can_be_accessed()
    {
        $response = $this->get('/crud_secretaria');
        
        $response->assertStatus(200);
    }

    public function test_crud_psicologo_view_can_be_accessed()
    {
        $response = $this->get('/crud_psicologo');
        
        $response->assertStatus(200);
    }

    public function test_crud_paciente_view_can_be_accessed()
    {
        $response = $this->get('/crud_paciente');
        
        $response->assertStatus(200);
    }

    public function test_making_an_api_request()
    {
        Http::fake([
            'https://viacep.com.br/ws/01310930/json/' => Http::response([
                'cep' => '01310-930',
                'logradouro' => 'Avenida Paulista',
                'bairro' => 'Bela Vista',
                'localidade' => 'São Paulo',
                'uf' => 'SP',
                'ibge' => '3550308',
                'gia' => '1004',
                'ddd' => '11',
                'siafi' => '7107',
            ], 201),
        ]);

        $response = $this->get('/cep/01310930');

        $response->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
    }
    
}

