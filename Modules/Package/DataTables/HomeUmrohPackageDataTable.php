<?php

namespace Modules\Package\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Modules\Package\Entities\UmrohPackage;
use Modules\Manifest\Entities\UmrohManifestCustomer;

class HomeUmrohPackageDataTable extends DataTable
{


    public function dataTable($query)
    {
        return dataTables()
            // ->eloquent($query)->with('category')
            ->eloquent($query)
            ->editColumn('package_date', function($model){
                $formatDate = date('d-m-Y',strtotime($model->package_date));
                return $formatDate;
            })
            ->editColumn('package_capacity', function($model){
                $formatData = $model->package_capacity . ' Pax';
                return $formatData;
            })
            ->editColumn('package_booked', function($model){
                $formatData = UmrohManifestCustomer::where('package_id', $model->id)->count() . ' Pax';
                return $formatData;
            })
            ->editColumn('package_available', function($model){
                $formatData1 = $model->package_capacity;
                $formatData2 = UmrohManifestCustomer::where('package_id', $model->id)->count();
                $formatData = $formatData1 - $formatData2 . ' Pax';
                return $formatData;
            })
            ->editColumn('package_days', function($model){
                $formatDay = $model->package_days . ' Days';
                return $formatDay;
            });
            // ->addColumn('action', function ($data) {
            //     return view('package::umroh.partials.actions', compact('data'));
            // });
    }

    public function query(UmrohPackage $model)
    {
        // return $model->newQuery()->with('category');
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('umroh-packages-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
                    ->orderBy(1,'asc');
                    // ->buttons(
                    //     Button::make('excel')
                    //         ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                    //     Button::make('print')
                    //         ->text('<i class="bi bi-printer-fill"></i> Print'),
                    //     Button::make('reset')
                    //         ->text('<i class="bi bi-x-circle"></i> Reset'),
                    //     Button::make('reload')
                    //         ->text('<i class="bi bi-arrow-repeat"></i> Reload')
                    // );
    }

    protected function getColumns()
    {
        return [
            Column::make('row_number')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(35)
                ->orderable(false)
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::make('package_code')
                ->title('Code')
                ->className('text-center align-middle'),

            Column::make('package_name')
                ->title('Package Name')
                ->className('text-center align-middle'),

            Column::make('package_departure')
                ->title('Departure')
                ->className('text-center align-middle'),

            Column::computed('package_days')
                ->title('Days')
                ->className('text-center align-middle'),

                Column::computed('package_capacity')
                ->title('Seat')
                ->className('text-center align-middle'),

            Column::computed('package_booked')
                ->title('Booked')
                ->className('text-center align-middle'),

            Column::computed('package_available')
                ->title('Available')
                ->className('text-center align-middle')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'UmrohPackage_' . date('YmdHis');
    }
}
