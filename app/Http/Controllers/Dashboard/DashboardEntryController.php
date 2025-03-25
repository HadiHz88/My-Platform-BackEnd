<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntryRequest;
use App\Models\Entry;
use Illuminate\Http\Request;

class DashboardEntryController extends Controller
{
    public function index()
    {
        return response()->json([
            'entries' => Entry::all()
        ]);
    }

    public function store(EntryRequest $request)
    {
        Entry::create($request->validated());

        return response()->json([
            'message' => 'Entry created successfully.'
        ], 201);
    }

    public function update(EntryRequest $request, Entry $entry)
    {
        $entry->update($request->validated());

        return response()->json([
            'message' => 'Entry updated successfully.'
        ]);
    }

    /**
     * Delete an entry.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return response()->json([
            'message' => 'Entry deleted successfully.'
        ], 204);
    }
}
