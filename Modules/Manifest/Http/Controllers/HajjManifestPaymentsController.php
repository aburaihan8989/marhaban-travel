<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Illuminate\Support\Facades\Storage;
use Modules\Manifest\Entities\HajjManifest;
use Illuminate\Contracts\Support\Renderable;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\Entities\HajjManifestCustomer;
use Modules\Manifest\DataTables\HajjManifestPaymentsDataTable;

class HajjManifestPaymentsController extends Controller
{

    public function index($hajj_manifest_customer_id, HajjManifestPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);
        // @dd($hajj_manifest_customer_id);
        $hajj_manifest = HajjManifestCustomer::findOrFail($hajj_manifest_customer_id);

        return $dataTable->render('manifest::hajj.payments.index', compact('hajj_manifest'));
    }


    public function create($hajj_manifest_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_manifest = HajjManifestCustomer::findOrFail($hajj_manifest_id);

        return view('manifest::hajj.payments.create', compact('hajj_manifest'));
    }


    public function refund($hajj_manifest_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_manifest = HajjManifestCustomer::findOrFail($hajj_manifest_id);

        return view('manifest::hajj.payments.refund', compact('hajj_manifest'));
    }


    public function store(Request $request, HajjManifestCustomer $hajj_manifest_customer_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request, $hajj_manifest_customer_id) {

            if ($request->trx_type == 'Payment') {
                $hajjManifestPayment = HajjManifestPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $hajjManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }

                $hajj_manifest = HajjManifestCustomer::findOrFail($request->hajj_manifest_customer_id);

                // @dd($hajj_manifest);

                // $due_amount = $purchase->due_amount - $request->amount;
                $total_payment = $hajj_manifest->total_payment + $request->amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $hajj_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'last_amount' => $request->amount,
                    'total_payment' => $total_payment,
                    'status' => $status,
                    'remaining_payment' => $remaining_payment,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);


                $hajj_manifest = HajjManifestCustomer::findOrFail($request->hajj_manifest_customer_id);

                $agent = Agent::findOrFail($hajj_manifest->agent_id);
                $agent_referal = Agent::findOrFail($agent->referal_id);

                if ($agent->level_agent == 'Bronze') {
                    $agent_reward = settings()->level11_rewards;
                } elseif ($agent->level_agent == 'Silver') {
                    $agent_reward = settings()->level22_rewards;
                } elseif ($agent->level_agent == 'Gold') {
                    $agent_reward = settings()->level33_rewards;
                } else {
                    $agent_reward = settings()->level44_rewards;
                }

                $referal_reward = settings()->referal11_rewards;

                $promo_haji = settings()->promo_haji;

                if (!$hajj_manifest->promo == 1 AND !$hajj_manifest->promo2 == 1) {
                    if (!$hajj_manifest->agent_reward OR !$hajj_manifest->referal_reward) {
                        if ($hajj_manifest->status == 'Completed' AND $hajj_manifest->visa == 1 AND $hajj_manifest->ticket == 1) {
                            $agent->update([
                                'total_reward' => $agent->total_reward + $agent_reward
                            ]);

                            $agent_referal->update([
                                'total_reward' => $agent_referal->total_reward + $referal_reward
                            ]);

                            $hajj_manifest->update([
                                'agent_reward' => $agent_reward,
                                'referal_reward' => $referal_reward
                            ]);
                        } else {

                        }
                    } else {

                    }
                } elseif ($hajj_manifest->promo2 == 1) {
                    if (!$hajj_manifest->agent_reward OR !$hajj_manifest->referal_reward) {
                        if ($hajj_manifest->status == 'Completed' AND $hajj_manifest->visa == 1 AND $hajj_manifest->ticket == 1) {
                            $agent->update([
                                'total_reward' => $agent->total_reward + $promo_haji
                            ]);

                            $hajj_manifest->update([
                                'agent_reward' => $promo_haji
                            ]);
                        } else {

                        }
                    } else {

                    }
                } else {

                }
            } else {
                $hajjManifestPayment = HajjManifestPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $hajjManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }

                $hajj_manifest = HajjManifestCustomer::findOrFail($request->hajj_manifest_customer_id);

                // @dd($hajj_manifest);

                // $due_amount = $purchase->due_amount - $request->amount;
                $total_payment = $hajj_manifest->total_payment - $request->refund_amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $hajj_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'last_amount' => $request->refund_amount,
                    'total_payment' => $total_payment,
                    'status' => $status,
                    'remaining_payment' => $remaining_payment,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            }

        });

        toast('Hajj Manifest Customer Payment Created!', 'success');

        return redirect()->route('hajj-manage-manifests.manage', $hajj_manifest_customer_id->manifest_id);
    }


    public function edit($hajj_manifest_customer_id, HajjManifestPayment $hajjManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_manifest = HajjManifestCustomer::findOrFail($hajj_manifest_customer_id);

        return view('manifest::hajj.payments.edit', compact('hajjManifestPayment', 'hajj_manifest'));
    }


    public function update(Request $request, HajjManifestPayment $hajjManifestPayment) {

        DB::transaction(function () use ($request, $hajjManifestPayment) {
            $hajj_manifest = $hajjManifestPayment->hajjManifestCustomers;

            if ($hajjManifestPayment->trx_type == 'Payment') {
                $total_payment = ($hajj_manifest->total_payment - $hajjManifestPayment->amount) + $request->amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $hajj_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'total_payment' => $total_payment,
                    'remaining_payment' => $hajj_manifest->total_price - $total_payment,
                    'last_amount' => $request->amount,
                    'status' => $status,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                $hajjManifestPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'status' => $request->status,
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            } else {
                $total_payment = ($hajj_manifest->total_payment + $hajjManifestPayment->refund_amount) - $request->refund_amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $hajj_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'total_payment' => $total_payment,
                    'remaining_payment' => $hajj_manifest->total_price - $total_payment,
                    'last_amount' => $request->refund_amount,
                    'status' => $status,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                $hajjManifestPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'status' => $request->status,
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            }

            if ($request->has('document')) {
                if (count($hajjManifestPayment->getMedia('payments')) > 0) {
                    foreach ($hajjManifestPayment->getMedia('payments') as $media) {
                        if (!in_array($media->file_name, $request->input('document', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $hajjManifestPayment->getMedia('payments')->pluck('file_name')->toArray();

                foreach ($request->input('document', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $hajjManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }
            }
        });

        toast('Hajj Manifest Customer Payment Updated!', 'info');

        return redirect()->route('hajj-manifest-payments.index', $hajjManifestPayment->hajj_manifest_customer_id);
    }


    public function view($hajj_manifest_customer_id, HajjManifestPayment $hajjManifestPayment) {
        // abort_if(Gate::denies('show_products'), 403);
        $hajj_manifest = HajjManifestCustomer::findOrFail($hajj_manifest_customer_id);
        $customer = Customer::findOrFail($hajj_manifest->customer_id);
        $agent = Agent::findOrFail($hajj_manifest->agent_id);

        return view('manifest::hajj.payments.view', compact('hajjManifestPayment', 'hajj_manifest', 'customer', 'agent'));
    }


    public function destroy(HajjManifestPayment $hajjManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($hajjManifestPayment) {
            $hajj_manifest = $hajjManifestPayment->hajjManifestCustomers;

            if ($hajjManifestPayment->trx_type == 'Payment') {
                $total_payment = $hajj_manifest->total_payment - $hajjManifestPayment->amount;
                if ($total_payment >= $hajj_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'total_payment' => $total_payment,
                    'status' => $status,
                    'remaining_payment' => $hajj_manifest->total_price - ($hajj_manifest->total_payment - $hajjManifestPayment->amount)
                ]);
            } else {
                $hajj_manifest->update([
                    'total_payment' => $hajj_manifest->total_payment - $hajjManifestPayment->refund_amount,
                    'remaining_payment' => $hajj_manifest->total_price - ($hajj_manifest->total_payment - $hajjManifestPayment->refund_amount)
                ]);
            }
        });

        $hajjManifestPayment->delete();

        toast('Hajj Manifest Customer Payment Deleted!', 'warning');

        return redirect()->route('hajj-manage-manifests.manage', $hajjManifestPayment->hajjManifestCustomers->manifest_id);
    }
}
