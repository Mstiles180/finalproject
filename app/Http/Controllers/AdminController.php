<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\JobOffer;
use App\Models\PickupPoint;
use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $activeJobs = Job::where('status', 'active')->count();
        $completedJobs = Job::where('status', 'completed')->count();
        $activeWorkers = User::where('role', 'worker')->where('is_available', true)->count();
        $bosses = User::where('role', 'boss')->count();

        return view('admin.dashboard', compact('activeJobs', 'completedJobs', 'activeWorkers', 'bosses'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($search = $request->get('q')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function updateUserPhotos(Request $request, User $user)
    {
        $data = $request->validate([
            'nid_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'experience_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        $updates = [];
        if ($request->hasFile('nid_image')) {
            $path = $request->file('nid_image')->store('worker_docs', 'public');
            $updates['nid_image_url'] = Storage::url($path);
        }
        if ($request->hasFile('experience_image')) {
            $path = $request->file('experience_image')->store('worker_docs', 'public');
            $updates['experience_image_url'] = Storage::url($path);
        }

        if (!empty($updates)) {
            $user->update($updates);
        }

        return back()->with('success', 'Worker photos updated.');
    }

    public function toggleSuspend(User $user)
    {
        $user->update(['is_suspended' => !($user->is_suspended ?? false)]);
        return back()->with('success', 'User status updated.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123';
        $user->update(['password' => bcrypt($newPassword)]);
        return back()->with('success', 'Password reset to "'.$newPassword.'". Advise user to change it.');
    }

    public function exportUsers(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        $callback = function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Phone', 'Location', 'Available', 'Suspended']);
            User::chunk(500, function($chunk) use ($handle) {
                foreach ($chunk as $u) {
                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->role,
                        $u->phone,
                        $u->location,
                        $u->is_available ? 'yes' : 'no',
                        ($u->is_suspended ?? false) ? 'yes' : 'no',
                    ]);
                }
            });
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // User verification
    public function verifications(Request $request)
    {
        $query = User::where('role','worker')->whereNotNull('document_url');
        if (($status = $request->get('status')) !== null && in_array($status, ['0','1'])) {
            $query->where('is_verified', (bool) $status);
        }
        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.verifications', compact('users'));
    }

    public function setVerification(User $user, Request $request)
    {
        $request->validate(['verified' => ['required','boolean']]);
        $user->update(['is_verified' => (bool) $request->boolean('verified')]);
        return back()->with('success', 'Verification status updated.');
    }

    // Reports moderation
    public function reports(Request $request)
    {
        $query = \DB::table('reports')
            ->leftJoin('users as reporters', 'reporters.id', '=', 'reports.reporter_id')
            ->leftJoin('users as subjects', function($join){
                $join->on('subjects.id', '=', 'reports.reportable_id')
                     ->where('reports.reportable_type', User::class);
            })
            ->select('reports.*', 'reporters.name as reporter_name', 'subjects.name as subject_name');
        if ($status = $request->get('status')) {
            $query->where('reports.status', $status);
        }
        $reports = $query->orderByDesc('reports.id')->paginate(20)->withQueryString();
        return view('admin.reports', compact('reports'));
    }

    public function updateReportStatus(Request $request, int $reportId)
    {
        $request->validate(['status' => ['required','in:open,resolved,rejected']]);
        \DB::table('reports')->where('id', $reportId)->update(['status' => $request->status]);
        return back()->with('success', 'Report updated.');
    }

    // Categories & Skills
    public function categories()
    {
        $categories = \DB::table('job_categories')->orderBy('name')->paginate(20);
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate(['name' => ['required','string','max:255','unique:job_categories,name']]);
        \DB::table('job_categories')->insert(['name' => $data['name'], 'created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'Category added.');
    }

    public function deleteCategory(int $id)
    {
        \DB::table('job_categories')->where('id', $id)->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function skills()
    {
        $skills = \DB::table('skills')->orderBy('name')->paginate(20);
        return view('admin.skills', compact('skills'));
    }

    public function storeSkill(Request $request)
    {
        $data = $request->validate(['name' => ['required','string','max:255','unique:skills,name']]);
        \DB::table('skills')->insert(['name' => $data['name'], 'created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'Skill added.');
    }

    public function deleteSkill(int $id)
    {
        \DB::table('skills')->where('id', $id)->delete();
        return back()->with('success', 'Skill deleted.');
    }

    public function jobs(Request $request)
    {
        $query = Job::query()->with('user');
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('q')) {
            $query->where('title', 'like', "%{$search}%");
        }
        $jobs = $query->latest()->paginate(20)->withQueryString();
        return view('admin.jobs', compact('jobs'));
    }

    public function forceCloseJob(Job $job)
    {
        $job->update(['status' => 'completed', 'end_date' => now()->toDateString()]);
        // mark related offers as completed if accepted
        JobOffer::where('job_id', $job->id)
            ->where('status', 'accepted')
            ->update(['status' => 'completed', 'completed_at' => now()]);
        return back()->with('success', 'Job forcefully closed.');
    }

    public function deleteJob(Job $job)
    {
        $job->delete();
        return back()->with('success', 'Job deleted.');
    }

    public function exportJobs(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="jobs.csv"',
        ];
        $callback = function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID','Title','Employer','Status','Start','End']);
            Job::with('user')->chunk(500, function($chunk) use ($handle) {
                foreach ($chunk as $j) {
                    fputcsv($handle, [$j->id, $j->title ?? '', optional($j->user)->email, $j->status, $j->start_date, $j->end_date]);
                }
            });
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function offers(Request $request)
    {
        $query = JobOffer::with(['job','worker']);
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        $offers = $query->latest()->paginate(20)->withQueryString();
        return view('admin.offers', compact('offers'));
    }

    public function reassignOffer(Request $request, JobOffer $jobOffer)
    {
        $request->validate(['worker_id' => ['required','exists:users,id']]);
        $worker = User::findOrFail($request->worker_id);
        if (!$worker->isWorker()) {
            return back()->with('error', 'Selected user is not a worker.');
        }
        $jobOffer->update(['worker_id' => $worker->id, 'status' => 'pending']);
        return back()->with('success', 'Offer reassigned.');
    }

    public function exportOffers(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="offers.csv"',
        ];
        $callback = function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID','Job','Worker','Status','Created']);
            JobOffer::with(['job','worker'])->chunk(500, function($chunk) use ($handle) {
                foreach ($chunk as $o) {
                    fputcsv($handle, [$o->id, optional($o->job)->title, optional($o->worker)->email, $o->status, $o->created_at]);
                }
            });
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function applications(Request $request)
    {
        $query = Application::with(['job','user']);
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        $applications = $query->latest()->paginate(20)->withQueryString();
        return view('admin.applications', compact('applications'));
    }

    public function exportApplications(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="applications.csv"',
        ];
        $callback = function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID','Job','Applicant','Status','Created']);
            Application::with(['job','user'])->chunk(500, function($chunk) use ($handle) {
                foreach ($chunk as $a) {
                    fputcsv($handle, [$a->id, optional($a->job)->title, optional($a->user)->email, $a->status, $a->created_at]);
                }
            });
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function pickupPoints()
    {
        $pickupPoints = PickupPoint::latest()->paginate(20);
        return view('admin.pickup-points', compact('pickupPoints'));
    }

    public function storePickupPoint(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'location_description' => ['nullable','string','max:1000'],
            'village_id' => ['required','exists:villages,id'],
        ]);
        PickupPoint::create($data);
        return back()->with('success', 'Pickup point created.');
    }

    public function deletePickupPoint(PickupPoint $pickupPoint)
    {
        $pickupPoint->delete();
        return back()->with('success', 'Pickup point deleted.');
    }

    // Administrative data CRUD
    public function provinces()
    {
        $provinces = Province::latest()->paginate(20);
        return view('admin.provinces', compact('provinces'));
    }

    public function storeProvince(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:10','unique:provinces,code'],
        ]);
        Province::create($data);
        return back()->with('success', 'Province created.');
    }

    public function deleteProvince(Province $province)
    {
        $province->delete();
        return back()->with('success', 'Province deleted.');
    }

    public function districts()
    {
        $districts = District::with('province')->latest()->paginate(20);
        $provinces = Province::all();
        return view('admin.districts', compact('districts','provinces'));
    }

    public function storeDistrict(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:10','unique:districts,code'],
            'province_id' => ['required','exists:provinces,id'],
        ]);
        District::create($data);
        return back()->with('success', 'District created.');
    }

    public function deleteDistrict(District $district)
    {
        $district->delete();
        return back()->with('success', 'District deleted.');
    }

    public function sectors()
    {
        $sectors = Sector::with('district')->latest()->paginate(20);
        $districts = District::all();
        return view('admin.sectors', compact('sectors','districts'));
    }

    public function storeSector(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'district_id' => ['required','exists:districts,id'],
        ]);
        Sector::create($data);
        return back()->with('success', 'Sector created.');
    }

    public function deleteSector(Sector $sector)
    {
        $sector->delete();
        return back()->with('success', 'Sector deleted.');
    }

    public function cells()
    {
        $cells = Cell::with('sector')->latest()->paginate(20);
        $sectors = Sector::all();
        return view('admin.cells', compact('cells','sectors'));
    }

    public function storeCell(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'sector_id' => ['required','exists:sectors,id'],
        ]);
        Cell::create($data);
        return back()->with('success', 'Cell created.');
    }

    public function deleteCell(Cell $cell)
    {
        $cell->delete();
        return back()->with('success', 'Cell deleted.');
    }

    public function villages()
    {
        $villages = Village::with('cell')->latest()->paginate(20);
        $cells = Cell::all();
        return view('admin.villages', compact('villages','cells'));
    }

    public function storeVillage(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'cell_id' => ['required','exists:cells,id'],
        ]);
        Village::create($data);
        return back()->with('success', 'Village created.');
    }

    public function deleteVillage(Village $village)
    {
        $village->delete();
        return back()->with('success', 'Village deleted.');
    }

    // Administrative data exports
    public function exportProvinces(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv','Content-Disposition' => 'attachment; filename="provinces.csv"'];
        $callback = function() {
            $h = fopen('php://output','w');
            fputcsv($h, ['ID','Name','Code']);
            Province::chunk(500, function($chunk) use ($h) { foreach ($chunk as $p) { fputcsv($h, [$p->id,$p->name,$p->code]); } });
            fclose($h);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportDistricts(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv','Content-Disposition' => 'attachment; filename="districts.csv"'];
        $callback = function() {
            $h = fopen('php://output','w');
            fputcsv($h, ['ID','Name','Code','Province']);
            District::with('province')->chunk(500, function($chunk) use ($h) { foreach ($chunk as $d) { fputcsv($h, [$d->id,$d->name,$d->code, optional($d->province)->name]); } });
            fclose($h);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportSectors(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv','Content-Disposition' => 'attachment; filename="sectors.csv"'];
        $callback = function() {
            $h = fopen('php://output','w');
            fputcsv($h, ['ID','Name','District']);
            Sector::with('district')->chunk(500, function($chunk) use ($h) { foreach ($chunk as $s) { fputcsv($h, [$s->id,$s->name, optional($s->district)->name]); } });
            fclose($h);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportCells(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv','Content-Disposition' => 'attachment; filename="cells.csv"'];
        $callback = function() {
            $h = fopen('php://output','w');
            fputcsv($h, ['ID','Name','Sector']);
            Cell::with('sector')->chunk(500, function($chunk) use ($h) { foreach ($chunk as $c) { fputcsv($h, [$c->id,$c->name, optional($c->sector)->name]); } });
            fclose($h);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportVillages(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv','Content-Disposition' => 'attachment; filename="villages.csv"'];
        $callback = function() {
            $h = fopen('php://output','w');
            fputcsv($h, ['ID','Name','Cell']);
            Village::with('cell')->chunk(500, function($chunk) use ($h) { foreach ($chunk as $v) { fputcsv($h, [$v->id,$v->name, optional($v->cell)->name]); } });
            fclose($h);
        };
        return response()->stream($callback, 200, $headers);
    }
}


