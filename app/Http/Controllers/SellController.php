<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use App\Models\SellDetail;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use PDF;

class SellController extends Controller
{
    public function index()
    {
        return view('sell.index');
    }

    public function data()
    {
        $sell = Sell::with('member')->orderBy('id_sell', 'desc')->get();
        return datatables()
            ->of($sell)
            ->addIndexColumn()
            ->addColumn('total_item', function ($sell) {
                return money_format($sell->total_item);
            })
            ->addColumn('total_price', function ($sell) {
                return 'Rp. '. money_format($sell->total_price);
            })
            ->addColumn('pay', function ($sell) {
                return 'Rp. '. money_format($sell->pay);
            })
            ->addColumn('date', function ($sell) {
                return indonesian_date($sell->created_at, false);
            })
            ->addColumn('code_member', function ($sell) {
                $member = $sell->member->code_member ?? '';
                return '<span class="label label-success">'. $member .'</span>';
            })
            ->addColumn('tax', function ($sell) {
                return $sell->tax . '%';
            })
            ->editColumn('discount', function ($sell) {
                return $sell->discount . '%';
            })
            ->editColumn('cashier', function ($sell) {
                return $sell->user->name ?? '';
            })
            ->addColumn('action', function ($sell) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('sell.show', $sell->id_sell) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('sell.destroy', $sell->id_sell) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action', 'code_member'])
            ->make(true);
    }

    public function create()
    {
        $sell = Sell::create([
            'id_member'=> null,
            'id_user'=>auth()->id()
        ]);
        // $sell = new sell();
        // $sell->id_member = null;
        // $sell->total_item = 0;
        // $sell->total_price = 0;
        // $sell->discount = 0;
        // $sell->pay = 0;
        // $sell->receive = 0;
        // $sell->id_user = auth()->id();
        // $sell->save();

        session(['id_sell' => $sell->id_sell]);
        return to_route('transaction.index');
    }

    public function store(Request $request)
    {
        $sell = Sell::findOrFail($request->id_sell);
        $sell->id_member = $request->id_member;
        $sell->total_item = $request->total_item;
        $sell->total_price = $request->total;
        $sell->discount = $request->discount;
        $sell->tax = $request->tax;
        $sell->pay = $request->pay;
        $sell->receive = $request->receive;
        $sell->update();

        $detail = SellDetail::where('id_sell', $sell->id_sell)->get();
        foreach ($detail as $item) {
            $item->discount = $request->discount;
            $item->update();

            $product = Product::find($item->id_product);
            $product->stock -= $item->jumlah;
            $product->update();
        }

        return redirect()->route('transaction.done');
    }

    public function show($id)
    {
        $detail = SellDetail::with('product')->where('id_sell', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code_product', function ($detail) {
                return '<span class="label label-success">'. $detail->product->code_product .'</span>';
            })
            ->addColumn('name_product', function ($detail) {
                return $detail->product->name_product;
            })
            ->addColumn('buy_price', function ($detail) {
                return 'Rp. '. money_format($detail->buy_price);
            })
            ->addColumn('total', function ($detail) {
                return money_format($detail->total);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. money_format($detail->subtotal);
            })
            ->rawColumns(['code_product'])
            ->make(true);
    }

    public function destroy($id)
    {
        $sell = Sell::find($id);
        $detail    = SellDetail::where('id_sell', $sell->id_sell)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->id_product);
            if ($product) {
                $product->stock += $item->jumlah;
                $product->update();
            }

            $item->delete();
        }

        $sell->delete();

        return response(null, 204);
    }

    public function done()
    {
        $setting = Setting::first();

        return view('sell.done', compact('setting'));
    }

    public function notaSmall()
    {
        $setting = Setting::first();
        $sell = Sell::find(session('id_sell'));
        if (! $sell) {
            abort(404);
        }
        $detail = SellDetail::with('product')
            ->where('id_sell', session('id_sell'))
            ->get();
        
        return view('sell.nota_small', compact('setting', 'sell', 'detail'));
    }

    public function notaBig()
    {
        $setting = Setting::first();
        $sell = Sell::find(session('id_sell'));
        if (! $sell) {
            abort(404);
        }
        $detail = SellDetail::with('product')
            ->where('id_sell', session('id_sell'))
            ->get();

        $pdf = PDF::loadView('sell.nota_big', compact('setting', 'sell', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaction-'. date('Y-m-d-his') .'.pdf');
    }
}