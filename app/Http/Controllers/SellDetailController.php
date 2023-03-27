<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Sell;
use App\Models\SellDetail;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class SellDetailController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('name_product')->get();
        $member = Member::orderBy('name')->get();
        $discount = Setting::first()->discount ?? 0;

        // Cek apakah ada transaction yang sedang berjalan
        if ($id_sell = session('id_sell')) {
            $sell = Sell::find($id_sell);
            $memberSelected = $sell->member ?? new Member();

            return view('sell_detail.index', compact('product', 'member', 'discount', 'id_sell', 'sell', 'memberSelected'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaction.new');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = SellDetail::with('product')
            ->where('id_sell', $id)
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['code_product'] = '<span class="label label-success">'. $item->product['code_product'] .'</span';
            $row['name_product'] = $item->product['name_product'];
            $row['sell_price']  = 'Rp. '. money_format($item->sell_price);
            $row['total']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_sell_detail .'" value="'. $item->total .'">';
            $row['discount']      = $item->discount . '%';
            $row['subtotal']    = 'Rp. '. money_format($item->subtotal);
            $row['action']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('transaction.destroy', $item->id_sell_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->sell_price * $item->total - (($item->discount * $item->total) / 100 * $item->sell_price);;
            $total_item += $item->total;
        }
        $data[] = [
            'code_product' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'name_product' => '',
            'sell_price'  => '',
            'total'      => '',
            'discount'      => '',
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
            return response()->json('Data could not submitted', 400);
        }

        $detail = new SellDetail();
        $detail->id_sell = $request->id_sell;
        $detail->id_product = $product->id_product;
        $detail->sell_price = $product->sell_price;
        $detail->total = 1;
        $detail->discount = $product->discount;
        $detail->subtotal = $product->sell_price - ($product->discount / 100 * $product->sell_price);;
        $detail->save();

        return response()->json('Data Submitted', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = SellDetail::find($id);
        $detail->total = $request->total;
        $detail->subtotal = $detail->sell_price * $request->total - (($detail->discount * $request->total) / 100 * $detail->sell_price);;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = SellDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($discount = 0, $total = 0, $received = 0,$tax =0)
    {
        // $pay = $total - ($discount / 100 * $total);
        $discountTotal = $total  - ($total * $discount/100) ;
        $pay = $discountTotal + ($discountTotal * $tax/100 );
        // $pay = $taxTotal + ($discount/100 * $taxTotal);
        // $tax = 11;
        // $pay = $total - $discount/100 + $tax/100;

        $change = ($received != 0) ? $received - $pay : 0;
        $data    = [
            'totalrp' => money_format($total),
            'pay' => $pay,
            'payrp' => money_format($pay),
            'counted' => ucwords(counted($pay). ' Rupiah'),
            'changerp' => money_format($change),
            'change_counted' => ucwords(counted($change). ' Rupiah'),
        ];

        return response()->json($data);
    }
}