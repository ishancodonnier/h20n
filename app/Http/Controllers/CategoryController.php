<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function index()
    {
        $pagetitle = 'Categories';
        $categories = ProductCategories::get();
        return view('category.index', compact('pagetitle', 'categories'));
    }

    public function create()
    {
        $pagetitle = 'Category Create';
        return view('category.create', compact('pagetitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_name' => 'required',
        ]);

        $data = [
            'product_category_name' => $request->product_category_name,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        ProductCategories::create($data);
        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Category Edit';
        $category = ProductCategories::where('product_category_id', $id)->first();

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Category Not Found');
        }

        return view('category.edit', compact('pagetitle', 'category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategories::where('product_category_id', $id)->first();

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Category Not Found');
        }

        $request->validate([
            'product_category_name' => 'required',
        ]);

        $data = [
            'product_category_name' => $request->product_category_name,
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $category->update($data);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = ProductCategories::where('product_category_id', $id)->first();
        if($category->is_deleted == 0) {
            $category->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        } else {
            $category->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('category.index')->with('success', 'Category restored successfully!');
        }
    }
}
