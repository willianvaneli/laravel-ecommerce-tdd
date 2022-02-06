<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(){
        return view('product.create');
    }

    

     /**
     * Create products
     * @OA\Post (
     *     path="products/{id}/create",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="guarda roupa c225"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string",
     *                          example="guarda roupa de casal duas portas"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="integer",
     *                          example="2000"
     *                      )
     *                 )
     *             )
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="success",
     *           @OA\JsonContent(
     *              @OA\Property(property="id", type="string"),
     *          )
     *      )
     *  )
    */
    public function store(Request $request){

        $this->validate($request, [
            'name'=> 'required|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0'
        ]);

        $product = new Product();
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];

        $product->save();

        return redirect('products');
    }

    public function index(Request $request){
        $products = Product::all();
        return view('product.index', compact(['products', $products]));
    }

    public function show($id){
        $product = Product::findOrFail($id);
        
        return view('product.show', compact(['product', $product]));
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        
        return view('product.edit', compact(['product', $product]));
    }
    
    public function update(Request $request){

        $this->validate($request, [
            'name'=> 'required|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0'
        ]);
        $product = Product::findOrFail($request['id']);
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];

        $product->save();

        return redirect('products');
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('products');
    }

    public function faker(Request $request){
        $products = Product::factory()->count(3)->create();

        return response()->json([
            'status' => 201,            
        ]);
    }
    
}
