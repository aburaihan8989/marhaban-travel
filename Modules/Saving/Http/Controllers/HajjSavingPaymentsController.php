<?php

namespace Modules\Saving\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Agent;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Illuminate\Support\Facades\Storage;
use Modules\Saving\Entities\HajjSaving;
use Illuminate\Contracts\Support\Renderable;
use Modules\Saving\Entities\HajjSavingPayment;
use Modules\Saving\DataTables\HajjSavingPaymentsDataTable;

class HajjSavingPaymentsController extends Controller
{

    public function index($saving_id, HajjSavingPaymentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_saving = HajjSaving::findOrFail($saving_id);

        return $dataTable->render('saving::hajj.payments.index', compact('hajj_saving'));
    }


    public function create($saving_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_saving = HajjSaving::findOrFail($saving_id);

        return view('saving::hajj.payments.create', compact('hajj_saving'));
    }


    public function refund($saving_id) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_saving = HajjSaving::findOrFail($saving_id);

        return view('saving::hajj.payments.refund', compact('hajj_saving'));
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request) {

            if ($request->trx_type == 'Saving') {
                $HajjSavingPayment = HajjSavingPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'saving_id' => $request->saving_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $HajjSavingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }

                $hajj_saving = HajjSaving::findOrFail($request->saving_id);
                $total_saving = $hajj_saving->total_saving + $request->amount;

                $hajj_saving->update([
                    'last_amount' => $request->amount,
                    'total_saving' => $total_saving,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            } else {
                $HajjSavingPayment = HajjSavingPayment::create([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'trx_type' => $request->trx_type,
                    'status' => 'Approval',
                    'note' => $request->note,
                    'saving_id' => $request->saving_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $HajjSavingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }

                $hajj_saving = HajjSaving::findOrFail($request->saving_id);
                $total_saving = $hajj_saving->total_saving - $request->refund_amount;

                $hajj_saving->update([
                    'last_amount' => $request->refund_amount,
                    'total_saving' => $total_saving,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            }

        });

        toast('Hajj Saving Payment Created!', 'success');

        return redirect()->route('hajj-savings.index');
    }


    public function edit($saving_id, HajjSavingPayment $hajjsavingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $hajj_saving = HajjSaving::findOrFail($saving_id);

        return view('saving::hajj.payments.edit', compact('hajjsavingPayment', 'hajj_saving'));
    }


    public function update(Request $request, HajjSavingPayment $hajjsavingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($request, $hajjsavingPayment) {
            $hajj_saving = $hajjsavingPayment->hajjsavings;

            if ($hajjsavingPayment->trx_type == 'Saving') {
                $hajj_saving->update([
                    'total_saving' => ($hajj_saving->total_saving - $hajjsavingPayment->amount) + $request->amount,
                    'last_amount' => $request->amount,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                $hajjsavingPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'status' => $request->status,
                    'saving_id' => $request->saving_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

            } else {
                $hajj_saving->update([
                    'total_saving' => ($hajj_saving->total_saving + $hajjsavingPayment->refund_amount) - $request->refund_amount,
                    'last_amount' => $request->refund_amount,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);

                $hajjsavingPayment->update([
                    'date' => $request->date,
                    'reference' => $request->reference,
                    'refund_amount' => $request->refund_amount,
                    'note' => $request->note,
                    'status' => $request->status,
                    'saving_id' => $request->saving_id,
                    'payment_reference' => $request->payment_reference,
                    'payment_method' => $request->payment_method
                ]);
            }

            if ($request->has('document')) {
                if (count($hajjsavingPayment->getMedia('savings')) > 0) {
                    foreach ($hajjsavingPayment->getMedia('savings') as $media) {
                        if (!in_array($media->file_name, $request->input('document', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $hajjsavingPayment->getMedia('savings')->pluck('file_name')->toArray();

                foreach ($request->input('document', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $hajjsavingPayment->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('savings');
                    }
                }
            }

        });

        toast('Hajj Saving Payment Updated!', 'info');

        return redirect()->route('hajj-saving-payments.index', $hajjsavingPayment->saving_id);
    }


    public function view($saving_id, HajjSavingPayment $hajjsavingPayment) {
        // abort_if(Gate::denies('show_products'), 403);
        $hajj_saving = HajjSaving::findOrFail($saving_id);
        $customer = Customer::findOrFail($hajj_saving->customer_id);
        $agent = Agent::findOrFail($hajj_saving->agent_id);

        return view('saving::hajj.payments.view', compact('hajjsavingPayment', 'hajj_saving', 'customer', 'agent'));
    }


    public function destroy(HajjSavingPayment $hajjsavingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($hajjsavingPayment) {
            $hajj_saving = $hajjsavingPayment->hajjsavings;

            if ($hajjsavingPayment->trx_type == 'Saving') {
                $hajj_saving->update([
                    'total_saving' => $hajj_saving->total_saving - $hajjsavingPayment->amount
                ]);
            } else {
                $hajj_saving->update([
                    'total_saving' => $hajj_saving->total_saving + $hajjsavingPayment->refund_amount
                ]);
            }
        });

        $hajjsavingPayment->delete();

        toast('Hajj Saving Payment Deleted!', 'warning');

        return redirect()->route('hajj-savings.index');
    }
}
