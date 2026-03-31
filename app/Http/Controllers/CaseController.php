<?php

namespace App\Http\Controllers;

use App\Models\CaseRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = CaseRecord::with('creator');

        // Admins see all; staff see only their own
        if (auth()->user()->isStaff()) {
            $query->where('created_by', auth()->id());
        }

        // Search filtering
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('case_no', 'like', "%{$search}%")
                  ->orWhere('complainant', 'like', "%{$search}%")
                  ->orWhere('respondent', 'like', "%{$search}%")
                  ->orWhere('nature_of_complaint', 'like', "%{$search}%");
            });
        }

        $cases = $query->latest()->paginate(15)->withQueryString();

        return view('cases.index', compact('cases', 'search'));
    }

    public function create()
    {
        return view('cases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_no'              => 'required|string|unique:cases,case_no',
            'complainant'          => 'required|string|max:255',
            'respondent'           => 'required|string|max:255',
            'nature_of_complaint'  => 'required|string',
            'pdf_file'             => 'required|mimes:pdf|max:10240',
        ]);

        $path = $request->file('pdf_file')->store('cases', 'public');

        CaseRecord::create([
            'case_no'             => $validated['case_no'],
            'complainant'         => $validated['complainant'],
            'respondent'          => $validated['respondent'],
            'nature_of_complaint' => $validated['nature_of_complaint'],
            'pdf_file'            => $path,
            'created_by'          => auth()->id(),
        ]);

        return redirect()->route('cases.index')
            ->with('success', 'Case record added successfully.');
    }

    public function show(CaseRecord $case)
    {
        return view('cases.show', compact('case'));
    }

    public function edit(CaseRecord $case)
    {
        // Staff can only edit their own cases
        if (auth()->user()->isStaff() && $case->created_by !== auth()->id()) {
            abort(403, 'You are not authorized to edit this case.');
        }

        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, CaseRecord $case)
    {
        // Staff can only update their own cases
        if (auth()->user()->isStaff() && $case->created_by !== auth()->id()) {
            abort(403, 'You are not authorized to update this case.');
        }

        $validated = $request->validate([
            'case_no'              => 'required|string|unique:cases,case_no,' . $case->id,
            'complainant'          => 'required|string|max:255',
            'respondent'           => 'required|string|max:255',
            'nature_of_complaint'  => 'required|string',
            'pdf_file'             => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('pdf_file')) {
            // Delete old file if exists
            if ($case->pdf_file) {
                Storage::disk('public')->delete($case->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('cases', 'public');
        }

        $case->update($validated);

        return redirect()->route('cases.index')
            ->with('success', 'Case record updated successfully.');
    }

    public function pdf(CaseRecord $case)
    {
        $path = storage_path('app/public/' . $case->pdf_file);

        if (!$case->pdf_file || !file_exists($path)) {
            abort(404, 'PDF file not found.');
        }

        return response()->file($path, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    public function destroy(CaseRecord $case)
    {
        // Only admins can delete any case; staff cannot delete
        if (auth()->user()->isStaff()) {
            abort(403, 'Staff are not authorized to delete cases.');
        }

        if ($case->pdf_file) {
            Storage::disk('public')->delete($case->pdf_file);
        }

        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', 'Case record deleted successfully.');
    }
}
