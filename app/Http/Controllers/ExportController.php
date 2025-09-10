<?php

namespace App\Http\Controllers;

use App\Models\Shloka;
use App\Models\QAPair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * Display export options page.
     */
    public function index()
    {
        $this->authorize('export');

        return view('export.index');
    }

    /**
     * Export shlokas to JSON format based on selected fields.
     */
    public function exportJson(Request $request)
    {
        $this->authorize('export');

        $validated = $request->validate([
            'include_pending' => 'nullable|boolean',
            'fields' => 'required|array',
            'fields.shloka' => 'nullable|array',
            'fields.qa_pair' => 'nullable|array',
        ]);

        $selectedShlokaFields = array_keys($validated['fields']['shloka'] ?? []);
        $selectedQaPairFields = array_keys($validated['fields']['qa_pair'] ?? []);

        if (empty($selectedShlokaFields)) {
            return back()->withErrors(['fields' => 'You must select at least one Shloka field to export.'])->withInput();
        }

        $query = Shloka::with(['approvedQAPairs']);

        if (!$request->include_pending) {
            $query->approved();
        }

        $shlokas = $query->get();

        $exportData = $shlokas->map(function ($shloka) use ($selectedShlokaFields, $selectedQaPairFields) {
            $shlokaData = [];
            foreach ($selectedShlokaFields as $field) {
                $shlokaData[$field] = $shloka->$field;
            }

            if (!empty($selectedQaPairFields)) {
                $shlokaData['qa_pairs'] = $shloka->approvedQAPairs->map(function ($qaPair) use ($selectedQaPairFields) {
                    $qaData = [];
                    foreach ($selectedQaPairFields as $field) {
                        $qaData[$field] = $qaPair->$field;
                    }
                    return $qaData;
                });
            }

            return $shlokaData;
        })->values()->toArray();

        $filename = 'shloka_export_' . now()->format('Y_m_d_His') . '.json';
        $jsonContent = json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $tempPath = 'exports/' . $filename;
        Storage::put($tempPath, $jsonContent);

        return response()->download(
            Storage::path($tempPath),
            $filename,
            ['Content-Type' => 'application/json']
        )->deleteFileAfterSend();
    }

    /**
     * Get available filters for export
     */
    public function getFilters()
    {
        $sources = Shloka::distinct()->pluck('source_text_name')->filter();
        $categories = Shloka::distinct()->pluck('category')->filter();

        return response()->json([
            'sources' => $sources,
            'categories' => $categories,
        ]);
    }
}