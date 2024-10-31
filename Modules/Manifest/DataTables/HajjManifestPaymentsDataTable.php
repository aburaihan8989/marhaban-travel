<?php

namespace Modules\Manifest\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Manifest\Entities\HajjManifestPayment;
use Modules\Manifest\Entities\HajjManifestCustomer;

class HajjManifestPaymentsDataTable extends DataTable
{
    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('amount', function ($data) {
                return format_currency($data->amount);
            })
            ->addColumn('status', function ($data) {
                return view('manifest::hajj.payments.partials.status', compact('data'));
            })
            ->editColumn('customer_name', function($model){
                $getData = HajjManifestCustomer::findOrFail($model->hajj_manifest_customer_id)->customer_name;
                return $getData;
            })
            ->editColumn('customer_phone', function($model){
                $getData = HajjManifestCustomer::findOrFail($model->hajj_manifest_customer_id)->customer_phone;
                return $getData;
            })
            ->addColumn('action', function ($data) {
                return view('manifest::hajj.payments.partials.actions', compact('data'));
            });
    }

    public function query(HajjManifestPayment $model) {
        return $model->newQuery()->byHajjManifestCustomer()->with('hajjManifestCustomers');
    }

    public function html() {
        return $this->builder()
            ->setTableId('hajj-manifest-payments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(2)
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

            Column::make('date')
                ->title('Transaction Date')
                ->className('align-middle text-center'),

            Column::make('reference')
                ->title('ID Transaction')
                ->className('align-middle text-center'),

            Column::make('customer_name')
                ->title('Customer Name')
                ->className('align-middle text-center'),

            Column::make('customer_phone')
                ->title('Phone Number')
                ->className('align-middle text-center'),

            Column::computed('amount')
                ->title('Payment Amount')
                ->className('align-middle text-center'),

            Column::make('payment_method')
                ->title('Method')
                ->className('align-middle text-center'),

            Column::computed('status')
                ->title('Approval Status')
                ->className('align-middle text-center'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('align-middle text-center'),

            Column::make('created_at')
                ->visible(false),
        ];
    }

    protected function filename(): string {
        return 'HajjManifestPayments_' . date('YmdHis');
    }
}
