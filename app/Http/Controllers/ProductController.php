<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //get all to show
    public function index() {
        $products = Product::all();
        return response()->json(['data'=> $products],200);
    }

    //insert to db
    public function store(Request $request) {
        $request-> validate([
            'name'=> 'required',
            // 'description'=> 'required',
            'price'=> 'required',
        ]);
        $product = Product::create($request->all());
        return response()->json(['data' => $product],201);
    }

    //to update data in db
    public function update(Request $request, $id){
        $product = Product::find($id);
        $product -> update($request->all());
        return response()->json(['data' => $product],200);
    }

    //delete data in db
    public function destroy($id) {
        $product = Product::find($id);
        $product -> delete();
        return response()->json(['data' => $product],200);
    }
}
