<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $pagetitle = 'Warehouses';
        $warehouses = Warehouse::where('is_deleted', 0)->get();
        return view('warehouse.index', compact('pagetitle', 'warehouses'));
    }

    public function create()
    {
        $pagetitle = 'Warehouse Create';
        return view('warehouse.create', compact('pagetitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_name' => 'required',
            'warehouse_area' => 'required',
            'warehouse_zip_code' => 'required',
            'warehouse_address_line1' => 'required',
            'warehouse_lat' => 'required',
            'warehouse_lon' => 'required'
        ]);

        $data = [
            'warehouse_name' => $request->warehouse_name ,
            'warehouse_area' => $request->warehouse_area ,
            'warehouse_zip_code' => $request->warehouse_zip_code ,
            'warehouse_address_line1' => $request->warehouse_address_line1 ,
            'warehouse_address_line2' => $request->warehouse_address_line2 ,
            'warehouse_lat' => $request->warehouse_lat ,
            'warehouse_lon' => $request->warehouse_lon ,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        Warehouse::create($data);
        return redirect()->route('warehouse.index')->with('success', 'Warehouse created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Warehouse Edit';
        $warehouse = Warehouse::where('warehouse_id', $id)->first();

        if (!$warehouse) {
            return redirect()->route('warehouse.index')->with('error', 'Warehouse Not Found');
        }

        return view('warehouse.edit', compact('pagetitle', 'warehouse'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::where('warehouse_id', $id)->first();

        if (!$warehouse) {
            return redirect()->route('warehouse.index')->with('error', 'Warehouse Not Found');
        }

        $request->validate([
            'warehouse_name' => 'required',
            'warehouse_area' => 'required',
            'warehouse_zip_code' => 'required',
            'warehouse_address_line1' => 'required',
            'warehouse_lat' => 'required',
            'warehouse_lon' => 'required'
        ]);

        $data = [
            'warehouse_name' => $request->warehouse_name ,
            'warehouse_area' => $request->warehouse_area ,
            'warehouse_zip_code' => $request->warehouse_zip_code ,
            'warehouse_address_line1' => $request->warehouse_address_line1 ,
            'warehouse_address_line2' => $request->warehouse_address_line2 ,
            'warehouse_lat' => $request->warehouse_lat ,
            'warehouse_lon' => $request->warehouse_lon ,
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $warehouse->update($data);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully!');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::where('warehouse_id', $id)->first();
        if($warehouse->is_deleted == 0) {
            $warehouse->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully!');
        } else {
            $warehouse->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('warehouse.index')->with('success', 'Warehouse restored successfully!');
        }
    }
}
