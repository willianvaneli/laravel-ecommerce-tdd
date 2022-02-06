<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function storeProduct(Product $product = null){
        return $this->post('products', $product->toArray());
    }

    public function test_only_logged_user_can_see_products_list()
    {
        $response = $this->get('/products')
            ->assertRedirect('/login');
    }

    public function test_if_product_columns_is_correct()
    {
        
        $product = Product::factory()->create();
        $product = $product->toArray();
        
        $expected = [
            'id',
            'name',
            'description',
            'price',
            'created_at',
            'updated_at'
        ];

        $arrayCompared = array_diff($expected, array_keys($product));
        
        $this->assertEquals(0, count($arrayCompared));

    }

    public function test_models_can_be_instantiated()
    {
        $product = Product::factory()->make();
        $this->assertContainsOnlyInstancesOf(Product::class,[$product],'Instância não é um produto');
        
    }
    
    public function test_it_should_be_authenticated()
    {
        $response = $this->get('/products/create')
            ->assertRedirect('/login');
        
    }
    
        
    public function test_it_should_store_in_database()
    {
        //trabalhando com data
        Carbon::setTestNow(now());

        //test
        $product = Product::factory()->make();
        $response = $this->actingAs( User::factory()->create())
            ->post('/products', $product->toArray())
            ->assertRedirect('/products');

        $product->created_at = now();
        $product->updated_at = now();

        $this->assertDatabaseHas('products',[
            'name' => $product->name,
            'description' => $product->description,
            'price'  => $product->price,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }

    public function test_name_field_is_required()
    {
        $user = User::factory()->create();

        $product = Product::factory()->make(['name'=>null]);
        $response = $this->actingAs($user)
            ->storeProduct($product)
            ->assertSessionHasErrors([
                // Verifica se o erro veio com o atributo nome e a mensagem
                // trans é o local onde pega a mensagem - validation.php
                'name' => trans('validation.required',['attribute' => 'name'])
            ]);

    }

    public function test_name_field_is_unique()
    {
        Product::factory()->create(['name'=>'Ambrosio']);
        $product = Product::factory()->make(['name'=>'Ambrosio']);
        $response = $this->actingAs(User::factory()->create())
            ->storeProduct($product)
            ->assertSessionHasErrors([
                // Verifica se o erro veio com o atributo nome e a mensagem
                // trans é o local onde pega a mensagem - validation.php
                'name' => trans('validation.unique',['attribute' => 'name'])
            ]);
    }

    public function test_description_is_optional()
    {
        //trabalhando com data
        Carbon::setTestNow(now());

        //test
        $product = Product::factory()->make(['description' => null]);
        $this->actingAs( User::factory()->create())
            ->post('/products', $product->toArray())
            ->assertRedirect('/products');
        

        $product->created_at = now();
        $product->updated_at = now();

        $this->assertDatabaseHas('products',[
            'name' => $product->name,
            'description' => $product->description,
            'price'  => $product->price,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }

    public function test_price_field_is_required()
    {
        $product = Product::factory()->make(['price'=>null]);
        $this->actingAs(User::factory()->create())
            ->storeProduct($product)
            ->assertSessionHasErrors([
                // Verifica se o erro veio com o atributo nome e a mensagem
                // trans é o local onde pega a mensagem - validation.php
                'price' => trans('validation.required',['attribute' => 'price'])
        ]);
    }

   
    public function test_price_field_is_positive_integer()
    {
        $product = Product::factory()->make(['price'=> -1]);
        $this->actingAs(User::factory()->create())
            ->storeProduct($product)
            ->assertSessionHasErrors([
                // Verifica se o erro veio com o atributo nome e a mensagem
                // trans é o local onde pega a mensagem - validation.php
                'price' => trans('validation.min.numeric',['attribute' => 'price', 'min'=> 0])
        ]);

        $this->actingAs(User::factory()->create())
            ->storeProduct($product)
            ->assertSessionHasErrors([
                // Verifica se o erro veio com o atributo nome e a mensagem
                // trans é o local onde pega a mensagem - validation.php
                'price' => trans('validation.integer',['attribute' => 'price'])
        ]);
    }

}
