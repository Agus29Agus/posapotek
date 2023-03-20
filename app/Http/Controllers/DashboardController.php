<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\Purchase;
use App\Models\Spending;
use App\Models\Sell;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $category = Category::count();
        $product = Product::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $date_begin = date('Y-m-01');
        $date_end = date('Y-m-d');

        $data_date = array();
        $data_income = array();

        while (strtotime($date_begin) <= strtotime($date_end)) {
            $data_date[] = (int) substr($date_begin, 8, 2);

            $total_sell = Sell::where('created_at', 'LIKE', "%$date_begin%")->sum('pay');
            $total_purchase = Purchase::where('created_at', 'LIKE', "%$date_begin%")->sum('pay');
            $total_spending = Spending::where('created_at', 'LIKE', "%$date_begin%")->sum('nominal');

            $income = $total_sell - $total_purchase - $total_spending;
            $data_income[] += $income;

            $date_begin = date('Y-m-d', strtotime("+1 day", strtotime($date_begin)));
        }

        $date_begin = date('Y-m-01');

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('category', 'product', 'supplier', 'member', 'date_begin', 'date_end', 'data_date', 'data_income'));
        } else {
            return view('cashier.dashboard');
        }
    }
}
