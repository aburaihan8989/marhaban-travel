<?php

namespace Modules\Package\Http\Controllers;

use Modules\Package\DataTables\UmrohPackageDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Package\Entities\UmrohPackage;
use Modules\Package\Http\Requests\StoreUmrohPackageRequest;
use Modules\Package\Http\Requests\UpdateUmrohPackageRequest;
use Modules\Upload\Entities\Upload;

class UmrohPackageController extends Controller
{

    public function index(UmrohPackageDataTable $dataTable) {
        // abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('package::umroh.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_products'), 403);

        return view('package::umroh.create');
    }


    public function store(Request $request) {
        $umroh_package = UmrohPackage::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $umroh_package->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('brosurs');
            }
        }

        toast('Umroh Package Created!', 'success');

        return redirect()->route('umroh-packages.index');
    }


    public function show(UmrohPackage $umroh_package) {
        // abort_if(Gate::denies('show_products'), 403);

        return view('package::umroh.show', compact('umroh_package'));
    }


    public function edit(UmrohPackage $umroh_package) {
        // abort_if(Gate::denies('edit_products'), 403);

        return view('package::umroh.edit', compact('umroh_package'));
    }


    public function update(Request $request, UmrohPackage $umroh_package) {
        $umroh_package->update($request->except('document'));

        if ($request->has('document')) {
            if (count($umroh_package->getMedia('brosurs')) > 0) {
                foreach ($umroh_package->getMedia('brosurs') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $umroh_package->getMedia('brosurs')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $umroh_package->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('brosurs');
                }
            }
        }

        toast('Umroh Package Updated!', 'info');

        return redirect()->route('umroh-packages.index');
    }


    public function destroy(UmrohPackage $umroh_package) {
        // abort_if(Gate::denies('delete_products'), 403);

        $umroh_package->delete();

        toast('Umroh Package Deleted!', 'warning');

        return redirect()->route('umroh-packages.index');
    }
}
