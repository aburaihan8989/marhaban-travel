<?php

namespace Modules\Saving\Http\Controllers;

use Modules\Saving\DataTables\SavingDataTable;
use Illuminate\Http\Request;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
// use Modules\Product\Entities\Product;
use Modules\Saving\Entities\Saving;
// use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Saving\Entities\SavingPayment;
// use Modules\Saving\Http\Requests\StoreSavingRequest;
// use Modules\Saving\Http\Requests\UpdateSavingRequest;

class SavingController extends Controller
{

    public function index(SavingDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('saving::umroh.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_purchases'), 403);

        // Cart::instance('purchase')->destroy();

        return view('saving::umroh.create');
    }


    public function store(Request $request) {
        DB::transaction(function () use ($request) {
            // $total_saving = $request->total_saving + $request->last_amount;
            // if ($due_amount == $request->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $umroh_saving = Saving::create([
                'register_date' => $request->register_date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'status' => $request->status,
                'customer_bank' => $request->customer_bank,
                'bank_account' => $request->bank_account,
                'total_saving' => $request->total_saving + $request->last_amount,
                'last_date' => $request->register_date,
                'last_amount' => $request->last_amount,
                'payment_method' => $request->payment_method,
                'note' => $request->note
            ]);

            // if ($request->status == 'Completed') {
            //     $product = Product::findOrFail($cart_item->id);
            //     $product->update([
            //         'product_quantity' => $product->product_quantity + $cart_item->qty
            //     ]);
            // }

            if ($umroh_saving->last_amount > 0) {
                SavingPayment::create([
                    'date' => $request->register_date,
                    'reference' => 'CR/'.$umroh_saving->reference,
                    'amount' => $request->last_amount,
                    'trx_type' => 'Saving',
                    'status' => 'Approval',
                    'saving_id' => $umroh_saving->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Umroh Saving Created!', 'success');

        return redirect()->route('umroh-savings.index');
    }


    public function show(Saving $umroh_saving) {
        // abort_if(Gate::denies('show_purchases'), 403);

        $customer = Customer::findOrFail($umroh_saving->customer_id);

        return view('saving::umroh.show', compact('umroh_saving', 'customer'));
    }


    public function edit(Saving $umroh_saving) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('saving::umroh.edit', compact('umroh_saving'));
    }


    public function update(Request $request, Saving $umroh_saving) {
        DB::transaction(function () use ($request, $umroh_saving) {
        //     $due_amount = $request->total_amount - $request->paid_amount;
        //     if ($due_amount == $request->total_amount) {
        //         $payment_status = 'Unpaid';
        //     } elseif ($due_amount > 0) {
        //         $payment_status = 'Partial';
        //     } else {
        //         $payment_status = 'Paid';
        //     }

            $umroh_saving->update([
                'register_date' => $request->register_date,
                'reference' => $umroh_saving->reference,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'status' => $request->status,
                'customer_bank' => $request->customer_bank,
                'bank_account' => $request->bank_account,
                'total_saving' => $umroh_saving->total_saving,
                'last_date' => $umroh_saving->register_date,
                'last_amount' => $umroh_saving->last_amount,
                'payment_method' => $umroh_saving->payment_method,
                'note' => $request->note
            ]);

        });

        toast('Umroh Saving Updated!', 'info');

        return redirect()->route('umroh-savings.index');
    }


    public function destroy(Saving $umroh_saving) {
        // abort_if(Gate::denies('delete_purchases'), 403);

        $umroh_saving->delete();

        toast('Umroh Saving Deleted!', 'warning');

        return redirect()->route('umroh-savings.index');
    }
}
