<?php

namespace Modules\People\DataTables;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Modules\People\Entities\Agent;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Manifest\Entities\HajjManifestCustomer;
use Modules\Manifest\Entities\UmrohManifestCustomer;

class ShowAgentsDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('referal_agent', function ($data) {
                return Agent::findOrFail($data->referal_id)->agent_code . ' | ' . Agent::findOrFail($data->referal_id)->agent_name;
            })
            ->addColumn('referal_level', function ($data) {
                return Agent::findOrFail($data->referal_id)->level_agent;
            })
            ->addColumn('customer_count', function ($data) {
                $umroh_customers = UmrohManifestCustomer::where('agent_id', $data->id)->count();
                $hajj_customers = HajjManifestCustomer::where('agent_id', $data->id)->count();
                return ($umroh_customers + $hajj_customers);
            })
            ->addColumn('referal_reward', function ($data) {
                $data = UmrohManifestCustomer::where('agent_id', $data->id)->sum('referal_reward');
                return format_currency($data);
            })
            ->addColumn('action', function ($data) {
                return view('people::agents.rewards.partials.actions-referal', compact('data'));
            });
    }

    public function query(Agent $model) {
        return $model->newQuery()->where('referal_id', request()->route('agent_id'));
    }

    public function html() {
        return $this->builder()
            ->setTableId('agents-table')
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

            Column::make('agent_code')
                ->title('Agent Code')
                ->className('text-center align-middle'),

            Column::make('agent_name')
                ->title('Agent Name')
                ->className('text-center align-middle'),

            Column::make('agent_phone')
                ->title('Phone Number')
                ->className('text-center align-middle'),

            Column::computed('level_agent')
                ->title('Agent Level')
                ->className('text-center align-middle'),

            Column::make('customer_count')
                ->title('Customers Count')
                ->className('text-center align-middle'),

            Column::make('city')
                ->className('text-center align-middle'),

            Column::make('referal_agent')
                ->title('Referal Agent')
                ->className('text-center align-middle'),

            Column::make('referal_level')
                ->title('Referal Level')
                ->className('text-center align-middle'),

            Column::make('referal_reward')
                ->title('Referal Rewards')
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
        return 'ShowAgents_' . date('YmdHis');
    }
}
