<?php

namespace Modules\People\DataTables;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Modules\People\Entities\Agent;
use Modules\People\Entities\Customer;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Package\Entities\UmrohPackage;
use Modules\Manifest\Entities\UmrohManifestCustomer;

class ShowCustomersDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('customer_name', function ($data) {
                return Customer::findOrFail($data->customer_id)->customer_name;
            })
            ->addColumn('customer_phone', function ($data) {
                return Customer::findOrFail($data->customer_id)->customer_phone;
            })
            ->addColumn('city', function ($data) {
                return Customer::findOrFail($data->customer_id)->city;
            })
            ->addColumn('customer_package', function ($data) {
                return UmrohPackage::findOrFail($data->package_id)->package_name;
            })
            ->addColumn('agent_code', function ($data) {
                return Agent::findOrFail($data->agent_id)->agent_code;
            })
            ->addColumn('agent_name', function ($data) {
                return Agent::findOrFail($data->agent_id)->agent_name;
            })
            ->addColumn('agent_reward', function ($data) {
                return format_currency($data->agent_reward);
            })
            ->addColumn('action', function ($data) {
                return view('people::agents.rewards.partials.actions', compact('data'));
            });
    }

    public function query(UmrohManifestCustomer $model) {
        return $model->newQuery()->where('agent_id', request()->route('agent_id'));
    }

    public function html() {
        return $this->builder()
            ->setTableId('umroh-manifest-customers-table')
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

            Column::make('reference')
                ->title('Reference ID')
                ->className('text-center align-middle'),

            Column::make('customer_name')
                ->className('text-center align-middle'),

            Column::make('customer_phone')
                ->title('Phone Number')
                ->className('text-center align-middle'),

            Column::make('city')
                ->className('text-center align-middle'),

            Column::make('customer_package')
                ->className('text-center align-middle'),

            Column::make('agent_code')
                ->title('Agent Code')
                ->className('text-center align-middle'),

            Column::make('agent_name')
                ->title('Agent Name')
                ->className('text-center align-middle'),

            Column::make('agent_reward')
                ->title('Agent Rewards')
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'ShowCustomers_' . date('YmdHis');
    }
}
