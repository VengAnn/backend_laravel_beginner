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
        $data = $request->all();

        $request-> validate([
            'name'=> 'required',
            // 'description'=> 'required',
            'price'=> 'required',
        ]);

        //store path image on db and image store on server 
        if($request->hasFile('image')) {
            $image = $request-> file('image');

           // $originalName = $image->getClientOriginalName();
            //rename with orignal name and timestamp
           // $name =time().'.'.$image->getClientOriginalName();

            //rename if alot user request can be same path ,so we can rename 
            $name = time().'.'.$image -> getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        // $product = Product::create($request->all());
        $product = Product::create($data);
        return response()->json(['data' => $product],201);
    }

    //to update data in db
    public function update(Request $request, $id){
        $data = $request->all();
        $product = Product::find($id);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            //rename if alot user request can be same path ,so we can rename 
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image ->move($destinationPath , $name);
            $data['image'] = $name;
            
            //for replace on oldImage
            $oldImage = public_path('/images/'.$product->image);
            //if image already has we unlink oldImage and replace with new image
            if(file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
        // $product -> update($request->all());
        $product -> update($data);
        return response()->json(['data' => $product],200);
    }

    //delete data in db
    public function destroy($id) {
        $product = Product::find($id);
        //check if not have id=null
        if($product == null){
           return response()->json(['message' => 'Product not found!'],404);
        }

        //check if images exists delete
        $image = public_path('/images/'.$product->image);
        if(file_exists($image)){
            unlink($image);
        }
        $product -> delete();
        return response()->json(['data' => $product],200);
    }
}
