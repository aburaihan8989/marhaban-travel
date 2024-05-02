<?php

namespace Modules\Package\Http\Controllers;

use Modules\Package\DataTables\HotelDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Package\Entities\Hotel;
// use Modules\Package\Http\Requests\StoreHajjPackageRequest;
// use Modules\Package\Http\Requests\UpdateHajjPackageRequest;
use Modules\Upload\Entities\Upload;

class HotelController extends Controller
{

    public function index(HotelDataTable $dataTable) {
        // abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('package::hotels.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_products'), 403);

        return view('package::hotels.create');
    }


    public function store(Request $request) {
        $hotel = Hotel::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $hotel->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('hotels');
            }
        }

        toast('Hotel Created!', 'success');

        return redirect()->route('hotels.index');
    }


    public function show(Hotel $hotel) {
        // abort_if(Gate::denies('show_products'), 403);

        return view('package::hotels.show', compact('hotel'));
    }


    public function edit(Hotel $hotel) {
        // abort_if(Gate::denies('edit_products'), 403);

        return view('package::hotels.edit', compact('hotel'));
    }


    public function update(Request $request, Hotel $hotel) {
        $hotel->update($request->except('document'));

        if ($request->has('document')) {
            if (count($hotel->getMedia('hotels')) > 0) {
                foreach ($hotel->getMedia('hotels') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $hotel->getMedia('hotels')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $hotel->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('hotels');
                }
            }
        }

        toast('Hotel Updated!', 'info');

        return redirect()->route('hotels.index');
    }


    public function destroy(Hotel $hotel) {
        // abort_if(Gate::denies('delete_products'), 403);

        $hotel->delete();

        toast('Hotel Deleted!', 'warning');

        return redirect()->route('hotels.index');
    }
}
