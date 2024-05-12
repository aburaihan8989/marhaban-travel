<?php

namespace Modules\Expense\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Expense\Entities\UmrohExpense;
use Modules\Package\Entities\UmrohPackage;

class UmrohExpensesDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('amount', function ($data) {
                return format_currency($data->amount);
            })
            ->addColumn('package_code', function($data){
                return UmrohPackage::findOrFail($data->package_id)->package_code;
            })
            ->addColumn('package_name', function($data){
                return UmrohPackage::findOrFail($data->package_id)->package_name;
            })
            ->addColumn('action', function ($data) {
                return view('expense::umroh.partials.actions', compact('data'));
            });
    }

    public function query(UmrohExpense $model) {
        return $model->newQuery()->with('travelcategory');
        // return $model->newQuery();
    }


    public function html() {
        return $this->builder()
            ->setTableId('umroh-expenses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(4)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns() {
        return [
            Column::make('row_number')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false)
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::computed('package_code')
                ->title('Package Code')
                ->className('text-center align-middle'),

            Column::computed('package_name')
                ->title('Package Name')
                ->className('text-center align-middle'),

            Column::make('date')
                ->title('Payment Date')
                ->className('text-center align-middle'),

            Column::make('reference')
                ->className('text-center align-middle'),

            Column::make('travelcategory.category_name')
                ->title('Category')
                ->className('text-center align-middle'),

            Column::computed('amount')
                ->title('Payment Amount')
                ->className('text-center align-middle'),

            Column::make('details')
                ->className('text-center align-middle'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'UmrohExpenses_' . date('YmdHis');
    }
}
