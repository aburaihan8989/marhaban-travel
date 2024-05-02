<?php

namespace Modules\Package\Http\Controllers;

use Modules\Package\DataTables\AirlineDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Package\Entities\Airline;
// use Modules\Package\Http\Requests\StoreHajjPackageRequest;
// use Modules\Package\Http\Requests\UpdateHajjPackageRequest;
use Modules\Upload\Entities\Upload;

class AirlineController extends Controller
{

    public function index(AirlineDataTable $dataTable) {
        // abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('package::airlines.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_products'), 403);

        return view('package::airlines.create');
    }


    public function store(Request $request) {
        $airline = Airline::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $airline->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('airlines');
            }
        }

        toast('Airline Created!', 'success');

        return redirect()->route('airlines.index');
    }


    public function show(Airline $airline) {
        // abort_if(Gate::denies('show_products'), 403);

        return view('package::airlines.show', compact('airline'));
    }


    public function edit(Airline $airline) {
        // abort_if(Gate::denies('edit_products'), 403);

        return view('package::airlines.edit', compact('airline'));
    }


    public function update(Request $request, Airline $airline) {
        $airline->update($request->except('document'));

        if ($request->has('document')) {
            if (count($airline->getMedia('airlines')) > 0) {
                foreach ($airline->getMedia('airlines') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $airline->getMedia('airlines')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $airline->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('airlines');
                }
            }
        }

        toast('Airline Updated!', 'info');

        return redirect()->route('airlines.index');
    }


    public function destroy(Airline $airline) {
        // abort_if(Gate::denies('delete_products'), 403);

        $airline->delete();

        toast('Airline Deleted!', 'warning');

        return redirect()->route('airlines.index');
    }
}
