<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\invoice;
use App\Http\Requests\StoreinvoiceRequest;
use App\Http\Requests\UpdateinvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = DB::table('users')
            ->join('tbl_invoices', 'users.id', '=', 'tbl_invoices.id_customer')
            ->join('tbl_products', 'tbl_invoices.id_product', '=', 'tbl_products.id')
            ->where('users.id', '=', auth()->user()->id)
            ->get(['tbl_products.name', 'tbl_products.price', 'tbl_products.image', 'tbl_invoices.quantity', 'tbl_invoices.total']);

        return $invoice;
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
     * @param  \App\Http\Requests\StoreinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreinvoiceRequest $request)
    {

        // try {

        $AllProducts = ProductController::GetAllProductsFornecedor();
        $SubmitInvoice = $request->all();

        foreach ($SubmitInvoice as $key => $products) {


            $id_product  = $products['id'];

            $productInfos = array_filter($AllProducts, function ($var) use ($id_product) {
                if ($var['id'] === $id_product) {
                    return $var;
                }
            });

            $ProductSave = array(
                'id_product_ext' => $productInfos[0]["id"],
                'name' => $productInfos[0]["nome"],
                'description' => $productInfos[0]["descricao"],
                'category' => $productInfos[0]["categoria"],
                'price' => $productInfos[0]["preco"],
                'image' => $productInfos[0]["imagem"],
            );

            //verifica se o produto já existe
            $product = Products::where('id_product_ext', $productInfos[0]["id"])->first();
            if (!$product) {
                $product = Products::create($ProductSave);
            }

            $invoice = Invoice::create([
                'id_product' => $product->id,
                'id_customer' => auth()->user()->id,
                'quantity' => $products['qty'],
                'total' => $products['qty'] * $productInfos[0]["preco"],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Invoice Created successfully!",
            'data' => $SubmitInvoice
        ], 200);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $th->getMessage()
        //     ], 500);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinvoiceRequest  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateinvoiceRequest $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice $invoice)
    {
        //
    }
}
