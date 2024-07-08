<?php

namespace Modules\People\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Modules\People\Entities\Agent;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\People\Entities\AgentPayment;

class AgentPaymentsDataTable extends DataTable
{
    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('amount', function ($data) {
                return $data->amount == '' ? $data->amount : format_currency($data->amount);
            })
            ->addColumn('status', function ($data) {
                return view('people::agents.payments.partials.status', compact('data'));
            })
            ->editColumn('agent_name', function($model){
                $getData = Agent::findOrFail($model->agent_id)->agent_name;
                return $getData;
            })
            ->addColumn('trx_type', function ($data) {
                return view('people::agents.payments.partials.type', compact('data'));
            })
            ->addColumn('action', function ($data) {
                return view('people::agents.payments.partials.actions', compact('data'));
            });
    }

    public function query(AgentPayment $model) {
        return $model->newQuery()->byAgent()->with('agents');
    }

    public function html() {
        return $this->builder()
            ->setTableId('agent-payments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(1)
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
                ->title('ID Reference')
                ->className('align-middle text-center'),

            Column::make('agent_name')
                ->title('Agent Name')
                ->className('align-middle text-center'),

            Column::computed('trx_type')
                ->title('Category')
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
                ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'AgentPayments_' . date('YmdHis');
    }
}
