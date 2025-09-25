@extends('layouts.admin')

@section('title', 'Pickup Points')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="mb-3">Pickup Points</h2>
        <form class="row g-2" method="post" action="{{ route('admin.pickup-points.store') }}">
            @csrf
            <div class="col-md-3">
                <input class="form-control" name="name" placeholder="Name" required>
            </div>
            <div class="col-md-3">
                <input class="form-control" name="location_description" placeholder="Description">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="ap_province" required>
                    <option value="">Province</option>
                    @foreach(\App\Models\Province::all() as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="ap_district" required>
                    <option value="">District</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="ap_sector" required>
                    <option value="">Sector</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="ap_cell" required>
                    <option value="">Cell</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="ap_village" name="village_id" required>
                    <option value="">Village</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Village</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pickupPoints as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->location_description }}</td>
                    <td>{{ optional($p->village)->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.pickup-points.delete', $p) }}" onsubmit="return confirm('Delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $pickupPoints->links() }}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const ap_province = document.getElementById('ap_province');
    const ap_district = document.getElementById('ap_district');
    const ap_sector = document.getElementById('ap_sector');
    const ap_cell = document.getElementById('ap_cell');
    const ap_village = document.getElementById('ap_village');

    function reset(sel, ph){ sel.innerHTML = `<option value="">${ph}</option>`; }
    function add(sel, rows){ rows.forEach(r=>{ const o=document.createElement('option'); o.value=r.id; o.textContent=r.name; sel.appendChild(o); }); }
    async function load(url){ const r=await fetch(url); return r.json(); }

    ap_province.addEventListener('change', async ()=>{
        reset(ap_district,'District'); reset(ap_sector,'Sector'); reset(ap_cell,'Cell'); reset(ap_village,'Village');
        if(!ap_province.value) return; const d=await load(`/api/districts/${ap_province.value}`); add(ap_district, d.districts||[]);
    });
    ap_district.addEventListener('change', async ()=>{
        reset(ap_sector,'Sector'); reset(ap_cell,'Cell'); reset(ap_village,'Village');
        if(!ap_district.value) return; const s=await load(`/api/sectors/${ap_district.value}`); add(ap_sector, s.sectors||[]);
    });
    ap_sector.addEventListener('change', async ()=>{
        reset(ap_cell,'Cell'); reset(ap_village,'Village');
        if(!ap_sector.value) return; const c=await load(`/api/cells/${ap_sector.value}`); add(ap_cell, c.cells||[]);
    });
    ap_cell.addEventListener('change', async ()=>{
        reset(ap_village,'Village');
        if(!ap_cell.value) return; const v=await load(`/api/villages/${ap_cell.value}`); add(ap_village, v.villages||[]);
    });
});
</script>
@endpush


