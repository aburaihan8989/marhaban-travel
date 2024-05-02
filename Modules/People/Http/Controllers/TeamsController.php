<?php

namespace Modules\People\Http\Controllers;

use Modules\People\DataTables\TeamsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Team;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload;

class TeamsController extends Controller
{

    public function index(TeamsDataTable $dataTable) {
        // abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::teams.index');
    }


    public function create() {
        // abort_if(Gate::denies('create_customers'), 403);

        return view('people::teams.create');
    }


    public function store(Request $request) {
        // abort_if(Gate::denies('create_customers'), 403);

        $request->validate([
            'nik_number'     => 'required|max:255',
            'team_name'      => 'required|string|max:255',
            // 'date_birth'     => 'required',
            'team_phone'     => 'required|max:255',
            'team_status'    => 'required|string',
            'division'       => 'required|string',
            'gender'         => 'required|string',
            'city'           => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'address'        => 'required|string|max:500',
        ]);

        $team = Team::create([
            'nik_number'     => $request->nik_number,
            'team_name'      => $request->team_name,
            'date_birth'     => $request->date_birth,
            'team_phone'     => $request->team_phone,
            'team_email'     => $request->team_email,
            'gender'         => $request->gender,
            'team_status'    => $request->team_status,
            'division'       => $request->division,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            foreach ($request->input('document') as $file) {
                $team->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('teams');
            }
        }

        toast('Team Created!', 'success');

        return redirect()->route('teams.index');
    }


    public function show(Team $team) {
        // abort_if(Gate::denies('show_customers'), 403);

        return view('people::teams.show', compact('team'));
    }


    public function edit(Team $team) {
        // abort_if(Gate::denies('edit_customers'), 403);

        return view('people::teams.edit', compact('team'));
    }


    public function update(Request $request, Team $team) {
        // abort_if(Gate::denies('update_customers'), 403);

        $request->validate([
            'nik_number'     => 'required|max:255',
            'team_name'      => 'required|string|max:255',
            // 'date_birth'     => 'required',
            'team_phone'     => 'required|max:255',
            'team_status'    => 'required|string',
            'division'       => 'required|string',
            'gender'         => 'required|string',
            'city'           => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'address'        => 'required|string|max:500',
        ]);

        $team->update([
            'nik_number'     => $request->nik_number,
            'team_name'      => $request->team_name,
            'date_birth'     => $request->date_birth,
            'team_phone'     => $request->team_phone,
            'team_email'     => $request->team_email,
            'gender'         => $request->gender,
            'team_status'    => $request->team_status,
            'division'       => $request->division,
            'city'           => $request->city,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        if ($request->has('document')) {
            if (count($team->getMedia('teams')) > 0) {
                foreach ($team->getMedia('teams') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $team->getMedia('teams')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $team->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('teams');
                }
            }
        }

        toast('Team Updated!', 'info');

        return redirect()->route('teams.index');
    }


    public function destroy(Team $team) {
        // abort_if(Gate::denies('delete_customers'), 403);

        $team->delete();

        toast('Team Deleted!', 'warning');

        return redirect()->route('teams.index');
    }
}
