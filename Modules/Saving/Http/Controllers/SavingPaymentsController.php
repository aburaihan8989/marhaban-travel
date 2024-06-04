<?php

namespace Modules\Saving\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Storage;
use Modules\People\Entities\Customer;
use Modules\Saving\Entities\Saving;
use Modules\Saving\Entities\SavingPayment;
use Illuminate\Contracts\Support\Renderable;
use Modules\Saving\DataTables\SavingPaymentsDataTable;

class SavingPaymentsController extends Controller
{

    public function index($saving_id, SavingPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_saving = Saving::findOrFail($saving_id);

        return $dataTable->render('saving::umroh.payments.index', compact('umroh_saving'));
    }


    public function create($saving_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_saving = Saving::findOrFail($saving_id);

        return view('saving::umroh.payments.create', compact('umroh_saving'));
    }

    public function refund($saving_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_saving = Saving::findOrFail($saving_id);

        return view('saving::umroh.payments.refund', compact('umroh_saving'));
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request) {

            if ($request->trx_type == 'Saving') {
                $savingPayment = SavingPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'saving_id' => $request->saving_id,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $savingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }

                $umroh_saving = Saving::findOrFail($request->saving_id);
                $total_saving = $umroh_saving->total_saving + $request->amount;

                $umroh_saving->update([
                    'last_amount' => $request->amount,
                    'total_saving' => $total_saving,
                    'payment_method' => $request->payment_method
                ]);
            } else {
                $savingPayment = SavingPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'saving_id' => $request->saving_id,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $savingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }

                $umroh_saving = Saving::findOrFail($request->saving_id);
                $total_saving = $umroh_saving->total_saving - $request->refund_amount;

                $umroh_saving->update([
                    'last_amount' => $request->refund_amount,
                    'total_saving' => $total_saving,
                    'payment_method' => $request->payment_method
                ]);
            }

        });

        toast('Umroh Saving Payment Created!', 'success');

        return redirect()->route('umroh-savings.index');
    }


    public function edit($saving_id, SavingPayment $savingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $umroh_saving = Saving::findOrFail($saving_id);

        return view('saving::umroh.payments.edit', compact('savingPayment', 'umroh_saving'));
    }


    public function update(Request $request, SavingPayment $savingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request, $savingPayment) {
            $umroh_saving = $savingPayment->savings;

            if ($savingPayment->trx_type == 'Saving') {
                $umroh_saving->update([
                    'total_saving' => ($umroh_saving->total_saving - $savingPayment->amount) + $request->amount,
                    'last_amount' => $request->amount,
                    'payment_method' => $request->payment_method
                ]);

                $savingPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'status' => $request->status,
                    'saving_id' => $request->saving_id,
                    'payment_method' => $request->payment_method
                ]);

            } else {
                $umroh_saving->update([
                    'total_saving' => ($umroh_saving->total_saving + $savingPayment->refund_amount) - $request->refund_amount,
                    'last_amount' => $request->refund_amount,
                    'payment_method' => $request->payment_method
                ]);

                $savingPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'note' => $request->note,
                    'status' => $request->status,
                    'saving_id' => $request->saving_id,
                    'payment_method' => $request->payment_method
                ]);

            }

            if ($request->has('document')) {
                if (count($savingPayment->getMedia('savings')) > 0) {
                    foreach ($savingPayment->getMedia('savings') as $media) {
                        if (!in_array($media->file_name, $request->input('document', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $savingPayment->getMedia('savings')->pluck('file_name')->toArray();

                foreach ($request->input('document', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $savingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }
            }

        });

        toast('Umroh Saving Payment Updated!', 'info');

        return redirect()->route('umroh-saving-payments.index', $savingPayment->saving_id);
    }


    public function view($saving_id, SavingPayment $savingPayment) {
        // abort_if(Gate::denies('show_products'), 403);
        $umroh_saving = Saving::findOrFail($saving_id);
        $customer = Customer::findOrFail($umroh_saving->customer_id);

        return view('saving::umroh.payments.view', compact('savingPayment', 'umroh_saving', 'customer'));
    }


    public function destroy(SavingPayment $savingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($savingPayment) {
            $umroh_saving = $savingPayment->savings;

            $umroh_saving->update([
                'total_saving' => $umroh_saving->total_saving - $savingPayment->amount
            ]);
        });

        $savingPayment->delete();

        toast('Umroh Saving Payment Deleted!', 'warning');

        return redirect()->route('umroh-savings.index');
    }
}
