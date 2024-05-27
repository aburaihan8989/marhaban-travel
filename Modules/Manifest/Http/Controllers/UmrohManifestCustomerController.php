<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
// use Modules\Product\Entities\Product;
use Modules\Manifest\Entities\UmrohManifest;
// use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Manifest\Entities\UmrohManifestPayment;
use Modules\Manifest\Entities\UmrohManifestCustomer;
use Modules\Manifest\DataTables\UmrohManifestCustomerDataTable;
// use Modules\Saving\Http\Requests\StoreSavingRequest;
// use Modules\Saving\Http\Requests\UpdateSavingRequest;

class UmrohManifestCustomerController extends Controller
{

    public function index(UmrohManifestCustomerDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('manifest::umroh.index');
    }


    public function create($id) {
        // abort_if(Gate::denies('create_purchases'), 403);

        $umroh_manifest = UmrohManifest::findOrFail($id);

        return view('manifest::umroh.customers.create', compact('umroh_manifest'));
    }


    public function store(Request $request, UmrohManifest $umroh_manifest_id) {
        // @dd($umroh_manifest_id);

        DB::transaction(function () use ($request, $umroh_manifest_id) {
            $total_payment = $request->last_amount;
            $remaining_payment = $request->total_price - $total_payment;

            if ($total_payment >= $request->total_price) {
                $status = 'Completed';
            } else {
                $status = 'Waiting';
            }

            $umroh_manifest_customer = UmrohManifestCustomer::create([
                'register_date' => now()->format('Y-m-d'),
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'agent_id' => $request->agent_id,
                'status' => $status,
                'manifest_id' => $umroh_manifest_id->id,
                'package_id' => $umroh_manifest_id->package_id,
                // 'bank_account' => $request->bank_account,
                'total_price' => $request->total_price,
                'total_payment' => $total_payment,
                'remaining_payment' => $remaining_payment,
                'last_date' => now()->format('Y-m-d'),
                'last_amount' => $request->last_amount,
                'payment_method' => $request->payment_method,
                'ticket' => $request->ticket,
                'visa' => $request->visa,
                'big_suitcase' => $request->big_suitcase,
                'small_suitcase' => $request->small_suitcase,
                'small_bag' => $request->small_bag,
                'clothes' => $request->clothes,
                'small_pillow' => $request->small_pillow,
                'scraf' => $request->scraf,
                'room_group' => $request->room_group,
                'family_group' => $request->family_group,
                'baggage' => $request->baggage,
                'note' => $request->note
            ]);

            // if ($request->status == 'Completed') {
            //     $product = Product::findOrFail($cart_item->id);
            //     $product->update([
            //         'product_quantity' => $product->product_quantity + $cart_item->qty
            //     ]);
            // }

            if ($umroh_manifest_customer->last_amount > 0) {
                UmrohManifestPayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$umroh_manifest_customer->reference,
                    'amount' => $request->last_amount,
                    'status' => 'Approval',
                    'umroh_manifest_customer_id' => $umroh_manifest_customer->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Umroh Manifest Customer Created!', 'success');

        return redirect()->route('umroh-manage-manifests.manage', $umroh_manifest_id->id);
    }


    public function show(UmrohManifestCustomer $umroh_manifest_customer_id) {
        // abort_if(Gate::denies('show_purchases'), 403);
        $customer = Customer::findOrFail($umroh_manifest_customer_id->customer_id);
        $agent = Agent::findOrFail($umroh_manifest_customer_id->agent_id);

        return view('manifest::umroh.customers.show', compact('umroh_manifest_customer_id', 'customer', 'agent'));
    }


    public function edit(UmrohManifestCustomer $umroh_manifest_customer_id) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('manifest::umroh.customers.edit', compact('umroh_manifest_customer_id'));
    }


    public function update(Request $request, UmrohManifestCustomer $umroh_manifest_customer_id) {
    // @dd($umroh_manifest_customer_id);
        $request->validate([
            // 'total_price' => 'required|numeric',
            // 'total_payment' => 'required|numeric',
            // 'remaining_payment' => 'required|numeric',
            'note' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $umroh_manifest_customer_id) {
            // $total_payment = $umroh_manifest_customer_id->total_payment + $request->last_amount;
            $remaining_payment = $request->total_price - $umroh_manifest_customer_id->total_payment;

            if ($request->total_payment >= $request->total_price) {
                $status = 'Completed';
            } else {
                $status = 'Waiting';
            }

            $umroh_manifest_customer_id->update([
                // 'register_date' => $request->register_date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'agent_id' => $request->agent_id,
                'status' => $status,
                'total_price' => $request->total_price,
                'total_payment' => $umroh_manifest_customer_id->total_payment,
                'remaining_payment' => $remaining_payment,
                'ticket' => $request->ticket,
                'visa' => $request->visa,
                'big_suitcase' => $request->big_suitcase,
                'small_suitcase' => $request->small_suitcase,
                'small_bag' => $request->small_bag,
                'clothes' => $request->clothes,
                'small_pillow' => $request->small_pillow,
                'scraf' => $request->scraf,
                'room_group' => $request->room_group,
                'family_group' => $request->family_group,
                'baggage' => $request->baggage,
                'note' => $request->note
            ]);

        });

        toast('Umroh Manifest Customer Updated!', 'info');

        return redirect()->route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id);
    }


    public function destroy(UmrohManifestCustomer $umroh_manifest_customer_id) {
        // abort_if(Gate::denies('delete_purchases'), 403);
        // @dd($umroh_manifest_customer_id);
        $umroh_manifest_customer_id->delete();

        toast('Umroh Manifest Customer Deleted!', 'warning');

        return redirect()->route('umroh-manage-manifests.manage', 8);
    }
}
