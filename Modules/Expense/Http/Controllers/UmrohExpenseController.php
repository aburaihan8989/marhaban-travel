<?php

namespace Modules\Expense\Http\Controllers;

use Modules\Expense\DataTables\UmrohExpensesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Expense\Entities\UmrohExpense;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class UmrohExpenseController extends Controller
{

    public function index(UmrohExpensesDataTable $dataTable) {
        abort_if(Gate::denies('access_expenses'), 403);

        return $dataTable->render('expense::umroh.index');
    }


    public function create() {
        abort_if(Gate::denies('create_expenses'), 403);

        return view('expense::umroh.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_expenses'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'category_id' => 'required',
            'amount' => 'required|numeric|max:2147483647',
            'details' => 'nullable|string|max:1000'
        ]);

        UmrohExpense::create([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'amount' => $request->amount,
            'details' => $request->details
        ]);

        toast('Umroh Expense Created!', 'success');

        return redirect()->route('umroh-expenses.index');
    }


    public function edit(UmrohExpense $umroh_expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        return view('expense::umroh.edit', compact('umroh_expense'));
    }


    public function update(Request $request, UmrohExpense $umroh_expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'category_id' => 'required',
            'amount' => 'required|numeric|max:2147483647',
            'details' => 'nullable|string|max:1000'
        ]);

        $umroh_expense->update([
            'date' => $request->date,
            'reference' => $request->reference,
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'amount' => $request->amount,
            'details' => $request->details
        ]);

        toast('Umroh Expense Updated!', 'info');

        return redirect()->route('umroh-expenses.index');
    }


    public function destroy(UmrohExpense $umroh_expense) {
        abort_if(Gate::denies('delete_expenses'), 403);

        $umroh_expense->delete();

        toast('Umroh Expense Deleted!', 'warning');

        return redirect()->route('umroh-expenses.index');
    }
}
