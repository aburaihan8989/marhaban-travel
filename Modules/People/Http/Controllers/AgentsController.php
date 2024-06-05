<?php

namespace Modules\People\Http\Controllers;

use Modules\People\DataTables\AgentsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Agent;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload;

class AgentsController extends Controller
{

    public function index(AgentsDataTable $dataTable) {
        // abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::agents.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_customers'), 403);

        return view('people::agents.create');
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('create_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'agent_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'agent_phone' => 'required|max:255',
            // 'agent_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $agent = Agent::create([
            'nik_number'     => $request->nik_number,
            'agent_name'     => $request->agent_name,
            'date_birth'     => $request->date_birth,
            'agent_phone'    => $request->agent_phone,
            'agent_email'    => $request->agent_email,
            'gender'         => $request->gender,
            'referal_id'     => $request->referal_id,
            'level_agent'    => $request->level_agent,
            'agent_status'   => $request->agent_status,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            foreach ($request->input('document') as $file) {
                $agent->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('agents');
            }
        }

        toast('Agent Created!', 'success');

        return redirect()->route('agents.index');
    }


    public function show(Agent $agent) {
        // abort_if(Gate::denies('show_customers'), 403);
        $referal_agent = Agent::findOrFail($agent->referal_id);

        return view('people::agents.show', compact('agent', 'referal_agent'));
    }


    public function edit(Agent $agent) {
        // abort_if(Gate::denies('edit_customers'), 403);
        $referal_agent = Agent::findOrFail($agent->referal_id);

        return view('people::agents.edit', compact('agent', 'referal_agent'));
    }


    public function update(Request $request, Agent $agent) {
        // abort_if(Gate::denies('update_customers'), 403);

        $request->validate([
            // 'nik_number'     => 'required|max:255',
            // 'agent_name'  => 'required|string|max:255',
            // // 'date_birth'     => 'required',
            // 'agent_phone' => 'required|max:255',
            // 'agent_status'=> 'required|string',
            // 'gender'         => 'required|string',
            // 'city'           => 'required|string|max:255',
            // 'country'        => 'required|string|max:255',
            // 'address'        => 'required|string|max:500',
        ]);

        $agent->update([
            'nik_number'     => $request->nik_number,
            'agent_name'     => $request->agent_name,
            'date_birth'     => $request->date_birth,
            'agent_phone'    => $request->agent_phone,
            'agent_email'    => $request->agent_email,
            'gender'         => $request->gender,
            'level_agent'    => $request->level_agent,
            'referal_id'     => $request->referal_id,
            'agent_status'   => $request->agent_status,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            if (count($agent->getMedia('agents')) > 0) {
                foreach ($agent->getMedia('agents') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $agent->getMedia('agents')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $agent->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('agents');
                }
            }
        }

        toast('Agent Updated!', 'info');

        return redirect()->route('agents.index');
    }


    public function destroy(Agent $agent) {
        // abort_if(Gate::denies('delete_customers'), 403);

        $agent->delete();

        toast('Agent Deleted!', 'warning');

        return redirect()->route('agents.index');
    }
}
