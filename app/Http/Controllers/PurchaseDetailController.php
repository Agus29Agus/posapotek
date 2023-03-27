<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        $id_purchase = session('id_purchase');
        $product = Product::orderBy('name_product')->get();
        $supplier = Supplier::findOrFail(session('id_supplier'));
        $discount = Purchase::find($id_purchase)->discount ?? 0;

        // if (! $supplier) {
        //     abort(404);
        // }

        return view('purchase_detail.index', compact('id_purchase', 'product', 'supplier', 'discount'));
        
    }

    public function data($id)
    {
        $detail = PurchaseDetail::with('product')
            ->where('id_purchase', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['code_product'] = '<span class="label label-success">'. $item->product['code_product'] .'</span';
            $row['name_product'] = $item->product['name_product'];
            $row['buy_price']  = 'Rp. '. money_format($item->buy_price);
            $row['total']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_purchase_detail .'" value="'. $item->total .'">';
            $row['subtotal']    = 'Rp. '. money_format($item->subtotal);
            $row['action']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('purchase_detail.destroy', $item->id_purchase_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->buy_price * $item->total;
            $total_item += $item->total;
        }
        $data[] = [
            'code_product' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'name_product' => '',
            'buy_price'  => '',
            'total'      => '',
            'subtotal'    => '',
            'action'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'code_product', 'total'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where('id_product', $request->id_product)->first();
        if (! $product) {
            return response()->json('Could not save data', 400);
        }

        $detail = new PurchaseDetail();
        $detail->id_purchase = $request->id_purchase;
        $detail->id_product = $product->id_product;
        $detail->buy_price = $product->buy_price;
        $detail->total = 1;
        $detail->subtotal = $product->buy_price;
        $detail->save();

        return response()->json('Data Submitted', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PurchaseDetail::find($id);
        $detail->total = $request->total;
        $detail->subtotal = $detail->buy_price * $request->total;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PurchaseDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($discount, $total,$cost)
    {
        $pay = $total - ($discount / 100 * $total) + (int)$cost;
        $data  = [
            'totalrp' => money_format($total),
            'pay' => $pay,
            'payrp' => money_format($pay),
            'counted' => ucwords(counted($pay). ' Rupiah')
        ];

        return response()->json($data);
    }
}