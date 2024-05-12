<?php

namespace Modules\Expense\Http\Controllers;

use Modules\Expense\DataTables\HajjExpensesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Expense\Entities\HajjExpense;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class HajjExpenseController extends Controller
{

    public function index(HajjExpensesDataTable $dataTable) {
        abort_if(Gate::denies('access_expenses'), 403);

        return $dataTable->render('expense::hajj.index');
    }


    public function create() {
        abort_if(Gate::denies('create_expenses'), 403);

        return view('expense::hajj.create');
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

        HajjExpense::create([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'amount' => $request->amount,
            'details' => $request->details
        ]);

        toast('Hajj Expense Created!', 'success');

        return redirect()->route('hajj-expenses.index');
    }


    public function edit(HajjExpense $hajj_expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        return view('expense::hajj.edit', compact('hajj_expense'));
    }


    public function update(Request $request, HajjExpense $hajj_expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'category_id' => 'required',
            'amount' => 'required|numeric|max:2147483647',
            'details' => 'nullable|string|max:1000'
        ]);

        $hajj_expense->update([
            'date' => $request->date,
            'reference' => $request->reference,
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'amount' => $request->amount,
            'details' => $request->details
        ]);

        toast('Hajj Expense Updated!', 'info');

        return redirect()->route('hajj-expenses.index');
    }


    public function destroy(HajjExpense $hajj_expense) {
        abort_if(Gate::denies('delete_expenses'), 403);

        $hajj_expense->delete();

        toast('Hajj Expense Deleted!', 'warning');

        return redirect()->route('hajj-expenses.index');
    }
}
