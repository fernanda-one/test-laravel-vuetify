<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCreateRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(TransactionCreateRequest $request){
        $data = $request->validated();
        $customer = User::where('id', $data['customer_id'])->first();
        if (!$customer) {
            return response([
                'status'=>false,
                'message'=>'customer not found!',
                'data'=>null
            ],404);
        }
        $product = Product::where('id', $data['product_id'])->first();
        if (!$product) {
            return response([
                'status'=>false,
                'message'=>'product not found!',
                'data'=>null
            ],404);
        }
        $noInvoice = $this->generateInvoiceNumber();
        $transaction = Transaction::where('customer_id', $data['customer_id'])->orderBy('created_at', 'desc')->first();
        if($transaction){
            $noInvoice = $this->generateInvoiceNumber($transaction['reference_number']);
        }
        $totalAmount = $product['price'] * $data['quantity'];
        $data['reference_number'] = $noInvoice;
        $data['total_amount'] = $totalAmount;
        $result = new Transaction($data);
        $result->save();
        return response([
            'status'=>true,
            'message'=>'transaction succesfully',
            'data'=>$result
        ]);
    }

    public function getAll(Request $request){
        $data = Transaction::query();
        $id =$request['customer_id'];
        $page =$request['page']??1;
        $limit =$request['limit']??10;
        if(!empty($request['search'])){
            $search = "%" . $request['search'] . "%";
            $data->where('name', 'like', $search);
            $data->orWhere('reference_number', 'like',$search);
        }
        $data->with('product'); 
        $data->where('customer_id', $id);
        $data->orderBy('created_at', 'desc');
        $transaction = $data->paginate(perPage:$limit, page:$page);
        return response([
            'status'=>true,
            'message'=>'succesfull',
            'data'=>$transaction
        ]);
    }
    private function generateInvoiceNumber($lastInvoiceNumber = '') {
        $currentMonth = date('m');
        $currentYear = date('Y');
    
        if (!empty($lastInvoiceNumber)) {
            $parts = explode('-', $lastInvoiceNumber);
            
            $lastMonthYear = $parts[1] . '-' . $parts[2];
            $lastNumber = (int) $parts[3];
            
            if ($lastMonthYear == $currentMonth . '-' . $currentYear) {
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $newNumberPadded = str_pad($newNumber, strlen($parts[3]), '0', STR_PAD_LEFT);
            
            $newInvoiceNumber = 'INV-' . $currentMonth . '-' . $currentYear . '-' . $newNumberPadded;
        } else {
            $newInvoiceNumber = 'INV-' . $currentMonth . '-' . $currentYear . '-0001'; 
        }
        return $newInvoiceNumber;
    }
    
}
