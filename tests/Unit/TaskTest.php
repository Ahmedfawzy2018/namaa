<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker;

    protected $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user  = newUser();
    }

    public function test_should_user_can_login_successfully()
    {
        $this->postJson(route("user.login"), [
            'email' => $this->user->email,
            'password' => 'password',
        ])->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => ['token']]);
    }

    public function test_should_get_articles_successfully()
    {
        $this->actingAs($this->user)
            ->getJson(route("articles.index"))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => ['records']]);
    }


    public function test_should_create_article_successfully()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route("articles.store"), [
                'title' => 'test one',
                'content' => "HI content",
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);
    }

    public function test_should_update_articles_successfully()
    {

        $result = $this->actingAs($this->user)
            ->postJson(route("articles.store"), [
                'title' => 'test one',
                'content' => "HI content",
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);

        $this->actingAs($this->user)
            ->putJson(route("articles.update",
                [
                    'id' => $result->getData()->data->id
                ]),[

                'title' => 'test new One',
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);

        $response = $this->actingAs($this->user)
            ->getJson(route("articles.show", [
                'id' => $result->getData()->data->id
            ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);
    }

    public function test_should_delete_articles_successfully()
    {
        $result = $this->actingAs($this->user)
            ->postJson(route("articles.store"), [
                'title' => 'test one',
                'content' => "HI content",
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);

        $this->actingAs($this->user)
            ->deleteJson(route("articles.destroy",
                [
                    'id' => $result->getData()->data->id
                ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(["data" => []]);

        $this->actingAs($this->user)
            ->getJson(route("articles.show", [
                'id' => $result->getData()->data->id
            ]))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }


}
