<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $product;
    private $company;
    private $category;

    public function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['user_id' => $this->user->id]);
        $this->company = Company::factory()->create(['user_id' => $this->user->id]);
        $this->product = Product::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);
    }

    public function test_index(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/products');

        $response->assertOk();
    }

    public function test_show(): void 
    {
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/products/' . $this->product->id);

        $response->assertOk();
    }

    public function test_store(): void 
    {
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/products', [
            'name' => 'Test name',
            'description' => 'Test description',
            'price' => 200,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('products', [
            'name' => 'Test name',
            'description' => 'Test description',
            'price' => 200,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);
    }

    public function test_update(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->put('/api/products/' . $this->product->id, [
            'name' => 'New name',
            'description' => 'New description',
            'price' => 250,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('products', [
            'name' => 'New name',
            'description' => 'New description',
            'price' => 250,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);
    } 

    public function test_destroy(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->delete('/api/products/' . $this->product->id);

        $response->assertOk();
    } 
}
