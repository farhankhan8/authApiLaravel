<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request) {
        $data = $request->all();
        $user_id = auth('api')->user()->id;

            $user = Product::create([
                'name' => $data['name'],
                'detail' => $data['detail'],
                'user_id' => $user_id
            ]);

            return response([ 'detail' => $user]);
            }
}
