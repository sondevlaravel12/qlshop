<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $todayRevenue = Invoice::todayTotal(true);
        $thisWeekRevenue = Invoice::thisWeekTotal(true);
        $thisMonthRevenue = Invoice::thisMonthTotal(true);
        $thisYearRevenue = Invoice::thisYearTotal(true);
        $compareToLastWeek = Invoice::compareToLastWeek();
        $compareToLastWeekFormat = Invoice::compareToLastWeek(true);
        $compareToLastMonth = Invoice::compareToLastMonth();
        $compareToLastMonthFormat = Invoice::compareToLastMonth(true);
        $compareToLastYear = Invoice::compareToLastYear();
        $compareToLastYearFormat = Invoice::compareToLastYear(true);
        $compareToYesterday = Invoice::compareToYesterday();
        $compareToYesterdayFormat = Invoice::compareToYesterday(true);
        $lastInvoices = Invoice::with('customer')->latest()->limit(20)->get();

        // $thisYearRevenue = Invoice::whereYear('date','=',date('Y'))->first()?Invoice::whereYear('date','=',date('Y'))->first()->total:0;
        return view('app.index', compact(
            'todayRevenue','thisWeekRevenue','thisMonthRevenue','thisYearRevenue',
            'compareToLastWeek','compareToLastWeekFormat','compareToLastMonth','compareToLastMonthFormat',
            'compareToLastYear','compareToLastYearFormat','compareToYesterday','compareToYesterdayFormat',
            'lastInvoices'
        ));
    }
    public function ajaxReportByYear(Request $request){

        $revenue = Invoice::totalMonthly(date('Y'),false);
        return response()->json($revenue);
    }
    public function ajaxReportRevenueByMonth(Request $request){

        $revenue = Invoice::totalThisMonthDaily(false);
        return response()->json($revenue);
    }
    public function ajaxReportRevenueByWeek(Request $request){

        $revenue = Invoice::totalThisWeekDaily(false);
        return response()->json($revenue);
    }
}
