<?php

namespace Modules\Package\DataTables;

use Modules\Package\Entities\Hotel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HotelDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            // ->eloquent($query)->with('category')
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('package::hotels.partials.actions', compact('data'));
            })
            ->addColumn('hotel_image', function ($data) {
                $url = $data->getFirstMediaUrl('hotels', 'thumb');
                return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            })
            ->addColumn('hotel_price', function ($data) {
                return format_currency($data->hotel_price);
            })
            ->rawColumns(['hotel_image']);
    }

    public function query(Hotel $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('hotels-table')
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

    protected function getColumns()
    {
        return [
            Column::make('row_number')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false)
                ->searchable(false)
                ->className('text-center align-middle'),

            Column::computed('hotel_image')
                ->title('Hotel Image')
                ->className('text-center align-middle'),

            Column::make('hotel_name')
                ->className('text-center align-middle'),

            Column::make('hotel_location')
                ->className('text-center align-middle'),

            Column::make('hotel_type')
                ->className('text-center align-middle'),

            Column::computed('hotel_price')
                ->title('Hotel Price')
                ->className('text-center align-middle'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Hotel_' . date('YmdHis');
    }
}
