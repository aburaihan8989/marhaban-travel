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

class RewardsDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('total_reward', function ($data) {
                return format_currency($data->total_reward);
            })
            ->addColumn('paid_reward', function ($data) {
                return format_currency($data->paid_reward);
            })
            ->addColumn('agents_count', function ($data) {
                if ($data->referal_id == $data->id){
                    $getData = Agent::where('referal_id', $data->id)->count();
                    return ($getData-1);
                } else {
                    return Agent::where('referal_id', $data->id)->count();
                }
            })
            ->addColumn('customer_count', function ($data) {
                $umroh_customers = UmrohManifestCustomer::where('agent_id', $data->id)->count();
                $hajj_customers = HajjManifestCustomer::where('agent_id', $data->id)->count();
                return ($umroh_customers+$hajj_customers);
            })
            ->addColumn('action', function ($data) {
                return view('people::agents.rewards.partials.actions', compact('data'));
            });
    }

    public function query(Agent $model) {
        return $model->newQuery();
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
                ->className('text-center align-middle'),

            Column::make('agent_phone')
                ->title('Phone Number')
                ->className('text-center align-middle'),

            Column::computed('level_agent')
                ->title('Agent Level')
                ->className('text-center align-middle'),

            Column::make('agents_count')
                ->title('Agents')
                ->className('text-center align-middle'),

            Column::make('customer_count')
                ->title('Customers')
                ->className('text-center align-middle'),

            Column::computed('total_reward')
                ->title('Total Rewards')
                ->className('text-center align-middle'),

            Column::computed('paid_reward')
                ->title('Paid Rewards')
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
        return 'Rewards_' . date('YmdHis');
    }
}
