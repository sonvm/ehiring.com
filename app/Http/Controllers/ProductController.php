<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function create()
    {
        return view('fontend.product.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'price'      => 'required|numeric',
            'content'    => 'required',
            'image_path' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('product/create')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            // Lưu thông tin vào database, phần này sẽ giới thiệu ở bài về database
            
            // $active = $request->has('active')? 1 : 0;
            // $product_id = DB::table('products')->insertGetId([
            //     'name'       => $request->input('name'),
            //     'price'      => $request->input('price'),
            //     'content'    => $request->input('content'),
            //     'image_path' => $request->input('image_path'),
            //     'active'     => $active
            //     ]);

            
        $product          = new Product;
        $product->name    = $request->input('name');
        $product->price   = $request->input('price');
        $product->content = $request->input('content');
        $product->active  = $request->has('active')? 1 : 0;
        $product->save();

            return redirect('product/create')
                    ->with('message', 'Sản phẩm được tạo thành công');
        }
    }

    public function index()
    {
        // $products = DB::table('products')->get();
        $products = Product::all();
        return view('fontend.product.list')->with('products',$products);
    }

    public function edit($id)
{
    $product = DB::table('products')->find($id);
    return view('fontend.product.edit')->with(compact('product'));
}

public function update(Request $request, $id)
{
    $active = $request->has('active')? 1 : 0;
    // $updated = DB::table('products')
    //     ->where('id', '=', $id)
    //     ->update([
    //         'name'       => $request->input('name'),
    //         'price'      => $request->input('price'),
    //         'content'    => $request->input('content'),
    //         'image_path' => $request->input('image_path'),
    //         'active'     => $active,
    //         'updated_at' => \Carbon\Carbon::now()
    //         ]);

    $product_id     = $id;
    $product        = Product::find($product_id);
    $product->name  = $request->input('name');
    $product->price = $request->input('price');
    $product->save();

    return Redirect::back()
        ->with('message', 'Cập nhật sản phẩm thành công')
        ->withInput(); 
    
}

}
