<?php

namespace Modules\People\DataTables;


use Modules\People\Entities\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('gender', function ($data) {
                return $data->gender == 'L' ? 'Male' : 'Female';
            })
            ->addColumn('customer_age', function($data){
                $formatDate = \Carbon\Carbon::parse(date('d-m-Y',strtotime($data->date_birth)))->age . ' th';
                return $formatDate; })
            ->addColumn('action', function ($data) {
                return view('people::customers.partials.actions', compact('data'));
            });
    }

    public function query(Customer $model) {
        return $model->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('customers-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                       'tr' .
                                 <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(0)
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
            Column::make('id')
                ->visible(false),

            Column::make('row_number')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false)
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('nik_number')
                ->title('NIK Customer')
                ->className('text-center align-middle'),

            Column::make('customer_name')
                ->className('text-center align-middle'),

            Column::make('customer_phone')
                ->title('Phone Number')
                ->className('text-center align-middle'),

            Column::make('gender')
                ->title('Gender')
                ->className('text-center align-middle'),

            Column::make('date_birth')
                ->title('Date of Birth')
                ->className('text-center align-middle'),

            Column::make('customer_age')
                ->title('Age (Year)')
                ->className('text-center align-middle'),

            Column::make('paspor_number')
                ->className('text-center align-middle'),

            Column::make('customer_status')
                ->title('Member')
                ->className('text-center align-middle'),

            Column::make('city')
                ->title('City')
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
        return 'Customers_' . date('YmdHis');
    }
}
