<?php

namespace App\Services;

use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdministrativeDataImporter
{
    private string $baseUrl;
    private ?string $token;

    public function __construct()
    {
        $config = config('services.administrative_api');
        $this->baseUrl = rtrim((string)($config['base_url'] ?? ''), '/');
        $this->token = $config['token'] ?? null;
    }

    public function importAll(): void
    {
        if ($this->baseUrl === '') {
            throw new \RuntimeException('ADMIN_API_URL is not configured');
        }

        // Provinces
        $provinces = $this->fetchWithAction('provinces');
        foreach ($provinces as $province) {
            $provinceCode = $province['provincecode'] ?? $province['code'] ?? null;
            $provinceName = $province['provincename'] ?? $province['name'] ?? null;
            if ($provinceCode === null || $provinceName === null) {
                continue;
            }

            $provinceModel = Province::updateOrCreate(
                ['code' => $provinceCode],
                ['name' => $provinceName]
            );

            // Districts by province
            $districts = $this->fetchWithAction('districts', ['provinceCode' => $provinceCode]);
            foreach ($districts as $district) {
                $districtCode = $district['DistrictCode'] ?? $district['code'] ?? null;
                $districtName = $district['DistrictName'] ?? $district['name'] ?? null;
                if ($districtCode === null || $districtName === null) {
                    continue;
                }

                $districtModel = District::updateOrCreate(
                    ['code' => $districtCode],
                    ['name' => $districtName, 'province_id' => $provinceModel->id]
                );

                // Sectors by district
                $sectors = $this->fetchWithAction('sectors', ['districtCode' => $districtCode]);
                foreach ($sectors as $sector) {
                    $sectorCode = $sector['SectorCode'] ?? $sector['code'] ?? null;
                    $sectorName = $sector['SectorName'] ?? $sector['name'] ?? null;
                    if ($sectorCode === null || $sectorName === null) {
                        continue;
                    }

                    $sectorModel = Sector::updateOrCreate(
                        ['code' => $sectorCode],
                        ['name' => $sectorName, 'district_id' => $districtModel->id]
                    );

                    // Cells by sector
                    $cells = $this->fetchWithAction('cells', ['sectorCode' => $sectorCode]);
                    foreach ($cells as $cell) {
                        $cellCode = $cell['CellCode'] ?? $cell['code'] ?? null;
                        $cellName = $cell['CellName'] ?? $cell['name'] ?? null;
                        if ($cellCode === null || $cellName === null) {
                            continue;
                        }

                        $cellModel = Cell::updateOrCreate(
                            ['code' => $cellCode],
                            ['name' => $cellName, 'sector_id' => $sectorModel->id]
                        );

                        // Villages by cell
                        $villages = $this->fetchWithAction('villages', ['cellCode' => $cellCode]);
                        foreach ($villages as $village) {
                            $villageCode = $village['VillageCode'] ?? $village['code'] ?? null;
                            $villageName = $village['VillageName'] ?? $village['name'] ?? null;
                            if ($villageCode === null || $villageName === null) {
                                continue;
                            }

                            Village::updateOrCreate(
                                ['code' => $villageCode],
                                ['name' => $villageName, 'cell_id' => $cellModel->id]
                            );
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetch(string $path): array
    {
        $url = $this->baseUrl . $path;

        try {
            $request = Http::timeout((int) (config('services.administrative_api.timeout') ?? 30));
            if (!empty($this->token)) {
                $request = $request->withToken($this->token);
            }

            $response = $request->get($url);
            if (!$response->successful()) {
                throw new \RuntimeException("Failed to fetch {$url}: " . $response->status());
            }

            $data = $response->json();
            if (!is_array($data)) {
                throw new \RuntimeException("Invalid response for {$url}");
            }

            return $data;
        } catch (Throwable $e) {
            Log::error('Administrative API fetch error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Helper for the api.php style endpoint that expects query params like ?action=provinces.
     * Handles both { ok, data } and direct array responses.
     *
     * @param array<string, string> $params
     * @return array<int, array<string, mixed>>
     */
    private function fetchWithAction(string $action, array $params = []): array
    {
        // Build URL: either base is .../api.php or a host path; we always append query string
        $query = http_build_query(array_merge(['action' => $action], $params));
        $delimiter = str_contains($this->baseUrl, '?') ? '&' : '?';
        $url = $this->baseUrl . $delimiter . $query;

        try {
            $request = Http::timeout((int) (config('services.administrative_api.timeout') ?? 30))
                ->acceptJson();
            if (!empty($this->token)) {
                $request = $request->withToken($this->token);
            }

            $response = $request->get($url);
            if (!$response->successful()) {
                throw new \RuntimeException("Failed to fetch {$url}: " . $response->status());
            }

            $body = $response->json();
            if (is_array($body) && array_key_exists('ok', $body)) {
                if (!($body['ok'] ?? false)) {
                    $message = is_string($body['error'] ?? null) ? $body['error'] : 'Unknown error';
                    throw new \RuntimeException("API error for {$url}: {$message}");
                }
                $data = $body['data'] ?? [];
            } else {
                $data = $body;
            }

            if (!is_array($data)) {
                throw new \RuntimeException("Invalid response format for {$url}");
            }

            return $data;
        } catch (Throwable $e) {
            Log::error('Administrative API action fetch error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}


