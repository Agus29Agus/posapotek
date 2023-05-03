<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Spending;
use App\Models\Sell;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateBegin = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $dateEnd = date('Y-m-d');

        if ($request->has('date_begin') && $request->date_begin != "" && $request->has('date_end') && $request->date_end) {
            $dateBegin = $request->date_begin;
            $dateEnd = $request->date_end;
        }

        return view('report.index', compact('dateBegin', 'dateEnd'));
    }

    public function getData($begin, $end)
    {
        $no = 1;
        $data = array();
        $income = 0;
        $total_income = 0;

        while (strtotime($begin) <= strtotime($end)) {
            $date = $begin;
            $begin = date('Y-m-d', strtotime("+1 day", strtotime($begin)));

            $total_sell = Sell::where('created_at', 'LIKE', "%$date%")->sum('pay');
            $total_purchase = Purchase::where('created_at', 'LIKE', "%$date%")->sum('pay');
            $total_spending = Spending::where('created_at', 'LIKE', "%$date%")->sum('nominal');

            $income = $total_sell - $total_purchase - $total_spending;
            $total_income += $income;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['date'] = indonesian_date($date, false);
            $row['sell'] = money_format($total_sell);
            $row['purchase'] = money_format($total_purchase);
            $row['spending'] = money_format($total_spending);
            $row['income'] = money_format($income);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'date' => '',
            'sell' => '',
            'purchase' => '',
            'spending' => 'Total Income',
            'income' => money_format($total_income),
        ];

        return $data;
    }

    public function data($begin, $end)
    {
        $data = $this->getData($begin, $end);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDF($begin, $end)
    {
        $data = $this->getData($begin, $end);
        $pdf  = PDF::loadView('report.pdf', compact('begin', 'end', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('report-income-'. date('Y-m-d-his') .'.pdf');
    }

    // public function exportExcel($request, $begin, $end, $id)
    // {
    //     return Excel::download(new ReportExport, 'report.xlsx');
    // }

    // public function export(Request $request, $type, $filename)
    // {
    //     $data = Report::all();

    //     return Excel::download(new ReportExport($data), $filename.'.'.$type);
    // }
}
