<?php

namespace Modules\Saving\Http\Controllers;

use Modules\Saving\DataTables\SavingPaymentsDataTable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Saving\Entities\Saving;
use Modules\Saving\Entities\SavingPayment;

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

            SavingPayment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'saving_id' => $request->saving_id,
                'payment_method' => $request->payment_method
            ]);

            $umroh_saving = Saving::findOrFail($request->saving_id);

            // $due_amount = $purchase->due_amount - $request->amount;
            $total_saving = $umroh_saving->total_saving + $request->amount;

            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

            $umroh_saving->update([
                'last_amount' => $request->amount,
                'total_saving' => $total_saving,
                'payment_method' => $request->payment_method
            ]);
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

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'saving_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request, $savingPayment) {
            $umroh_saving = $savingPayment->savings;

            // $due_amount = ($purchase->due_amount + $purchasePayment->amount) - $request->amount;
            // $total_saving = ($saving->total_saving - $savingPayment->amount) + $request->amount;

            // if ($due_amount == $purchase->total_amount) {
            //     $payment_status = 'Unpaid';
            // } elseif ($due_amount > 0) {
            //     $payment_status = 'Partial';
            // } else {
            //     $payment_status = 'Paid';
            // }

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
                'saving_id' => $request->saving_id,
                'payment_method' => $request->payment_method
            ]);
        });

        toast('Umroh Saving Payment Updated!', 'info');

        return redirect()->route('umroh-savings.index');
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
