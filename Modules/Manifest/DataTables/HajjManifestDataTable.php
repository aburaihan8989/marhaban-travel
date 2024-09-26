<?php

namespace Modules\Manifest\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Package\Entities\HajjPackage;
use Modules\Manifest\Entities\HajjManifest;
use Modules\Manifest\Entities\HajjManifestCustomer;

class HajjManifestDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('total_price', function ($data) {
                return format_currency($data->total_price);
            })
            ->addColumn('total_payment', function ($data) {
                return format_currency($data->total_payment);
            })
            ->addColumn('remaining_payment', function ($data) {
                return format_currency($data->remaining_payment);
            })
            ->addColumn('package_date', function ($data) {
                $formatDate = date('d-m-Y',strtotime(HajjPackage::findOrFail($data->package_id)->package_date));
                return $formatDate;
            })
            // ->addColumn('package_name', function ($data) {
            //     return HajjPackage::findOrFail($data->package_id)->package_name;
            // })
            ->addColumn('package_departure', function ($data) {
                return HajjPackage::findOrFail($data->package_id)->package_departure;
            })
            ->addColumn('flight_route', function ($data) {
                return HajjPackage::findOrFail($data->package_id)->flight_route;
            })
            ->editColumn('package_days', function($data){
                $formatData = HajjPackage::findOrFail($data->package_id)->package_days . ' Days';
                return $formatData;
            })
            ->editColumn('package_capacity', function($data){
                $formatData = HajjPackage::findOrFail($data->package_id)->package_capacity . ' Pax';
                return $formatData;
            })
            ->editColumn('package_booked', function($data){
                $formatData = HajjManifestCustomer::where('manifest_id', $data->id)->count() . ' Pax';
                return $formatData;
            })
            ->addColumn('status', function ($data) {
                return view('manifest::hajj.partials.status', compact('data'));
            })
            ->addColumn('action', function ($data) {
                return view('manifest::hajj.partials.actions', compact('data'));
            });
    }

    public function query(HajjManifest $model) {
        return $model->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('hajj-manifests-table')
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

                Column::make('reference')
                ->title('Manifest Code')
                ->className('text-center align-middle'),

            Column::make('package_code')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_date')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_name')
                ->className('text-center align-middle'),

            Column::make('package_departure')
                ->title('Departure')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('flight_route')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_days')
                ->title('Days')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_capacity')
                ->title('Seat')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_booked')
                ->title('Booked')
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('status')
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
        return 'HajjManifest_' . date('YmdHis');
    }
}
