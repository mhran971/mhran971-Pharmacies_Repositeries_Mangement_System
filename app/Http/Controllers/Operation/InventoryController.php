<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class InventoryController extends Controller
{
    public function dailySalesSummary()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $start = Carbon::today();
        $end = Carbon::today()->endOfDay();
        $prevStart = Carbon::yesterday();
        $prevEnd = Carbon::yesterday()->endOfDay();

        $sales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_sum');

        $invoiceCount = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $avgInvoice = $invoiceCount > 0 ? $sales / $invoiceCount : 0;

        $profit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->selectRaw('SUM((ps.sale_price - ps.Purchase_price) * sm.quantity) as profit')
            ->value('profit');

        $topMedicines = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->select('m.trade_name', DB::raw('SUM(sm.quantity) as total_qty'))
            ->groupBy('m.trade_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $salesByLaboratory = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('laboratories as l', 'm.laboratory_id', '=', 'l.id') // join مع جدول المعامل
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->select('l.name_en as laboratory_name', DB::raw('SUM(sm.quantity * ps.sale_price) as total_sales'))
            ->groupBy('l.name_en')
            ->get();


        $prevSales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_sum');

        $growth = $prevSales > 0 ? (($sales - $prevSales) / $prevSales) * 100 : 0;

        return response()->json([
            'sales' => $sales,
            'invoice_count' => $invoiceCount,
            'avg_invoice' => $avgInvoice,
            'profit' => $profit ?? 0,
            'top_medicines' => $topMedicines,
            'sales_by_laboratory' => $salesByLaboratory,
            'growth_percent' => round($growth, 2),
        ]);
    }


    public function weeklySalesSummary()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();
        $prevStart = Carbon::now()->subWeek()->startOfWeek();
        $prevEnd = Carbon::now()->subWeek()->endOfWeek();

        $sales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_sum');

        $invoiceCount = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $avgInvoice = $invoiceCount > 0 ? $sales / $invoiceCount : 0;

        $profit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->selectRaw('SUM((ps.sale_price - ps.Purchase_price) * sm.quantity) as profit')
            ->value('profit');

        $topMedicines = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->select('m.trade_name', DB::raw('SUM(sm.quantity) as total_qty'))
            ->groupBy('m.trade_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $salesByLaboratory = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('laboratories as l', 'm.laboratory_id', '=', 'l.id') // join مع جدول المعامل
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->select('l.name_en as laboratory_name', DB::raw('SUM(sm.quantity * ps.sale_price) as total_sales'))
            ->groupBy('l.name_en')
            ->get();


        $prevSales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_sum');

        $growth = $prevSales > 0 ? (($sales - $prevSales) / $prevSales) * 100 : 0;

        return response()->json([
            'sales' => $sales,
            'invoice_count' => $invoiceCount,
            'avg_invoice' => $avgInvoice,
            'profit' => $profit ?? 0,
            'top_medicines' => $topMedicines,
            'sales_by_laboratory' => $salesByLaboratory,
            'growth_percent' => round($growth, 2),
        ]);
    }

    public function monthlySalesSummary()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $prevStart = Carbon::now()->subMonth()->startOfMonth();
        $prevEnd = Carbon::now()->subMonth()->endOfMonth();

        $sales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_sum');

        $invoiceCount = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $avgInvoice = $invoiceCount > 0 ? $sales / $invoiceCount : 0;

        $profit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->selectRaw('SUM((ps.sale_price - ps.Purchase_price) * sm.quantity) as profit')
            ->value('profit');

        $topMedicines = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->select('m.trade_name', DB::raw('SUM(sm.quantity) as total_qty'))
            ->groupBy('m.trade_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $salesByLaboratory = DB::table('stock_movements as sm')
            ->join('medicines as m', 'sm.medicine_id', '=', 'm.id')
            ->join('laboratories as l', 'm.laboratory_id', '=', 'l.id') // join مع جدول المعامل
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->where('i.pharmacy_id', $pharmacyId)
            ->whereBetween('i.created_at', [$start, $end])
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->select('l.name_en as laboratory_name', DB::raw('SUM(sm.quantity * ps.sale_price) as total_sales'))
            ->groupBy('l.name_en')
            ->get();


        $prevSales = DB::table('invoices')
            ->where('pharmacy_id', $pharmacyId)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_sum');

        $growth = $prevSales > 0 ? (($sales - $prevSales) / $prevSales) * 100 : 0;

        return response()->json([
            'sales' => $sales,
            'invoice_count' => $invoiceCount,
            'avg_invoice' => $avgInvoice,
            'profit' => $profit ?? 0,
            'top_medicines' => $topMedicines,
            'sales_by_laboratory' => $salesByLaboratory,
            'growth_percent' => round($growth, 2),
        ]);
    }

    public function dailyProfit()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $dailyProfit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->where('i.pharmacy_id', $pharmacyId)
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->whereDate('i.created_at', Carbon::today())
            ->selectRaw('SUM((sm.quantity * ps.sale_price) - (sm.quantity * ps.purchase_price)) as net_profit')
            ->value('net_profit');

        return response()->json([
            'daily Profit ' => $dailyProfit,]);
    }

    public function weeklyProfit()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $weeklyProfit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->where('i.pharmacy_id', $pharmacyId)
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->whereBetween('i.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->selectRaw('SUM((sm.quantity * ps.sale_price) - (sm.quantity * ps.purchase_price)) as net_profit')
            ->value('net_profit');

        return response()->json([
            'weekly Profit ' => $weeklyProfit,]);
    }


    public function monthlyProfit()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $monthlyProfit = DB::table('stock_movements as sm')
            ->join('pharmacy_stocks as ps', function ($join) {
                $join->on('sm.medicine_id', '=', 'ps.medicine_id')
                    ->on('sm.batch', '=', 'ps.batch');
            })
            ->where('i.pharmacy_id', $pharmacyId)
            ->join('invoices as i', 'sm.invoice_id', '=', 'i.id')
            ->whereYear('i.created_at', Carbon::now()->year)
            ->whereMonth('i.created_at', Carbon::now()->month)
            ->selectRaw('SUM((sm.quantity * ps.sale_price) - (sm.quantity * ps.purchase_price)) as net_profit')
            ->value('net_profit');

        return response()->json([
            'monthly Profit ' => $monthlyProfit,]);
    }

    public function dailySalesChart()
    {
        $sales = DB::table('invoices')
            ->selectRaw('DATE(created_at) as date, DAYNAME(created_at) as day_name, SUM(total_sum) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date', 'day_name')
            ->orderBy('date')
            ->get();


        return response()->json($sales);
    }

    public function weeklySalesChart()
    {
        $sales = DB::table('invoices')
            ->selectRaw('WEEK(created_at, 1) as week_number, SUM(total_sum) as total')
            ->where('created_at', '>=', Carbon::now()->subWeeks(12))
            ->groupBy('week_number')
            ->orderBy('week_number')
            ->get()
            ->map(function ($item) {
                $item->label = "Week " . $item->week_number;
                return $item;
            });

        return response()->json($sales);
    }

    public function monthlySalesChart()
    {
        $sales = DB::table('invoices')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month_key, MONTHNAME(created_at) as month_name, SUM(total_sum) as total')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month_key', 'month_name')
            ->orderBy('month_key')
            ->get();

        return response()->json($sales);
    }


}

