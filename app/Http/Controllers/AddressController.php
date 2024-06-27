<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    public function index() {
        $pagetitle = 'User Address';
        return view('address.index', compact('pagetitle'));
    }

    public function data(Request $request) {

        $start = request('iDisplayStart');
        $limit = request('iDisplayLength');
        $search = request('sSearch');
        $sort_col = request('iSortCol_0');
        $sort = request('sSortDir_0');

        if ($sort_col == 0) {
            $sort_col = 'user_address_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'full_name';
        }
        if ($sort_col == 2) {
            $sort_col = 'address_line1';
        }
        if ($sort_col == 3) {
            $sort_col = 'city';
        }
        if ($sort_col == 4) {
            $sort_col = 'state';
        }
        if ($sort_col == 5) {
            $sort_col = 'zip_code';
        }
        if ($sort_col == 6) {
            $sort_col = 'address_type';
        }

        $address = UserAddress::with(['user', 'warehouse', 'local_area']);

        if (!empty($search)) {
            $address->where(function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('address_line1', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('state', 'like', '%' . $search . '%')
                    ->orWhere('zip_code', 'like', '%' . $search . '%')
                    ->orWhere('address_type', 'like', '%' . $search . '%')
                    ->orWhereHas('warehouse', function ($ware_query) use($search){
                        $ware_query->where('warehouse_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('local_area', function ($area_query) use($search){
                        $area_query->where('delivery_area_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $recordsFiltered = $address->count();

        $data = $address->offset($start)->limit($limit)
            ->orderBy($sort_col, $sort)
            ->get();

        $recordsTotal = UserAddress::count();

        $record = array();
        $k = 0;
        foreach ($data as $value) {
            $action = '';
            $action .= '<a href="javascript:void(0)" data-toggle="modal" data-target="#add_warehouse_details" data-user_address_id= ' . $value->user_address_id . ' class="btn btn-success mr-3 edit_warehouse_details" title="Add Details">Details</a>';

            $record[$k]['id'] = $value->user_address_id;
            $record[$k]['user'] = $value->full_name ?? "" ;
            $record[$k]['address'] = Str::limit($value->address_line1, 25, '...') ?? "" ;
            $record[$k]['city'] = $value->city ?? "";
            $record[$k]['state'] = $value->state ?? "";
            $record[$k]['zip_code'] = $value->zip_code ?? "";
            $record[$k]['address_type'] = $value->address_type ?? "";
            $record[$k]['warehouse'] = $value->warehouse ? $value->warehouse->warehouse_name : "";
            $record[$k]['local_area'] = $value->local_area ? $value->local_area->delivery_area_name : "";
            $record[$k]['action'] = $action;
            $k++;
        }

        $result['data'] = $record;
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['sEcho'] = request('sEcho');

        echo json_encode($result);
        exit(0);
    }

    public function warehouse_edit(Request $request) {
        $user_address_id = $request->user_address_id;
        $order = UserAddress::where('user_address_id', $user_address_id)->with(['user'])->first();

        $result['area_zone'] = $order->area_zone;
        $result['warehouse_zone'] = $order->warehouse_id;
        $result['local_area_id'] = $order->local_area_id;
        $result['status'] = true;

        echo json_encode($result);
        exit(0);
    }

    public function warehouse_update(Request $request) {

        $user_address_id = $request->user_address_id;
        $area_zone = $request->area_zone;
        $local_area_id = $request->local_area_id;
        $warehouse_zone = $request->warehouse_zone;

        $order_detail = UserAddress::where('user_address_id', $user_address_id)->first();

        $data = [
            'area_zone' => $area_zone ?? null,
            'local_area_id' => $local_area_id ?? "",
            'warehouse_id' => $warehouse_zone ?? "",
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $order_detail->update($data);

        $result['status'] = true;
        $result['msg'] = 'Warehouse updated successfully';

        echo json_encode($result);
        exit(0);
    }
}
