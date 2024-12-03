<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileExplorerController extends Controller
{
    public function index()
    {
        $path = base_path(); // Starting directory
        $directories = scandir($path);
        $breadcrumbs = explode(DIRECTORY_SEPARATOR, $path);

        return view('explorer.index', compact('directories', 'path','breadcrumbs'));
    }

    public function navigate(Request $request)
    {
        $path = $request->input('path', base_path());
        if (!is_dir($path)) {
            return redirect()->route('explorer.index')->withErrors(['Invalid path.']);
        }

        $path = realpath($path);

        if (strpos($path, base_path()) !== 0) {
            return redirect()->route('explorer.index')->withErrors(['Access denied.']);
        }
        $directories = scandir($path);
        $breadcrumbs = explode(DIRECTORY_SEPARATOR, $path);

        return view('explorer.index', compact('directories', 'path', 'breadcrumbs'));
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $path = $request->input('path', base_path());
        $file = $request->file('file');

        $file->move($path, $file->getClientOriginalName());
        return back()->with('success', 'File uploaded successfully.');
    }

    public function preview($file)
    {
        $filePath = base_path($file);
        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
        abort(404, 'File not found');
    }
}
