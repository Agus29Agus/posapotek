<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;

use function PHPSTORM_META\map;

class PurchaseController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('name')->get();

        return view('purchase.index', compact('supplier'));
    }

    public function data()
    {
        $purchase = Purchase::orderBy('id_purchase', 'desc')->get();

        return datatables()
            ->of($purchase)
            ->addIndexColumn()
            ->addColumn('total_item', function ($purchase) {
                return money_format($purchase->total_item);
            })
            ->addColumn('total_price', function ($purchase) {
                return 'Rp. '. money_format($purchase->total_price);
            })
            ->addColumn('pay', function ($purchase) {
                return 'Rp. '. money_format($purchase->pay);
            })
            ->addColumn('cost', function ($purchase) {
                return 'Rp. '. money_format($purchase->cost);
            })
            ->addColumn('date', function ($purchase) {
                return indonesian_date($purchase->created_at, false);
            })
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->name;
            })
            ->editColumn('discount', function ($purchase) {
                return $purchase->discount . '%';
            })
            ->addColumn('action', function ($purchase) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('purchase.show', $purchase->id_purchase) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // dibawah ini ada script delete purchase 
    // <button onclick="deleteData(`'. route('purchase.destroy', $purchase->id_purchase) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>

    public function create($id)
    {
        $purchase = Purchase::create([
            'id_supplier'=>$id,
            // 'total_item'=>0,
            // 'total_price'=>0,
            // 'discount'=>0,
            // 'pay'=>0
        ]);
        // $purchase = new purchase();
        // $purchase->id_supplier = $id;
        // $purchase->total_item  = 0;
        // $purchase->total_price = 0;
        // $purchase->discount      = 0;
        // $purchase->pay       = 0;
        // $purchase->save();

        session(['id_purchase' => $purchase->id_purchase]);
        session(['id_supplier' => $purchase->id_supplier]);

        return to_route('purchase_detail.index');
    }

    public function store(Request $request)
    {
        $purchase = Purchase::findOrFail($request->id_purchase);
        $purchase->total_item = $request->total_item;
        $purchase->total_price = $request->total;
        $purchase->discount = $request->discount;
        $purchase->pay = $request->pay;
        $purchase->cost = $request->cost;
        $purchase->update();

        $detail = PurchaseDetail::where('id_purchase', $purchase->id_purchase)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->id_product);
            $product->stock += $item->total;
            $product->update();
        }

        return to_route('purchase.index');
    }

    public function show($id)
    {
        $detail = PurchaseDetail::with('product')->where('id_purchase', $id)->get();

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
            ->addColumn('cost', function ($detail) {
                return 'Rp. '. money_format($detail->cost);
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
        $purchase = Purchase::find($id);
        $detail    = PurchaseDetail::where('id_purchase', $purchase->id_purchase)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->id_product);
            if ($product) {
                $product->stock -= $item->total;
                $product->update();
            }
            $item->delete();
        }

        $purchase->delete();

        return response(null, 204);
    }
}