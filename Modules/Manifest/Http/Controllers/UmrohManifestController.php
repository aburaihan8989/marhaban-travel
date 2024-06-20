<?php

namespace Modules\Manifest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Package\Entities\UmrohPackage;
use Modules\Manifest\Entities\UmrohManifest;
use Modules\Manifest\Entities\UmrohManifestPayment;
use Modules\Manifest\DataTables\UmrohManifestDataTable;
use Modules\Manifest\DataTables\UmrohManifestCustomerDataTable;
use Modules\Manifest\DataTables\UmrohManifestCustomerDetailDataTable;

class UmrohManifestController extends Controller
{

    public function index(UmrohManifestDataTable $dataTable) {
        // abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('manifest::umroh.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_purchases'), 403);

        return view('manifest::umroh.create');
    }

    public function store(Request $request) {
        DB::transaction(function () use ($request) {
            // $total_payment = $request->last_amount;
            // $remaining_payment = $request->total_price - $total_payment;

            // if ($total_payment >= $request->total_price) {
            //     $status = 'Completed';
            // } else {
            //     $status = 'Process';
            // }

            $umroh_manifest = UmrohManifest::create([
                'register_date' => now()->format('Y-m-d'),
                'package_id' => $request->package_id,
                'package_code' => UmrohPackage::findOrFail($request->package_id)->package_code,
                'package_name' => UmrohPackage::findOrFail($request->package_id)->package_name,
                'package_date' => UmrohPackage::findOrFail($request->package_id)->package_date,
                'package_departure' => UmrohPackage::findOrFail($request->package_id)->package_departure,
                'flight_route' => UmrohPackage::findOrFail($request->package_id)->flight_route,
                'package_days' => UmrohPackage::findOrFail($request->package_id)->package_days,
                // 'customer_id' => $request->customer_id,
                // 'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                // // 'paspor_number' => Customer::findOrFail($request->customer_id)->paspor_number,
                'status' => $request->status,
                // 'customer_bank' => $request->customer_bank,
                // 'bank_account' => $request->bank_account,
                // 'total_price' => $request->total_price,
                // 'total_payment' => $total_payment,
                // 'remaining_payment' => $remaining_payment,
                // 'last_date' => now()->format('Y-m-d'),
                // 'last_amount' => $request->last_amount,
                // 'payment_method' => $request->payment_method,
                'note' => $request->note
            ]);

            // if ($umroh_manifest->last_amount > 0) {
            //     UmrohManifestPayment::create([
            //         'date' => now()->format('Y-m-d'),
            //         'reference' => 'INV/'.$umroh_manifest->reference,
            //         'amount' => $request->last_amount,
            //         'umroh_manifest_id' => $umroh_manifest->id,
            //         'payment_method' => $request->payment_method
            //     ]);
            // }
        });

        toast('Umroh Manifest Created!', 'success');

        return redirect()->route('umroh-manifests.index');
    }


    public function show(UmrohManifestCustomerDetailDataTable $dataTable, $manifest_id) {
        // abort_if(Gate::denies('show_purchases'), 403);

        $umroh_manifest = UmrohManifest::findOrFail($manifest_id);
        return $dataTable->render('manifest::umroh.show', compact('umroh_manifest'));

        // return view('manifest::umroh.show', compact('umroh_manifest'));
    }

    public function manage(UmrohManifestCustomerDataTable $dataTable, $manifest_id) {
        // abort_if(Gate::denies('show_purchases'), 403);

        $umroh_manifest = UmrohManifest::findOrFail($manifest_id);
        return $dataTable->render('manifest::umroh.manage', compact('umroh_manifest'));

        // return view('manifest::umroh.manage', compact('umroh_manifest'));
    }


    public function edit(UmrohManifest $umroh_manifest) {
        // abort_if(Gate::denies('edit_purchases'), 403);

        return view('manifest::umroh.edit', compact('umroh_manifest'));
    }


    public function update(Request $request, UmrohManifest $umroh_manifest) {

        $request->validate([
            // 'total_price' => 'required|numeric',
            // 'total_payment' => 'required|numeric',
            // 'remaining_payment' => 'required|numeric',
            'note' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $umroh_manifest) {
            // $total_payment = $request->total_payment + $request->last_amount;
            // $remaining_payment = $request->total_price - $request->total_payment;

            // if ($request->total_payment >= $request->total_price) {
            //     $status = 'Completed';
            // } else {
            //     $status = 'Process';
            // }

            $umroh_manifest->update([
                // 'register_date' => $request->register_date,
                'package_id' => $request->package_id,
                'package_code' => UmrohPackage::findOrFail($request->package_id)->package_code,
                'package_name' => UmrohPackage::findOrFail($request->package_id)->package_name,
                'package_date' => UmrohPackage::findOrFail($request->package_id)->package_date,
                'package_departure' => UmrohPackage::findOrFail($request->package_id)->package_departure,
                'flight_route' => UmrohPackage::findOrFail($request->package_id)->flight_route,
                'package_days' => UmrohPackage::findOrFail($request->package_id)->package_days,
                // 'customer_id' => $request->customer_id,
                // 'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'customer_phone' => Customer::findOrFail($request->customer_id)->customer_phone,
                // 'paspor_number' => Customer::findOrFail($request->customer_id)->paspor_number,
                'status' => $request->status,
                // 'total_price' => $request->total_price,
                // 'total_payment' => $request->total_payment,
                // 'remaining_payment' => $remaining_payment,
                'note' => $request->note
            ]);

        });

        toast('Umroh Manifest Updated!', 'info');

        return redirect()->route('umroh-manifests.index');
    }


    public function destroy(UmrohManifest $umroh_manifest) {
        // abort_if(Gate::denies('delete_purchases'), 403);

        $umroh_manifest->delete();

        toast('Umroh Manifest Deleted!', 'warning');

        return redirect()->route('umroh-manifests.index');
    }
}
