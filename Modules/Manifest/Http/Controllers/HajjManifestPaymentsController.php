<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\People\Entities\Customer;
use Modules\Manifest\Entities\HajjManifest;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\Entities\HajjManifestCustomer;
use Modules\Manifest\DataTables\HajjManifestPaymentsDataTable;

class HajjManifestPaymentsController extends Controller
{

    public function index($hajj_manifest_customer_id, HajjManifestPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);
        // @dd($umroh_manifest_customer_id);
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
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $hajjManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }

                $hajj_manifest = HajjManifestCustomer::findOrFail($request->hajj_manifest_customer_id);

                // @dd($umroh_manifest);

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
                    'payment_method' => $request->payment_method
                ]);
            } else {
                $hajjManifestPayment = HajjManifestPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $hajjManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }

                $hajj_manifest = HajjManifestCustomer::findOrFail($request->hajj_manifest_customer_id);

                // @dd($umroh_manifest);

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

            if ($umrohManifestPayment->trx_type == 'Payment') {
                $total_payment = ($hajj_manifest->total_payment - $hajjManifestPayment->amount) + $request->amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $umroh_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'total_payment' => $total_payment,
                    'remaining_payment' => $hajj_manifest->total_price - $total_payment,
                    'last_amount' => $request->amount,
                    'status' => $status,
                    'payment_method' => $request->payment_method
                ]);

                $hajjManifestPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'status' => $request->status,
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
                    'payment_method' => $request->payment_method
                ]);
            } else {
                $total_payment = ($hajj_manifest->total_payment + $hajjManifestPayment->refund_amount) - $request->refund_amount;
                $remaining_payment = $hajj_manifest->total_price - $total_payment;

                if ($total_payment >= $umroh_manifest->total_price) {
                    $status = 'Completed';
                } else {
                    $status = 'Waiting';
                }

                $hajj_manifest->update([
                    'total_payment' => $total_payment,
                    'remaining_payment' => $hajj_manifest->total_price - $total_payment,
                    'last_amount' => $request->refund_amount,
                    'status' => $status,
                    'payment_method' => $request->payment_method
                ]);

                $hajjManifestPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'status' => $request->status,
                    'note' => $request->note,
                    'hajj_manifest_customer_id' => $request->hajj_manifest_customer_id,
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

        return view('manifest::hajj.payments.view', compact('hajjManifestPayment', 'hajj_manifest', 'customer'));
    }


    public function destroy(HajjManifestPayment $hajjManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($hajjManifestPayment) {
            $hajj_manifest = $hajjManifestPayment->hajjManifestCustomers;

            if ($hajjManifestPayment->trx_type == 'Payment') {
                $hajj_manifest->update([
                    'total_payment' => $hajj_manifest->total_payment - $hajjManifestPayment->amount,
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
