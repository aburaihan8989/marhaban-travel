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
use Modules\Manifest\Entities\UmrohManifest;
use Modules\Manifest\Entities\UmrohManifestPayment;
use Modules\Manifest\Entities\UmrohManifestCustomer;
use Modules\Manifest\DataTables\UmrohManifestPaymentsDataTable;

class UmrohManifestPaymentsController extends Controller
{

    public function index($umroh_manifest_customer_id, UmrohManifestPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);
        // @dd($umroh_manifest_customer_id);
        $umroh_manifest = UmrohManifestCustomer::findOrFail($umroh_manifest_customer_id);

        return $dataTable->render('manifest::umroh.payments.index', compact('umroh_manifest'));
    }


    public function create($umroh_manifest_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_manifest = UmrohManifestCustomer::findOrFail($umroh_manifest_id);

        return view('manifest::umroh.payments.create', compact('umroh_manifest'));
    }


    public function store(Request $request, UmrohManifestCustomer $umroh_manifest_customer_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);
        // @dd($umroh_manifest_customer_id);

        // $request->validate([
        //     'date' => 'required|date',
        //     'reference' => 'required|string|max:255',
        //     'amount' => 'required|numeric',
        //     'note' => 'nullable|string|max:1000',
        //     'umroh_manifest_id' => 'required',
        //     'payment_method' => 'required|string|max:255'
        // ]);

        DB::transaction(function () use ($request, $umroh_manifest_customer_id) {

            // UmrohManifestPayment::create([
            //     'date' => $request->date,
            //     'reference' => $request->reference,
            //     'amount' => $request->amount,
            //     'note' => $request->note,
            //     'umroh_manifest_customer_id' => $request->umroh_manifest_customer_id,
            //     'payment_method' => $request->payment_method
            // ]);

            $umrohManifestPayment = UmrohManifestPayment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'status' => 'Approval',
                'note' => $request->note,
                'umroh_manifest_customer_id' => $request->umroh_manifest_customer_id,
                'payment_method' => $request->payment_method
            ]);

            if ($request->has('document')) {
                foreach ($request->input('document', []) as $file) {
                    $umrohManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                }
            }

            $umroh_manifest = UmrohManifestCustomer::findOrFail($request->umroh_manifest_customer_id);

            // @dd($umroh_manifest);

            // $due_amount = $purchase->due_amount - $request->amount;
            $total_payment = $umroh_manifest->total_payment + $request->amount;
            $remaining_payment = $umroh_manifest->total_price - $total_payment;
            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $umroh_manifest->update([
                'last_amount' => $request->amount,
                'total_payment' => $total_payment,
                'remaining_payment' => $remaining_payment,
                'payment_method' => $request->payment_method
            ]);
        });

        toast('Umroh Manifest Customer Payment Created!', 'success');

        return redirect()->route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id);
    }


    public function edit($umroh_manifest_customer_id, UmrohManifestPayment $umrohManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_manifest = UmrohManifestCustomer::findOrFail($umroh_manifest_customer_id);

        return view('manifest::umroh.payments.edit', compact('umrohManifestPayment', 'umroh_manifest'));
    }


    public function update(Request $request, UmrohManifestPayment $umrohManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);
    // @dd($request);
        // $request->validate([
        //     'date' => 'required|date',
        //     'reference' => 'required|string|max:255',
        //     'amount' => 'required|numeric',
        //     'note' => 'nullable|string|max:1000',
        //     'umroh_manifest_customer_id' => 'required',
        //     'payment_method' => 'required|string|max:255'
        // ]);

        DB::transaction(function () use ($request, $umrohManifestPayment) {
            $umroh_manifest = $umrohManifestPayment->umrohManifestCustomers;

            // $due_amount = ($purchase->due_amount + $purchasePayment->amount) - $request->amount;
            // $total_saving = ($saving->total_saving - $savingPayment->amount) + $request->amount;

            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $umroh_manifest->update([
                'total_payment' => ($umroh_manifest->total_payment - $umrohManifestPayment->amount) + $request->amount,
                'remaining_payment' => $umroh_manifest->total_price - (($umroh_manifest->total_payment - $umrohManifestPayment->amount) + $request->amount),
                'last_amount' => $request->amount,
                'payment_method' => $request->payment_method
            ]);

            $umrohManifestPayment->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'status' => $request->status,
                'note' => $request->note,
                'umroh_manifest_customer_id' => $request->umroh_manifest_customer_id,
                'payment_method' => $request->payment_method
            ]);
            // $umroh_package->update($request->except('document'));

            if ($request->has('document')) {
                if (count($umrohManifestPayment->getMedia('payments')) > 0) {
                    foreach ($umrohManifestPayment->getMedia('payments') as $media) {
                        if (!in_array($media->file_name, $request->input('document', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $umrohManifestPayment->getMedia('payments')->pluck('file_name')->toArray();

                foreach ($request->input('document', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $umrohManifestPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('payments');
                    }
                }
            }

        });

        toast('Umroh Manifest Customer Payment Updated!', 'info');

        return redirect()->route('umroh-manifest-payments.index', $umrohManifestPayment->umroh_manifest_customer_id);
    }


    public function view($umroh_manifest_customer_id, UmrohManifestPayment $umrohManifestPayment) {
        // abort_if(Gate::denies('show_products'), 403);
        $umroh_manifest = UmrohManifestCustomer::findOrFail($umroh_manifest_customer_id);
        $customer = Customer::findOrFail($umroh_manifest->customer_id);

        return view('manifest::umroh.payments.view', compact('umrohManifestPayment', 'umroh_manifest', 'customer'));
    }


    public function destroy(UmrohManifestPayment $umrohManifestPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($umrohManifestPayment) {
            $umroh_manifest = $umrohManifestPayment->umrohManifestCustomers;

            $umroh_manifest->update([
                'total_payment' => $umroh_manifest->total_payment - $umrohManifestPayment->amount,
                'remaining_payment' => $umroh_manifest->total_price - ($umroh_manifest->total_payment - $umrohManifestPayment->amount)
            ]);
        });

        $umrohManifestPayment->delete();

        toast('Umroh Manifest Customer Payment Deleted!', 'warning');

        return redirect()->route('umroh-manage-manifests.manage', $umrohManifestPayment->umrohManifestCustomers->manifest_id);
    }
}
