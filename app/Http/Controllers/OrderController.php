<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $pagetitle = 'Orders';
        // $orders = Orders::where('is_deleted', 0)->get();
        return view('order.index', compact('pagetitle'));
    }

    public function data()
    {
        $filter_area = request('filter_area');
        $filter_date = request('filter_date');
        $filter_time = request('filter_time');

        $start = request('iDisplayStart');
        $limit = request('iDisplayLength');
        $search = request('sSearch');
        $sort_col = request('iSortCol_0');
        $sort = request('sSortDir_0');

        if ($sort_col == 0) {
            $sort_col = 'order_hash_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'created_date';
        }
        if ($sort_col == 2) {
            $sort_col = 'user_token';
        }
        if ($sort_col == 3) {
            $sort_col = 'user_address_id';
        }
        if ($sort_col == 4) {
            $sort_col = 'contact_name';
        }
        if ($sort_col == 5) {
            $sort_col = 'contact_number';
        }
        if ($sort_col == 6) {
            $sort_col = 'warehouse_id';
        }
        if ($sort_col == 7) {
            $sort_col = 'local_area_id';
        }
        if ($sort_col == 8) {
            $sort_col = 'driver_token';
        }
        if ($sort_col == 9) {
            $sort_col = 'delivery_time';
        }
        if ($sort_col == 10) {
            $sort_col = 'order_status';
        }

        $orders = Orders::with(['driver', 'user', 'address' => function($add) {
            $add->with(['warehouse', 'local_area']);
        }]);

        if (!empty($search)) {
            $orders->where(function ($query) use ($search) {
                $query->where('contact_name', 'like', '%' . $search . '%')
                    ->orWhere('contact_number', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($user_query) use($search){
                        $user_query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('driver', function ($driver_query) use($search){
                        $driver_query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('address', function ($address_query) use($search){
                        $address_query->where('address_line1', 'like', '%' . $search . '%')
                            ->orWhereHas('warehouse', function ($ware_query) use($search){
                                $ware_query->where('warehouse_name', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('local_area', function ($area_query) use($search){
                                $area_query->where('delivery_area_name', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        if($filter_area) {
            $orders->WhereHas('address', function ($address_query) use($filter_area){
                $address_query->whereHas('local_area', function ($area_query) use($filter_area){
                    $area_query->where('delivery_area_id', $filter_area);
                });
            });
        }

        if($filter_date) {
            $orders->whereDate('delivery_time', $filter_date);
        }

        if($filter_time) {
            $orders->whereTime('delivery_time', $filter_time);
        }

        $recordsFiltered = $orders->count();

        $data = $orders->offset($start)->limit($limit)
            ->orderBy($sort_col, $sort)
            ->get();

        $recordsTotal = Orders::count();

        $record = array();
        $k = 0;
        foreach ($data as $value) {

            $date = new DateTime($value->created_date);
            $formattedDate = $date->format('d M, Y h:i A');

            $deliveryFormattedDate = "";
            if($value->delivery_time != '0000-00-00 00:00:00') {
                $delivery_date = new DateTime($value->delivery_time);
                $deliveryFormattedDate = $delivery_date->format('d M, Y h:i A');
            }

            // $assign = '';
            // if ($value->driver == null) {
            //     $assign = '<input class="form-control assign_to_driver_id" type="checkbox" data-order_id="' . $value->order_id . '" >';
            // }

            $action = '';
            $action .= '<a href="javascript:void(0)" data-toggle="modal" data-target="#add_contact_details" data-order_id= ' . $value->order_id . ' class="btn btn-success mr-3 edit_contact_details" title="Add Details">Details</a>';

            $record[$k]['order_id'] = $value->order_hash_id;
            $record[$k]['order_date'] = $formattedDate;
            $record[$k]['user'] = $value->user ? ($value->user->first_name . ' ' . $value->user->last_name) : "";
            $record[$k]['address'] = $value->address ? (Str::limit($value->address->address_line1, 15, '...')) : "";
            $record[$k]['contact_name'] = $value->contact_name ?? "";
            $record[$k]['contact_number'] = $value->contact_number ?? "";
            $record[$k]['warehouse'] = $value->address ? ($value->address->warehouse ? $value->address->warehouse->warehouse_name : "") : "";
            $record[$k]['local_area'] = $value->address ? ($value->address->local_area ? $value->address->local_area->delivery_area_name : "") : "";
            $record[$k]['driver'] = $value->driver ? ($value->driver->first_name . ' ' . $value->driver->last_name) : "";
            $record[$k]['delivery_date'] = $deliveryFormattedDate;
            $record[$k]['order_status'] = $value->order_status;
            $record[$k]['order_action'] = $action;
            // $record[$k]['driver_assign'] = $assign;
            $k++;
        }

        $result['data'] = $record;
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['sEcho'] = request('sEcho');

        echo json_encode($result);
        exit(0);

    }

    public function contact_edit(Request $request) {
        $order_id = $request->order_id;
        $order = Orders::where('order_id', $order_id)->with(['driver', 'user', 'address', 'warehouse', 'local_area'])->first();

        $result['contact_name'] = $order->contact_name;
        $result['contact_number'] = $order->contact_number;
        $result['area_zone'] = $order->area_zone;
        $result['warehouse_zone'] = $order->warehouse_id;
        $result['local_area_id'] = $order->local_area_id;
        $result['driver_token'] = $order->driver ? $order->driver->user_token : "";
        $result['delivery_time'] = $order->delivery_time ?? "";
        $result['products'] = $order->products;
        $result['item_amount'] = $order->item_amount ?? 0;
        $result['taxes'] = $order->taxes ?? 0;
        $result['delivery_charge'] = $order->delivery_charge ?? 0;
        $result['total_amount'] = $order->total_amount ?? 0;
        $result['status'] = true;

        echo json_encode($result);
        exit(0);
    }

    public function contact_update(Request $request) {

        $contact_order_id = $request->contact_order_id;
        $contact_name = $request->contact_name;
        $contact_number = $request->contact_number;
        $area_zone = $request->area_zone;
        $local_area_id = $request->local_area_id;
        $warehouse_zone = $request->warehouse_zone;
        $delivery_time = $request->delivery_time;
        $assigned_driver = $request->assigned_driver;

        $order_detail = Orders::where('order_id', $contact_order_id)->first();

        $data = [
            'contact_name' => $contact_name ?? "",
            'contact_number' => $contact_number ?? "",
            'area_zone' => $area_zone ?? "",
            'local_area_id' => $local_area_id ?? "",
            'warehouse_id' => $warehouse_zone ?? "",
            'delivery_time' => $delivery_time ?? "0000-00-00 00:00:00",
            'driver_token' => $assigned_driver ?? "",
            'order_status' => 'PROCESSING',
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $order_detail->update($data);

        $result['status'] = true;
        $result['msg'] = 'Contact Data updated successfully';

        echo json_encode($result);
        exit(0);
    }

    // public function driver_assign(Request $request) {
    //     $order_ids = $request->orderIds;
    //     $driver_id = $request->driver_id;

    //     foreach ($order_ids as $ord_id) {
    //         $order_detail = Orders::where('order_id', $ord_id)->first();

    //         $order_detail->update([
    //             'driver_token' => $driver_id
    //         ]);
    //     }

    //     $result['status'] = true;
    //     $result['msg'] = 'Assigned to Driver Successfully';

    //     echo json_encode($result);
    //     exit(0);
    // }
}
