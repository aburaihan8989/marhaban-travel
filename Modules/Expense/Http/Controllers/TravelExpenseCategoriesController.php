<?php

namespace Modules\Expense\Http\Controllers;

use Modules\Expense\DataTables\TravelExpenseCategoriesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Expense\Entities\TravelExpenseCategory;

class TravelExpenseCategoriesController extends Controller
{

    public function index(TravelExpenseCategoriesDataTable $dataTable) {
        abort_if(Gate::denies('access_expense_categories'), 403);

        return $dataTable->render('expense::category.index');
    }

    public function store(Request $request) {
        abort_if(Gate::denies('access_expense_categories'), 403);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:travel_expense_categories,category_name',
            'category_description' => 'nullable|string|max:1000'
        ]);

        TravelExpenseCategory::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description
        ]);

        toast('Travel Expense Category Created!', 'success');

        return redirect()->route('travel-expense-categories.index');
    }


    public function edit(TravelExpenseCategory $travel_expense_category) {
        abort_if(Gate::denies('access_expense_categories'), 403);

        return view('expense::category.edit', compact('travel_expense_category'));
    }


    public function update(Request $request, TravelExpenseCategory $travel_expense_category) {
        abort_if(Gate::denies('access_expense_categories'), 403);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:travel_expense_categories,category_name,' . $travel_expense_category->id,
            'category_description' => 'nullable|string|max:1000'
        ]);

        $travel_expense_category->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description
        ]);

        toast('Travel Expense Category Updated!', 'info');

        return redirect()->route('travel-expense-categories.index');
    }


    public function destroy(TravelExpenseCategory $travelexpenseCategory) {
        abort_if(Gate::denies('access_expense_categories'), 403);

        if ($travelexpenseCategory->umrohexpenses()->isNotEmpty()) {
            return back()->withErrors('Can\'t delete beacuse there are expenses associated with this category.');
        }

        $travelexpenseCategory->delete();

        toast('Travel Expense Category Deleted!', 'warning');

        return redirect()->route('travel-expense-categories.index');
    }
}
