<?php

namespace Modules\Manifest\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Modules\People\Entities\Agent;
use Modules\People\Entities\Customer;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Manifest\Entities\HajjManifestCustomer;

class HajjManifestCustomerDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->editColumn('register_date', function($model){
                $formatDate = date('d-m-Y',strtotime($model->register_date));
                return $formatDate;
            })
            ->addColumn('total_price', function ($data) {
                return format_currency($data->total_price);
            })
            ->addColumn('total_payment', function ($data) {
                return format_currency($data->total_payment);
            })
            ->addColumn('remaining_payment', function ($data) {
                return format_currency($data->remaining_payment);
            })
            ->addColumn('gender', function ($data) {
                return Customer::findOrFail($data->customer_id)->gender == 'L' ? 'Male' : 'Female';
            })
            ->addColumn('paspor_number', function ($data) {
                return Customer::findOrFail($data->customer_id)->paspor_number;
            })
            ->addColumn('place_birth', function ($data) {
                return Customer::findOrFail($data->customer_id)->place_birth;
            })
            ->addColumn('customer_phone', function ($data) {
                return Customer::findOrFail($data->customer_id)->customer_phone;
            })
            ->addColumn('paspor_issued', function ($data) {
                return Customer::findOrFail($data->customer_id)->paspor_issued;
            })
            ->editColumn('paspor_active', function($model){
                $formatDate = date('d-m-Y',strtotime(Customer::findOrFail($model->customer_id)->paspor_active));
                return $formatDate;
            })
            ->editColumn('paspor_date', function($model){
                $formatDate = date('d-m-Y',strtotime(Customer::findOrFail($model->customer_id)->paspor_date));
                return $formatDate;
            })
            ->editColumn('date_birth', function($model){
                $formatDate = \Carbon\Carbon::parse(date('d-m-Y',strtotime(Customer::findOrFail($model->customer_id)->date_birth)))->age . ' th';
                return $formatDate;
            })
            ->editColumn('customer_birth', function($model){
                $formatDate = date('d-m-Y',strtotime(Customer::findOrFail($model->customer_id)->date_birth));
                return $formatDate;
            })
            ->addColumn('age_group', function ($data) {
                return Customer::findOrFail($data->customer_id)->age_group == 'A' ? 'Adult' : (Customer::findOrFail($data->customer_id)->age_group == 'K' ? 'Kids' : 'Infant');
            })
            ->addColumn('city', function ($data) {
                return Customer::findOrFail($data->customer_id)->city;
            })
            // ->addColumn('agent_name', function ($model) {
            //     return Agent::findOrFail($model->agent_id)->agent_code . ' | ' . Agent::findOrFail($model->agent_id)->agent_name;
            // })
            ->addColumn('status', function ($data) {
                return view('manifest::hajj.partials.status-customer', compact('data'));
            })
            ->addColumn('action', function ($data) {
                return view('manifest::hajj.partials.actions-customer', compact('data'));
            });
    }

    public function query(HajjManifestCustomer $model) {
        return $model->newQuery()->with('agents')->where('manifest_id', request()->route('hajj_manifest'));
    }

    public function html() {
        return $this->builder()
            ->setTableId('hajj-manifest-customers-table')
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
                ->title('ID Register')
                ->className('text-center align-middle'),

            Column::computed('register_date')
                ->className('text-center align-middle'),

            Column::make('customer_name')
                ->className('text-center align-middle'),

            Column::computed('customer_birth')
                ->title('Date of Birth')
                ->className('text-center align-middle'),

            Column::computed('date_birth')
                ->title('Age (Year)')
                ->className('text-center align-middle'),

            Column::computed('place_birth')
                ->title('Place of Birth')
                ->className('text-center align-middle'),

            Column::computed('gender')
                ->title('Gender')
                ->className('text-center align-middle'),

            Column::computed('age_group')
                ->title('Age Group')
                ->className('text-center align-middle'),

            Column::make('customer_phone')
                ->title('Phone Number')
                ->className('text-center align-middle'),

            Column::computed('paspor_number')
                ->title('Paspor Number')
                ->className('text-center align-middle'),

            Column::computed('paspor_active')
                ->title('Paspor Active')
                ->className('text-center align-middle'),

            Column::computed('paspor_date')
                ->title('Paspor Expired')
                ->className('text-center align-middle'),

            Column::computed('paspor_issued')
                ->title('Paspor Issued')
                ->className('text-center align-middle'),

            Column::computed('room_group')
                ->title('Room')
                ->className('text-center align-middle'),

            Column::computed('family_group')
                ->title('Family Group')
                ->className('text-center align-middle'),

            Column::computed('baggage')
                ->title('Baggage')
                ->className('text-center align-middle'),

            Column::computed('city')
                ->title('City')
                ->className('text-center align-middle'),

            Column::computed('status')
                ->title('Payment Status')
                ->className('text-center align-middle'),

            Column::computed('total_payment')
                ->className('text-center align-middle'),

            Column::computed('remaining_payment')
                ->className('text-center align-middle'),

            Column::make('agents.agent_code')
                ->title('Agent Code')
                ->className('text-center align-middle'),

            Column::make('agents.agent_name')
                ->title('Agent Name')
                ->className('text-center align-middle'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle')

            // Column::make('created_at')
            //     ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'HajjManifestCustomer_' . date('YmdHis');
    }
}
