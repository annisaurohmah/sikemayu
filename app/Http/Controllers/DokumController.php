<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumController extends Controller
{
    public function index()
    {   
        
        // Logic to show the document management page
        return view('dokum.index');
    }

    public function upload(Request $request)
    {
        // Logic to handle file upload
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents');

        // Save file path to database or perform other actions

        return redirect()->route('dokum.index')->with('success', 'File uploaded successfully!');
    }
    public function download($filename)
    {
        // Logic to handle file download
        $path = storage_path('app/documents/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
    public function delete($filename)
    {
        // Logic to handle file deletion
        $path = storage_path('app/documents/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            return redirect()->route('dokum.index')->with('success', 'File deleted successfully!');
        } else {
            return redirect()->route('dokum.index')->with('error', 'File not found!');
        }
    }
}
