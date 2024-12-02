<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Manifest\Entities\UmrohManifest;
use Modules\Manifest\Entities\UmrohManifestPayment;
use Modules\Manifest\Entities\UmrohManifestCustomer;
use Modules\Manifest\DataTables\UmrohManifestCustomerDataTable;

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
        // abort_if(Gate::denies('create_purchases'), 403);

        $request->validate([
            'agent_id' => 'required'
        ]);

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
                'promo' => $request->promo,
                'promo2' => $request->promo2,
                'room_group' => $request->room_group,
                'family_group' => $request->family_group,
                'baggage' => $request->baggage,
                // 'agent_reward' => $agent_reward,
                'note' => $request->note
            ]);

            if ($umroh_manifest_customer->last_amount > 0) {
                UmrohManifestPayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/CR/'.$umroh_manifest_customer->reference,
                    'amount' => $request->last_amount,
                    'trx_type' => 'Payment',
                    'status' => 'Approval',
                    'umroh_manifest_customer_id' => $umroh_manifest_customer->id,
                    'payment_method' => $request->payment_method
                ]);
            }

            $agent = Agent::findOrFail($umroh_manifest_customer->agent_id);
            $agent_referal = Agent::findOrFail($agent->referal_id);

            if ($agent->level_agent == 'Bronze') {
                $agent_reward = settings()->level1_rewards;
            } elseif ($agent->level_agent == 'Silver') {
                $agent_reward = settings()->level2_rewards;
            } elseif ($agent->level_agent == 'Gold') {
                $agent_reward = settings()->level3_rewards;
            } else {
                $agent_reward = settings()->level4_rewards;
            }

            if ($agent_referal->level_agent == 'Silver' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level2_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level3_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->level3_rewards - settings()->level2_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level4_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->level4_rewards - settings()->level2_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Gold') {
                $referal_reward = settings()->level4_rewards - settings()->level3_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Platinum') {
                $referal_reward = settings()->referal4_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Gold') {
                $referal_reward = settings()->referal3_rewards;
            } elseif ($agent_referal->level_agent == 'Silver' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->referal2_rewards;
            } else {
                $referal_reward = settings()->referal1_rewards;
            }

            $promo_umroh = settings()->promo_umroh;

            if (!$umroh_manifest_customer->promo == 1 AND !$umroh_manifest_customer->promo2 == 1) {
                if ($umroh_manifest_customer->status == 'Completed' AND $umroh_manifest_customer->visa == 1 AND $umroh_manifest_customer->ticket == 1) {
                    $agent->update([
                        'total_reward' => $agent->total_reward + $agent_reward
                    ]);

                    $agent_referal->update([
                        'total_reward' => $agent_referal->total_reward + $referal_reward
                    ]);

                    $umroh_manifest_customer->update([
                        'agent_reward' => $agent_reward,
                        'referal_reward' => $referal_reward
                    ]);
                } else {

                }
            } elseif ($umroh_manifest_customer->promo2 == 1) {
                if ($umroh_manifest_customer->status == 'Completed' AND $umroh_manifest_customer->visa == 1 AND $umroh_manifest_customer->ticket == 1) {
                    $agent->update([
                        'total_reward' => $agent->total_reward + $promo_umroh
                    ]);

                    $umroh_manifest_customer->update([
                        'agent_reward' => $promo_umroh
                    ]);
                } else {

                }
            } else {

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
        // abort_if(Gate::denies('edit_purchases'), 403);

        $request->validate([
            'agent_id' => 'required'
        ]);

        DB::transaction(function () use ($request, $umroh_manifest_customer_id) {
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
                'manifest_id' => $request->manifest_id,
                'package_id' => UmrohManifest::findOrFail($request->manifest_id)->package_id,
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
                'promo' => $request->promo,
                'promo2' => $request->promo2,
                'room_group' => $request->room_group,
                'family_group' => $request->family_group,
                'baggage' => $request->baggage,
                // 'agent_reward' => $agent_reward,
                // 'referal_reward' => $referal_reward,
                'note' => $request->note
            ]);

            $agent = Agent::findOrFail($umroh_manifest_customer_id->agent_id);
            $agent_referal = Agent::findOrFail($agent->referal_id);

            if ($agent->level_agent == 'Bronze') {
                $agent_reward = settings()->level1_rewards;
            } elseif ($agent->level_agent == 'Silver') {
                $agent_reward = settings()->level2_rewards;
            } elseif ($agent->level_agent == 'Gold') {
                $agent_reward = settings()->level3_rewards;
            } else {
                $agent_reward = settings()->level4_rewards;
            }

            if ($agent_referal->level_agent == 'Silver' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level2_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level3_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->level3_rewards - settings()->level2_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Bronze') {
                $referal_reward = settings()->level4_rewards - settings()->level1_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->level4_rewards - settings()->level2_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Gold') {
                $referal_reward = settings()->level4_rewards - settings()->level3_rewards;
            } elseif ($agent_referal->level_agent == 'Platinum' AND $agent->level_agent == 'Platinum') {
                $referal_reward = settings()->referal4_rewards;
            } elseif ($agent_referal->level_agent == 'Gold' AND $agent->level_agent == 'Gold') {
                $referal_reward = settings()->referal3_rewards;
            } elseif ($agent_referal->level_agent == 'Silver' AND $agent->level_agent == 'Silver') {
                $referal_reward = settings()->referal2_rewards;
            } else {
                $referal_reward = settings()->referal1_rewards;
            }

            $promo_umroh = settings()->promo_umroh;

            if (!$umroh_manifest_customer_id->promo == 1 AND !$umroh_manifest_customer_id->promo2 == 1) {
                if (!$umroh_manifest_customer_id->agent_reward OR !$umroh_manifest_customer_id->referal_reward) {
                    if ($umroh_manifest_customer_id->status == 'Completed' AND $umroh_manifest_customer_id->visa == 1 AND $umroh_manifest_customer_id->ticket == 1) {
                        $agent->update([
                            'total_reward' => $agent->total_reward + $agent_reward
                        ]);

                        $agent_referal->update([
                            'total_reward' => $agent_referal->total_reward + $referal_reward
                        ]);

                        $umroh_manifest_customer_id->update([
                            'agent_reward' => $agent_reward,
                            'referal_reward' => $referal_reward
                        ]);
                    } else {

                    }
                } else {

                }
            } elseif ($umroh_manifest_customer_id->promo2 == 1) {
                if (!$umroh_manifest_customer_id->agent_reward) {
                    if ($umroh_manifest_customer_id->status == 'Completed' AND $umroh_manifest_customer_id->visa == 1 AND $umroh_manifest_customer_id->ticket == 1) {
                        $agent->update([
                            'total_reward' => $agent->total_reward + $promo_umroh
                        ]);

                        $umroh_manifest_customer_id->update([
                            'agent_reward' => $promo_umroh
                        ]);
                    } else {

                    }
                } else {

                }
            } else {


            }

    });

        toast('Umroh Manifest Customer Updated!', 'info');

        return redirect()->route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id);
    }


    public function destroy(UmrohManifestCustomer $umroh_manifest_customer_id) {
        // abort_if(Gate::denies('delete_purchases'), 403);
        // @dd($umroh_manifest_customer_id);
        $umroh_manifest_customer_id->delete();

        $agent = Agent::findOrFail($umroh_manifest_customer_id->agent_id);
        $agent_referal = Agent::findOrFail($agent->referal_id);

        $agent->update([
            'total_reward' => $agent->total_reward - $umroh_manifest_customer_id->agent_reward
        ]);

        $agent_referal->update([
            'total_reward' => $agent_referal->total_reward - $umroh_manifest_customer_id->referal_reward
        ]);

        toast('Umroh Manifest Customer Deleted!', 'warning');

        return redirect()->route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id);
    }
}
