<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\CustomUser;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_is_authenticated()
    {
        $this->assertAuthenticated($guard = null);
    }

 
    public function test_homepage_view_can_be_rendered()
    {
        $view = $this->view('home', ['name' => 'João']);
 
        $view->assertSee('João');
    }

    //exemplo de Teste de API
    /*public function test_making_an_api_request()
    {
        $response = $this->postJson('/api/user', ['name' => 'Sally']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
    }
    */
    
}

