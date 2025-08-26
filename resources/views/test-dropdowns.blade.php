@extends('layouts.app')

@section('title', 'Test Dropdowns')

@section('content')
<div class="container mt-4">
    <h1>Test Cascading Dropdowns</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="province_id" class="form-label">Province</label>
                <select class="form-select" id="province_id">
                    <option value="">Select Province</option>
                    @foreach(\App\Models\Province::all() as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="district_id" class="form-label">District</label>
                <select class="form-select" id="district_id">
                    <option value="">Select District</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="sector_id" class="form-label">Sector</label>
                <select class="form-select" id="sector_id">
                    <option value="">Select Sector</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="cell_id" class="form-label">Cell</label>
                <select class="form-select" id="cell_id">
                    <option value="">Select Cell</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="village_id" class="form-label">Village</label>
                <select class="form-select" id="village_id">
                    <option value="">Select Village</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button class="btn btn-primary" onclick="testAPI()">Test API Endpoints</button>
        <button class="btn btn-secondary" onclick="checkDatabase()">Check Database</button>
        <a href="/test-api" class="btn btn-info" target="_blank">Direct API Test</a>
        <button class="btn btn-warning" onclick="testIndividualAPIs()">Test Individual APIs</button>
    </div>
    
    <div id="results" class="mt-3"></div>
</div>

<script>
function loadDistricts(provinceId) {
    const districtSelect = document.getElementById('district_id');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    
    if (!provinceId) return;
    
    console.log('Loading districts for province:', provinceId);
    
    fetch(`/api/districts/${provinceId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Districts data:', data);
            if (data.districts && data.districts.length > 0) {
                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
                console.log(`Loaded ${data.districts.length} districts`);
            } else {
                console.log('No districts found');
                districtSelect.innerHTML = '<option value="">No districts available</option>';
            }
        })
        .catch(error => {
            console.error('Error loading districts:', error);
            districtSelect.innerHTML = '<option value="">Error loading districts</option>';
        });
    }

function loadSectors(districtId) {
    const sectorSelect = document.getElementById('sector_id');
    sectorSelect.innerHTML = '<option value="">Select Sector</option>';
    
    if (!districtId) return;
    
    console.log('Loading sectors for district:', districtId);
    
    fetch(`/api/sectors/${districtId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Sectors data:', data);
            if (data.sectors && data.sectors.length > 0) {
                data.sectors.forEach(sector => {
                    const option = document.createElement('option');
                    option.value = sector.id;
                    option.textContent = sector.name;
                    sectorSelect.appendChild(option);
                });
                console.log(`Loaded ${data.sectors.length} sectors`);
            } else {
                console.log('No sectors found');
                sectorSelect.innerHTML = '<option value="">No sectors available</option>';
            }
        })
        .catch(error => {
            console.error('Error loading sectors:', error);
            sectorSelect.innerHTML = '<option value="">Error loading sectors</option>';
        });
    }

function loadCells(sectorId) {
    const cellSelect = document.getElementById('cell_id');
    cellSelect.innerHTML = '<option value="">Select Cell</option>';
    
    if (!sectorId) return;
    
    console.log('Loading cells for sector:', sectorId);
    
    fetch(`/api/cells/${sectorId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Cells data:', data);
            if (data.cells && data.cells.length > 0) {
                data.cells.forEach(cell => {
                    const option = document.createElement('option');
                    option.value = cell.id;
                    option.textContent = cell.name;
                    cellSelect.appendChild(option);
                });
                console.log(`Loaded ${data.cells.length} cells`);
            } else {
                console.log('No cells found');
                cellSelect.innerHTML = '<option value="">No cells available</option>';
            }
        })
        .catch(error => {
            console.error('Error loading cells:', error);
            cellSelect.innerHTML = '<option value="">Error loading cells</option>';
        });
    }

function loadVillages(cellId) {
    const villageSelect = document.getElementById('village_id');
    villageSelect.innerHTML = '<option value="">Select Village</option>';
    
    if (!cellId) return;
    
    console.log('Loading villages for cell:', cellId);
    
    fetch(`/api/villages/${cellId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Villages data:', data);
            if (data.villages && data.villages.length > 0) {
                data.villages.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village.id;
                    option.textContent = village.name;
                    villageSelect.appendChild(option);
                });
                console.log(`Loaded ${data.villages.length} villages`);
            } else {
                console.log('No villages found');
                villageSelect.innerHTML = '<option value="">No villages available</option>';
            }
        })
        .catch(error => {
            console.error('Error loading villages:', error);
            villageSelect.innerHTML = '<option value="">Error loading villages</option>';
        });
    }

function testAPI() {
    const results = document.getElementById('results');
    results.innerHTML = '<h4>Testing API Endpoints...</h4>';
    
    // Test provinces
    fetch('/api/districts/1')
        .then(response => response.json())
        .then(data => {
            results.innerHTML += `<p>Provinces API: ${JSON.stringify(data)}</p>`;
        })
        .catch(error => {
            results.innerHTML += `<p>Provinces API Error: ${error.message}</p>`;
        });
}

function checkDatabase() {
    const results = document.getElementById('results');
    results.innerHTML = '<h4>Checking Database...</h4>';
    
    // Check if we have data
    fetch('/api/districts/1')
        .then(response => response.json())
        .then(data => {
            results.innerHTML += `<p>Districts for Province 1: ${JSON.stringify(data)}</p>`;
        })
        .catch(error => {
            results.innerHTML += `<p>Database Error: ${error.message}</p>`;
        });
}

function testIndividualAPIs() {
    const results = document.getElementById('results');
    results.innerHTML = '<h4>Testing Individual API Endpoints...</h4>';
    
    // Test each API endpoint individually
    const endpoints = [
        { name: 'Districts for Province 1', url: '/api/districts/1' },
        { name: 'Sectors for District 1', url: '/api/sectors/1' },
        { name: 'Cells for Sector 1', url: '/api/cells/1' },
        { name: 'Villages for Cell 1', url: '/api/villages/1' }
    ];
    
    endpoints.forEach(endpoint => {
        fetch(endpoint.url)
            .then(response => {
                console.log(`${endpoint.name} - Status:`, response.status);
                return response.json();
            })
            .then(data => {
                console.log(`${endpoint.name} - Data:`, data);
                results.innerHTML += `<p><strong>${endpoint.name}:</strong> ${JSON.stringify(data)}</p>`;
            })
            .catch(error => {
                console.error(`${endpoint.name} - Error:`, error);
                results.innerHTML += `<p><strong>${endpoint.name}:</strong> Error - ${error.message}</p>`;
            });
    });
}

// Event listeners
document.getElementById('province_id').addEventListener('change', function() {
    loadDistricts(this.value);
    // Reset dependent dropdowns
    document.getElementById('sector_id').innerHTML = '<option value="">Select Sector</option>';
    document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
    document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
});

document.getElementById('district_id').addEventListener('change', function() {
    loadSectors(this.value);
    // Reset dependent dropdowns
    document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
    document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
});

document.getElementById('sector_id').addEventListener('change', function() {
    loadCells(this.value);
    // Reset dependent dropdowns
    document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
});

document.getElementById('cell_id').addEventListener('change', function() {
    loadVillages(this.value);
});
</script>
@endsection
