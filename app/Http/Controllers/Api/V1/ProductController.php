<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Products;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $AllProducts = $this->GetAllProductsFornecedor();

        return $AllProducts;
    }


    public static function GetAllProductsFornecedor()
    {
        $responseBrazilian = Http::get('http://616d6bdb6dacbb001794ca17.mockapi.io/devnology/brazilian_provider');
        $jsonDataBrazilian = $responseBrazilian->json();

        $responseEuropean = Http::get('http://616d6bdb6dacbb001794ca17.mockapi.io/devnology/european_provider');
        $jsonDataEuropean = $responseEuropean->json();

        //foreach array 2 and push to array 1
        $arr = array();
        foreach ($jsonDataEuropean as $key => $value) {
            array_push(
                $jsonDataBrazilian,
                array(
                    'id' => strval(count($jsonDataBrazilian) + 1),
                    'nome' => $value['name'],
                    'descricao' => $value['description'],
                    'categoria' => 'Europa',
                    'imagem' => $value['gallery'][0],
                    'preco' => $value['price'],
                    'company' => 'european_provider',
                )

            );
        }

        return $jsonDataBrazilian;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreproductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreproductRequest $request)
    {
        //
        try {
            $product = Products::create($request->all());
            return (new ProductResource($product))
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Models\products  $product
     * @return \Illuminate\Http\Response
     */
    // public function show(products $product)
    public function show($id)
    {
        $AllProducts = $this->GetAllProductsFornecedor();

        $product = array_filter($AllProducts, function ($var) use ($id) {
            if ($var['id'] === $id) {
                return $var;
            }
        });

        return $product;
        // return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Models\products  $product
     * @return \Illuminate\Http\Response
     */
    // public function show(products $product)
    public function category()
    {
        $AllProducts = $this->GetAllProductsFornecedor();
        $Categoria = array_unique(array_column($AllProducts, 'categoria'));

        return $Categoria;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(products $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductRequest  $request
     * @param  \App\Models\products  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateproductRequest $request, products $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(products $product)
    {
        //
    }
}
