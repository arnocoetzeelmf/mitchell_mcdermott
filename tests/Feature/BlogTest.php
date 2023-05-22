<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class BlogTest extends TestCase
{
    public function test_add_blog_not_logged_in(): void
    {
        $post_data = array(
            'blog_title' => 'Blog title here',
            'blog_text' => 'Blog text comes here'
        );

        $this->json('POST', 'my_blog_view/store', $post_data)
            ->assertStatus(401);
    }

    public function test_add_blog_logged_in(): void
    {
        $email_address='arno.coetzee@gmail.com';
        $password='arnocoetzee';
        $user_name='Arno Coetzee';
    
        $created_user = User::updateOrCreate(
            [
                'email' => $email_address
            ],
            [
                'password' => Hash::make($password),
                'name' => $user_name, 
            ]  
        );

        $post_data = array(
            'blog_title' => 'Blog title here',
            'blog_text' => 'Blog text comes here'
        );

        $reponse = $this->actingAs($created_user)
            ->json('POST', 'my_blog_view/store', $post_data)
            ->assertStatus(201);
    }

    public function test_import_external_blogs(): void
    {
        $email_address='arno.coetzee.admin@gmail.com';
        $password='arnocoetzee';
        $user_name='Admin';
    
        $created_user = User::updateOrCreate(
            [
                'email' => $email_address
            ],
            [
                'password' => Hash::make($password),
                'name' => $user_name, 
            ]  
        );
        $this->actingAs($created_user)
        ->json('GET', 'blog/import')
        ->assertStatus(201);

        $this->assertTrue(true);
    }
}
