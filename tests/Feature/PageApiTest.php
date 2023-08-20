<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Page;

class PageApiTest extends TestCase
{
    
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Migrate the database for testing
        Artisan::call('migrate');
    }

    public function testGetPagesCount() {
    
        // Send a GET request to the API endpoint to retrieve the page by ID
        $response = $this->get("/pages");

        // Assert that the response has a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response JSON count
        $response->assertJsonCount(0, 'data');
    }

    public function testGetPageById() {
        // Create a page in the database (or use factory)
        $page = Page::create([
            'slug' => 'example-page',
            'title' => 'Example Page',
            'content' => 'This is the content of the example page',
        ]);

        // Send a GET request to the API endpoint to retrieve the page by ID
        $response = $this->get("/pages/{$page->id}");

        // Assert that the response has a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response JSON structure contains the expected keys and values
        $response->assertJson([
            'id' => $page->id,
            'slug' => $page->slug,
            'title' => $page->title,
            'content' => $page->content,
        ]);
    }

    public function testCreatePageAndCheckInsertion() {
        // Data to create a new page
        $pageData = [
            'slug' => 'new-page',
            'title' => 'New Page',
            'content' => 'This is the content of the new page',
        ];

        // Send a POST request to create the page via the API
        $response = $this->postJson('/pages', $pageData);

        // Assert that the response has a 201 (Created) status code
        $response->assertStatus(201);

        // Assert that the response JSON structure contains the expected keys and values
        $response->assertJsonStructure([
            'message',
            'data' => [
                'slug',
                'title',
                'content',
                'updated_at',
                'created_at',
                'id',
            ],
        ]);

        // Assert that the created data matches the provided data
        $this->assertDatabaseHas('pages', $pageData);
    }

    public function testDeletePage() {
        // Create a page in the database (or use factory)
        $page = Page::create([
            'slug' => 'example-page',
            'title' => 'Example Page',
            'content' => 'This is the content of the example page',
        ]);

        // Send a DELETE request to delete the page via the API
        $response = $this->delete("/pages/{$page->id}");

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the page no longer exists in the database
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function testUpdatePage() {
        // Create a page in the database (or use factory)
        $page = Page::create([
            'slug' => 'example-page',
            'title' => 'Example Page',
            'content' => 'This is the content of the example page',
        ]);

        // Data for updating the page
        $updatedData = [
            'slug' => 'updated-page',
            'title' => 'Updated Page',
            'content' => 'This is the updated content of the page',
        ];

        // Send a PUT request to update the page via the API
        $response = $this->putJson("/pages/{$page->id}", $updatedData);

        // Assert that the response has a 200 (OK) status code
        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Page updated successfully',
        ]);

        // Assert that the updated data exists in the database
        $this->assertDatabaseHas('pages', $updatedData);

        // Assert that the response JSON data matches the expected data
        $response->assertJsonFragment([
            'id' => $page->id,
            'slug' => $updatedData['slug'],
            'title' => $updatedData['title'],
            'content' => $updatedData['content'],
        ]);
    }
}
