<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryArea;

class DeliveryAreaController extends Controller
{
    public function index()
    {
        $pagetitle = 'Delivery Areas';
        $delivery_areas = DeliveryArea::where('is_deleted', 0)->get();
        return view('delivery_area.index', compact('pagetitle', 'delivery_areas'));
    }

    public function create()
    {
        $pagetitle = 'Warehouse Create';
        return view('delivery_area.create', compact('pagetitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_area_name' => 'required',
        ]);

        $data = [
            'delivery_area_name' => $request->delivery_area_name ,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        DeliveryArea::create($data);
        return redirect()->route('delivery.area.index')->with('success', 'Delivery Area created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Delivery Area Edit';
        $delivery_area = DeliveryArea::where('delivery_area_id', $id)->first();

        if (!$delivery_area) {
            return redirect()->route('delivery.area.index')->with('error', 'Delivery Area Not Found');
        }

        return view('delivery_area.edit', compact('pagetitle', 'delivery_area'));
    }

    public function update(Request $request, $id)
    {
        $delivery_area = DeliveryArea::where('delivery_area_id', $id)->first();

        if (!$delivery_area) {
            return redirect()->route('delivery.area.index')->with('error', 'Delivery Area Not Found');
        }

        $request->validate([
            'delivery_area_name' => 'required',
        ]);

        $data = [
            'delivery_area_name' => $request->delivery_area_name ,
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $delivery_area->update($data);

        return redirect()->route('delivery.area.index')->with('success', 'Delivery Area updated successfully!');
    }

    public function destroy($id)
    {
        $delivery_area = DeliveryArea::where('delivery_area_id', $id)->first();
        if($delivery_area->is_deleted == 0) {
            $delivery_area->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('delivery.area.index')->with('success', 'Delivery Area deleted successfully!');
        } else {
            $delivery_area->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('delivery.area.index')->with('success', 'Delivery Area restored successfully!');
        }
    }
}
