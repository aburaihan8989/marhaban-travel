<?php

namespace Modules\Saving\Http\Controllers;

use Modules\Saving\DataTables\HajjSavingPaymentsDataTable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Saving\Entities\HajjSaving;
use Modules\Saving\Entities\HajjSavingPayment;

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


    public function store(Request $request) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'saving_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request) {

            HajjSavingPayment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'saving_id' => $request->saving_id,
                'payment_method' => $request->payment_method
            ]);

            $hajj_saving = HajjSaving::findOrFail($request->saving_id);

            // $due_amount = $purchase->due_amount - $request->amount;
            $total_saving = $hajj_saving->total_saving + $request->amount;

            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $hajj_saving->update([
                'last_amount' => $request->amount,
                'total_saving' => $total_saving,
                'payment_method' => $request->payment_method
            ]);
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

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'saving_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request, $hajjsavingPayment) {
            $hajj_saving = $hajjsavingPayment->hajjsavings;

            // $due_amount = ($purchase->due_amount + $purchasePayment->amount) - $request->amount;
            // $total_saving = ($hajjsaving->total_saving - $savingPayment->amount) + $request->amount;

            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $hajj_saving->update([
                'total_saving' => ($hajj_saving->total_saving - $hajjsavingPayment->amount) + $request->amount,
                'last_amount' => $request->amount,
                'payment_method' => $request->payment_method
            ]);

            $hajjsavingPayment->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'saving_id' => $request->saving_id,
                'payment_method' => $request->payment_method
            ]);
        });

        toast('Hajj Saving Payment Updated!', 'info');

        return redirect()->route('hajj-savings.index');
    }


    public function destroy(HajjSavingPayment $hajjsavingPayment) {
        // abort_if(Gate::denies('access_purchase_payments'), 403);

        DB::transaction(function () use ($hajjsavingPayment) {
            $hajj_saving = $hajjsavingPayment->hajjsavings;

            $hajj_saving->update([
                'total_saving' => $hajj_saving->total_saving - $hajjsavingPayment->amount
            ]);
        });

        $hajjsavingPayment->delete();

        toast('Hajj Saving Payment Deleted!', 'warning');

        return redirect()->route('hajj-savings.index');
    }
}
