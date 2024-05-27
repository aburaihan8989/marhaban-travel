<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Modules\Saving\Entities\Saving;
use Modules\Expense\Entities\Expense;
use Modules\People\Entities\Customer;
use Modules\Sale\Entities\SalePayment;
use Modules\Purchase\Entities\Purchase;
use Modules\Saving\Entities\HajjSaving;
use Modules\Expense\Entities\HajjExpense;
use Modules\Expense\Entities\UmrohExpense;
use Modules\Saving\Entities\SavingPayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\Saving\Entities\HajjSavingPayment;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\Entities\UmrohManifestPayment;
use Modules\SalesReturn\Entities\SaleReturnPayment;
use Modules\Package\DataTables\HajjPackageDataTable;
use Modules\PurchasesReturn\Entities\PurchaseReturn;
use Modules\Package\DataTables\HomeHajjPackageDataTable;
use Modules\Package\DataTables\HomeUmrohPackageDataTable;
use Modules\PurchasesReturn\Entities\PurchaseReturnPayment;

class HomeController extends Controller
{

    public function index(HomeUmrohPackageDataTable $dataTable, HomeHajjPackageDataTable $hajjdataTable) {
        $customers = Customer::count();
        $umroh_savings = Saving::count();
        $hajj_savings = HajjSaving::count();
        $agents = Agent::count();
        $payment_umroh_savings = SavingPayment::where('status','Approval')->count();
        $payment_hajj_savings = HajjSavingPayment::where('status','Approval')->count();
        $payment_savings = $payment_umroh_savings + $payment_hajj_savings;
        $payment_umroh_packages = UmrohManifestPayment::where('status','Approval')->count();
        $payment_hajj_packages = HajjManifestPayment::where('status','Approval')->count();
        $payment_packages = $payment_umroh_packages + $payment_hajj_packages;

        $umroh_payment = UmrohManifestPayment::where('status','Approval')->sum('amount');
        $umroh_expense = UmrohExpense::sum('amount');
        $umroh_profit = $umroh_payment - $umroh_expense;

        $hajj_payment = HajjManifestPayment::where('status','Approval')->sum('amount');
        $hajj_expense = HajjExpense::sum('amount');
        $hajj_profit = $hajj_payment - $hajj_expense;

        $umroh_savings = SavingPayment::where('status','Approval')->sum('amount');
        $hajj_savings = HajjSavingPayment::where('status','Approval')->sum('amount');


        return $dataTable->render('home', compact(
            'customers',
            'umroh_savings',
            'hajj_savings',
            'payment_savings',
            'payment_packages',
            'umroh_payment',
            'umroh_expense',
            'umroh_profit',
            'hajj_payment',
            'hajj_expense',
            'hajj_profit',
            'umroh_savings',
            'hajj_savings',
            'agents'));
        // return view('home', compact('customers', 'umroh_savings', 'hajj_savings', 'agents', 'payment_savings', 'payment_packages'));

        // $sales = Sale::completed()->sum('total_amount');
        // $sale_returns = SaleReturn::completed()->sum('total_amount');
        // $purchase_returns = PurchaseReturn::completed()->sum('total_amount');
        // $product_costs = 0;

        // foreach (Sale::completed()->with('saleDetails')->get() as $sale) {
        //     foreach ($sale->saleDetails as $saleDetail) {
        //         if (!is_null($saleDetail->product)) {
        //             $product_costs += $saleDetail->product->product_cost * $saleDetail->quantity;
        //         }
        //     }
        // }

        // $revenue = ($sales - $sale_returns) / 100;
        // $profit = $revenue - $product_costs;
        // 'revenue'          => $revenue,
        // 'sale_returns'     => $sale_returns / 100,
        // 'purchase_returns' => $purchase_returns / 100,
        // 'profit'           => $profit
        // ]);
    }


    public function currentMonthChart() {
        abort_if(!request()->ajax(), 404);

        $currentMonthSales = Sale::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
        $currentMonthPurchases = Purchase::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
        $currentMonthExpenses = Expense::whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('amount') / 100;

        return response()->json([
            'sales'     => $currentMonthSales,
            'purchases' => $currentMonthPurchases,
            'expenses'  => $currentMonthExpenses
        ]);
    }


    public function salesPurchasesChart() {
        abort_if(!request()->ajax(), 404);

        $sales = $this->salesChartData();
        $purchases = $this->purchasesChartData();

        return response()->json(['sales' => $sales, 'purchases' => $purchases]);
    }


    public function paymentChart() {
        abort_if(!request()->ajax(), 404);

        $dates = collect();
        foreach (range(-11, 0) as $i) {
            $date = Carbon::now()->addMonths($i)->format('m-Y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subYear()->format('Y-m-d');

        $sale_payments = SalePayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $sale_return_payments = SaleReturnPayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $purchase_payments = PurchasePayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $purchase_return_payments = PurchaseReturnPayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $expenses = Expense::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $payment_received = array_merge_numeric_values($sale_payments, $purchase_return_payments);
        $payment_sent = array_merge_numeric_values($purchase_payments, $sale_return_payments, $expenses);

        $dates_received = $dates->merge($payment_received);
        $dates_sent = $dates->merge($payment_sent);

        $received_payments = [];
        $sent_payments = [];
        $months = [];

        foreach ($dates_received as $key => $value) {
            $received_payments[] = $value;
            $months[] = $key;
        }

        foreach ($dates_sent as $key => $value) {
            $sent_payments[] = $value;
        }

        return response()->json([
            'payment_sent' => $sent_payments,
            'payment_received' => $received_payments,
            'months' => $months,
        ]);
    }

    public function salesChartData() {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);

        $sales = Sale::where('status', 'Completed')
            ->where('date', '>=', $date_range)
            ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
            ->orderBy('date')
            ->get([
                DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                DB::raw('SUM(total_amount) AS count'),
            ])
            ->pluck('count', 'date');

        $dates = $dates->merge($sales);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);
    }


    public function purchasesChartData() {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);

        $purchases = Purchase::where('status', 'Completed')
            ->where('date', '>=', $date_range)
            ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
            ->orderBy('date')
            ->get([
                DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                DB::raw('SUM(total_amount) AS count'),
            ])
            ->pluck('count', 'date');

        $dates = $dates->merge($purchases);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);

    }
}
