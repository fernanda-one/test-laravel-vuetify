<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends Controller
{
    public function create(ProductCreateRequest $request){
        $data = $request->validated();
        $product = new Product($data);
        $product->save();
        return response([
            'status'=>true,
            'message'=>'create product successfully',
            'data'=>$product
        ],201);
    }
    public function update(ProductCreateRequest $request, $id){
        $data = $request->validated();
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return response([
                'status'=>false,
                'message'=>'product not found!',
                'data'=>null
            ],404);
        }
        $product->update($data);
        return response([
            'status'=>true,
            'message'=>'update product successfully',
            'data'=>(new ProductResource($product))
        ],200);
    }
    public function getAll(Request $request){
        $data = Product::query();
        $page =$request['page']??1;
        $limit =$request['limit']??10;
        if(!empty($request['search'])){
            $search = "%" . $request['search'] . "%";
            $data->where('name', 'like', $search);
            $data->orWhere('descripsi', 'like',$search);
        }
        $data->where('stock', '>=', 1);
        $data->orderBy('created_at', 'DESC');
        $product = $data->paginate();
        return response()->json($product)->setStatusCode(200);
    }
    public function getById($id){
        $product =  Product::where('id', $id)->first();
        if (!$product) {
            return response([
                'status'=>false,
                'message'=>'product not found!',
                'data'=>null
            ],404);
        }
        return response([
            'status'=>true,
            'message'=>'success',
            'data'=>(new ProductResource($product))
        ],200);
    }
    public function delete($id){
        $product =  Product::where('id', $id)->first();
        if (!$product) {
            return response([
                'status'=>false,
                'message'=>'product not found!',
                'data'=>null
            ],404);
        }
        Product::destroy($id);
        return response([
            'status'=>true,
            'message'=>'delete successfully',
            'data'=> null
        ],200);
    }
}
