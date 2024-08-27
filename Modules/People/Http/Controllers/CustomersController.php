<?php

namespace Modules\People\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Upload\Entities\Upload;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Modules\People\Entities\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\People\DataTables\CustomersDataTable;

class CustomersController extends Controller
{

    public function index(CustomersDataTable $dataTable) {
        abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::customers.index');
    }


    public function create() {
        abort_if(Gate::denies('create_customers'), 403);

        return view('people::customers.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'customer_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'customer_phone' => 'required|max:255',
            // 'paspor_number'  => 'required|max:255',
            // // 'paspor_date'    => 'required',
            // // 'customer_email' => 'required|email|max:255',
            // 'customer_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'age_group'      => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $customer = Customer::create([
            'nik_number'     => $request->nik_number,
            'customer_name'  => $request->customer_name,
            'date_birth'     => $request->date_birth,
            'place_birth'    => $request->place_birth,
            'customer_phone' => $request->customer_phone,
            'paspor_number'  => $request->paspor_number,
            'paspor_active'  => $request->paspor_active,
            'paspor_date'    => $request->paspor_date,
            'paspor_issued'  => $request->paspor_issued,
            'customer_email' => $request->customer_email,
            'customer_status'=> $request->customer_status,
            'gender'         => $request->gender,
            'age_group'      => $request->age_group,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            foreach ($request->input('document') as $file) {
                $customer->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('photos');
            }
        }

        toast('Customer Created!', 'success');

        return redirect()->route('customers.index');
    }


    public function show(Customer $customer) {
        abort_if(Gate::denies('show_customers'), 403);

        return view('people::customers.show', compact('customer'));
    }


    public function edit(Customer $customer) {
        abort_if(Gate::denies('edit_customers'), 403);

        return view('people::customers.edit', compact('customer'));
    }


    public function update(Request $request, Customer $customer) {
        abort_if(Gate::denies('update_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'customer_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'customer_phone' => 'required|max:255',
            // 'paspor_number'  => 'required|max:255',
            // // 'paspor_date'    => 'required',
            // // 'customer_email' => 'required|email|max:255',
            // 'customer_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'age_group'      => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $customer->update([
            'nik_number'     => $request->nik_number,
            'customer_name'  => $request->customer_name,
            'date_birth'     => $request->date_birth,
            'place_birth'    => $request->place_birth,
            'customer_phone' => $request->customer_phone,
            'paspor_number'  => $request->paspor_number,
            'paspor_active'  => $request->paspor_active,
            'paspor_date'    => $request->paspor_date,
            'paspor_issued'  => $request->paspor_issued,
            'customer_email' => $request->customer_email,
            'customer_status'=> $request->customer_status,
            'gender'         => $request->gender,
            'age_group'      => $request->age_group,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            if (count($customer->getMedia('photos')) > 0) {
                foreach ($customer->getMedia('photos') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $customer->getMedia('photos')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $customer->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('photos');
                }
            }
        }

        toast('Customer Updated!', 'info');

        return redirect()->route('customers.index');
    }


    public function destroy(Customer $customer) {
        abort_if(Gate::denies('delete_customers'), 403);

        $customer->delete();

        toast('Customer Deleted!', 'warning');

        return redirect()->route('customers.index');
    }


    public function getCustomerPotential() {
        // abort_if(Gate::denies('show_customers'), 403);
        $data = DB::table('umroh_manifest_customers')
                // ->where('agent_id', $agent_id)
                ->where('mark', 1)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.id',
                         'umroh_manifest_customers.reference',
                         'umroh_manifest_customers.agent_reward',
                         'umroh_manifest_customers.promo',
                         'umroh_manifest_customers.rating',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->get();

        // return $data;
        return view('people::potential.data', compact('data'));
    }


    public function editCustomerPotential($customer_id) {
        // abort_if(Gate::denies('show_customers'), 403);
        // $data = UmrohManifestCustomer::findOrFail($customer_id);
        $customer = DB::table('umroh_manifest_customers')
                ->where('umroh_manifest_customers.id', $customer_id)
                ->join('customers', 'customer_id', '=','customers.id')
                ->join('agents', 'agent_id', '=','agents.id')
                ->join('umroh_packages', 'package_id', '=','umroh_packages.id')
                ->select('umroh_manifest_customers.id',
                         'umroh_manifest_customers.reference',
                         'umroh_manifest_customers.rating',
                         'umroh_manifest_customers.fu_notes',
                         'customers.customer_name',
                         'customers.customer_phone',
                         'customers.city',
                         'agents.agent_code',
                         'agents.agent_name',
                         'agents.agent_phone',
                         'umroh_packages.package_name'
                         )
                ->first();

        // return $data;
        return view('people::potential.edit', compact('customer'));
    }


    public function updateCustomerPotential($customer_id, Request $request) {
        // abort_if(Gate::denies('update_customers'), 403);
        // @dd($request);
        $data = DB::table('umroh_manifest_customers')
                ->where('id', $customer_id)
                ->update(['rating' => $request->rating, 'fu_notes' => $request->fu_notes]);

        toast('Potential Customer Updated!', 'info');

        return redirect()->route('customers-potential.data');
    }


    public function getCustomerProspek() {
        // abort_if(Gate::denies('access_customers'), 403);
        $getdata = Http::get(settings()->api_url . 'api/customer-prospek');
        $data = $getdata->json();

        return view('people::prospek.data', compact('data'));
    }


    public function editCustomerProspek($customer_id) {
        // abort_if(Gate::denies('edit_customers'), 403);

        $getdata = Http::get(settings()->api_url . 'api/customer-prospek/' . $customer_id);
        $customer = $getdata->json();

        return view('people::prospek.edit', compact('customer'));
    }


    public function updateCustomerProspek($customer_id, Request $request) {
        // abort_if(Gate::denies('update_customers'), 403);
        // $customer_poin = $request->rating;
        // $notes = $request->fu_notes;

        // $postdata = Http::post(settings()->api_url . 'api/poin-customers/' . $customer_id . '/' . $customer_poin . '/' . $notes);
        $postdata = Http::post(settings()->api_url . 'api/customer-prospek/' . $customer_id, $request->input());

        // @dd($postdata);
        toast('Prospek Customer Updated!', 'info');

        return redirect()->route('customers-prospek.data');
    }


}
