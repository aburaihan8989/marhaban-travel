<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Manifest\Entities\HajjManifest;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\Entities\HajjManifestCustomer;
use Modules\Manifest\DataTables\HajjManifestCustomerDataTable;
// use Modules\Saving\Http\Requests\StoreSavingRequest;
// use Modules\Saving\Http\Requests\UpdateSavingRequest;

class HajjManifestCustomerController extends Controller
{

    public function index(HajjManifestCustomerDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('manifest::hajj.index');
    }


    public function create($id) {
        // abort_if(Gate::denies('create_purchases'), 403);

        $hajj_manifest = HajjManifest::findOrFail($id);

        return view('manifest::hajj.customers.create', compact('hajj_manifest'));
    }


    public function store(Request $request, HajjManifest $hajj_manifest_id) {
        // @dd($umroh_manifest_id);

        DB::transaction(function () use ($request, $hajj_manifest_id) {
            $total_payment = $request->last_amount;
            $remaining_payment = $request->total_price - $total_payment;

            if ($total_payment >= $request->total_price) {
                $status = 'Completed';
            } else {
                $status = 'Waiting';
            }

            $hajj_manifest_customer = HajjManifestCustomer::create([
                'register_date' => now()->format('Y-m-d'),
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'agent_id' => $request->agent_id,
                'status' => $status,
                'manifest_id' => $hajj_manifest_id->id,
                'package_id' => $hajj_manifest_id->package_id,
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

            if ($hajj_manifest_customer->last_amount > 0) {
                HajjManifestPayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$hajj_manifest_customer->reference,
                    'amount' => $request->last_amount,
                    'status' => 'Approval',
                    'hajj_manifest_customer_id' => $hajj_manifest_customer->id,
                    'payment_method' => $request->payment_method
                ]);
            }

            $agent = Agent::findOrFail($hajj_manifest_customer->agent_id);

            if ($agent->level_agent == 'Bronze') {
                $agent_reward = settings()->level1_rewards;
            } elseif ($agent->level_agent == 'Silver') {
                $agent_reward = settings()->level2_rewards;
            } elseif ($agent->level_agent == 'Gold') {
                $agent_reward = settings()->level3_rewards;
            } else {
                $agent_reward = settings()->level4_rewards;
            }

            $agent->update([
                'total_reward' => $agent->total_reward + $agent_reward
            ]);

            $hajj_manifest_customer->update([
                'agent_reward' => $agent_reward
            ]);

        });

        toast('Hajj Manifest Customer Created!', 'success');

        return redirect()->route('hajj-manage-manifests.manage', $hajj_manifest_id->id);
    }


    public function show(HajjManifestCustomer $hajj_manifest_customer_id) {
        // abort_if(Gate::denies('show_purchases'), 403);

        $customer = Customer::findOrFail($hajj_manifest_customer_id->customer_id);
        $agent = Agent::findOrFail($hajj_manifest_customer_id->agent_id);

        return view('manifest::hajj.customers.show', compact('hajj_manifest_customer_id', 'customer', 'agent'));
    }


    public function edit(HajjManifestCustomer $hajj_manifest_customer_id) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('manifest::hajj.customers.edit', compact('hajj_manifest_customer_id'));
    }


    public function update(Request $request, HajjManifestCustomer $hajj_manifest_customer_id) {
    // @dd($umroh_manifest_customer_id);
        $request->validate([
            // 'total_price' => 'required|numeric',
            // 'total_payment' => 'required|numeric',
            // 'remaining_payment' => 'required|numeric',
            // 'note' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $hajj_manifest_customer_id) {
            // $total_payment = $umroh_manifest_customer_id->total_payment + $request->last_amount;
            $remaining_payment = $request->total_price - $hajj_manifest_customer_id->total_payment;

            if ($request->total_payment >= $request->total_price) {
                $status = 'Completed';
            } else {
                $status = 'Waiting';
            }

            $hajj_manifest_customer_id->update([
                // 'register_date' => $request->register_date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                'agent_id' => $request->agent_id,
                'status' => $status,
                'total_price' => $request->total_price,
                'total_payment' => $hajj_manifest_customer_id->total_payment,
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

        toast('Hajj Manifest Customer Updated!', 'info');

        return redirect()->route('hajj-manage-manifests.manage', $hajj_manifest_customer_id->manifest_id);
    }


    public function destroy(HajjManifestCustomer $hajj_manifest_customer_id) {
        // abort_if(Gate::denies('delete_purchases'), 403);
        // @dd($umroh_manifest_customer_id);
        $hajj_manifest_customer_id->delete();

        toast('Hajj Manifest Customer Deleted!', 'warning');

        return redirect()->route('hajj-manage-manifests.manage', $hajj_manifest_customer_id->manifest_id);
    }
}
