<?php

namespace Modules\Saving\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
// use Modules\Product\Entities\Product;
use Modules\Saving\Entities\HajjSaving;
// use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Saving\Entities\HajjSavingPayment;
use Modules\Saving\DataTables\HajjSavingDataTable;
// use Modules\Saving\Http\Requests\StoreHajjSavingRequest;
// use Modules\Saving\Http\Requests\UpdateHajjSavingRequest;

class HajjSavingController extends Controller
{

    public function index(HajjSavingDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('saving::hajj.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_purchases'), 403);

        // Cart::instance('purchase')->destroy();

        return view('saving::hajj.create');
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

            $hajj_saving = HajjSaving::create([
                'register_date' => $request->register_date,
                'customer_id' => $request->customer_id,
                'agent_id' => $request->agent_id,
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

            if ($hajj_saving->last_amount > 0) {
                HajjSavingPayment::create([
                    'date' => $request->register_date,
                    'reference' => 'INV/CR/'.$hajj_saving->reference,
                    'amount' => $request->last_amount,
                    'status' => 'Approval',
                    'saving_id' => $hajj_saving->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Hajj Saving Created!', 'success');

        return redirect()->route('hajj-savings.index');
    }


    public function show(HajjSaving $hajj_saving) {
        // abort_if(Gate::denies('show_purchases'), 403);
        $customer = Customer::findOrFail($hajj_saving->customer_id);
        $agent = Agent::findOrFail($hajj_saving->agent_id);

        return view('saving::hajj.show', compact('hajj_saving', 'customer', 'agent'));
    }


    public function edit(HajjSaving $hajj_saving) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('saving::hajj.edit', compact('hajj_saving'));
    }


    public function update(Request $request, HajjSaving $hajj_saving) {
        DB::transaction(function () use ($request, $hajj_saving) {

            $hajj_saving->update([
                'register_date' => $request->register_date,
                'reference' => $hajj_saving->reference,
                'customer_id' => $request->customer_id,
                'agent_id' => $request->agent_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'status' => $request->status,
                'customer_bank' => $request->customer_bank,
                'bank_account' => $request->bank_account,
                'total_saving' => $hajj_saving->total_saving,
                'last_date' => $hajj_saving->register_date,
                'last_amount' => $hajj_saving->last_amount,
                'payment_method' => $hajj_saving->payment_method,
                'note' => $request->note
            ]);

        });

        toast('Hajj Saving Updated!', 'info');

        return redirect()->route('hajj-savings.index');
    }


    public function destroy(HajjSaving $hajj_saving) {
        // abort_if(Gate::denies('delete_purchases'), 403);

        $hajj_saving->delete();

        toast('Hajj Saving Deleted!', 'warning');

        return redirect()->route('hajj-savings.index');
    }
}
