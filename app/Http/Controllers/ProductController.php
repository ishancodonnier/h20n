<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $pagetitle = 'Products';
        $products = Products::where('is_deleted', 0)->with(['category'])->get();
        return view('product.index', compact('pagetitle', 'products'));
    }

    public function create()
    {
        $pagetitle = 'Product Create';
        $categories = ProductCategories::where('is_deleted', 0)->get();
        return view('product.create', compact('pagetitle', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'product_price' => 'required',
            'product_category_id' => 'required',
            'is_available' => 'required',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_description' => $request->description,
            'product_price' => $request->product_price,
            'product_category_id' => $request->product_category_id,
            'is_popular_product' => 0,
            'is_available' => $request->is_available,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $product = Products::create($data);

        if ($request->file('product_image')) {
            foreach ($request->file('product_image') as $key => $image) {
                $file = $image;
                $randomTime = str_shuffle(round(microtime(true)));
                $image_name = $randomTime . "." . $file->getClientOriginalExtension();
                $file->move('./../../app_images/product_images/', $image_name);

                $image_data = [
                    'product_id' => $product->product_id,
                    'product_resource_name' => $image_name,
                    'product_resource_secondary_name' => "",
                    'product_resource_type' => 'IMAGE',
                    'is_deleted' => 0,
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s'),
                ];
                ProductImages::create($image_data);
            }
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Product Edit';
        $categories = ProductCategories::where('is_deleted', 0)->get();
        $product = Products::where('product_id', $id)->with(['images'])->first();

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product Not Found');
        }

        return view('product.edit', compact('pagetitle', 'product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::where('product_id', $id)->first();

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product Not Found');
        }

        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'product_price' => 'required',
            'product_category_id' => 'required',
            'is_available' => 'required',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_description' => $request->description,
            'product_price' => $request->product_price,
            'product_category_id' => $request->product_category_id,
            'is_available' => $request->is_available,
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $product_images = ProductImages::where('product_id', $id)->get();

        if ($request->file('product_image')) {
            foreach ($product_images as $pro_img) {
                if (!in_array($pro_img->product_resource_id, $request->image_id)) {
                    $fileToDelete = './../../app_images/product_images' . $pro_img->product_resource_name;
                    if (file_exists($fileToDelete)) {
                        unlink($fileToDelete);
                    }
                    $pro_img->delete();
                }
            }

            foreach ($request->file('product_image') as $key => $image) {
                $file = $image;
                $randomTime = str_shuffle(round(microtime(true)));
                $image_name = $randomTime . "." . $file->getClientOriginalExtension();
                $file->move('./../../app_images/product_images/', $image_name);

                $image_data = [
                    'product_id' => $product->product_id,
                    'product_resource_name' => $image_name,
                    'product_resource_secondary_name' => "",
                    'product_resource_type' => 'IMAGE',
                    'is_deleted' => 0,
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_date' => date('Y-m-d H:i:s'),
                ];
                ProductImages::create($image_data);
            }
        }

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Products::where('product_id', $id)->first();
        if($product->is_deleted == 0) {
            $product->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
        } else {
            $product->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('product.index')->with('success', 'Product restored successfully!');
        }
    }

    public function popular($id)
    {
        $product = Products::where('product_id', $id)->first();
        if($product->is_popular_product == 0) {
            $product->update([
                'is_popular_product' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('product.index')->with('success', 'Product added in popular list!');
        } else {
            $product->update([
                'is_popular_product' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('product.index')->with('success', 'Product removed from popular list!');
        }
    }

    public function delete_image_from_resource($product_id, $product_resource_id)
    {
        ProductImages::where('product_resource_id', $product_resource_id)->where('product_id', $product_id)->delete();
        $result['status'] = 1;
        $result['msg'] = "Image deleted successfully";
        return response()->json($result, 200);
    }
}
