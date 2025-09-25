<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        $this->middleware('auth');

        $data = $request->validate([
            'worker_id' => ['required','exists:users,id'],
            'reason' => ['required','string','max:255'],
            'details' => ['nullable','string','max:2000'],
        ]);

        $worker = User::findOrFail($data['worker_id']);
        if (!$worker->isWorker()) {
            return back()->with('error', 'You can only report workers.');
        }

        \DB::table('reports')->insert([
            'reporter_id' => auth()->id(),
            'reportable_type' => User::class,
            'reportable_id' => $worker->id,
            'reason' => $data['reason'],
            'details' => $data['details'] ?? null,
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Report submitted. Admin will review and take action.');
    }
}


