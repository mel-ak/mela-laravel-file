<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileExplorerController extends Controller
{
    // Display the root directory
    public function index()
    {
        $path = base_path(); // Default starting directory
        return $this->loadDirectory($path);
    }

    // Navigate to a specific directory
    public function navigate(Request $request)
    {
        $path = $request->input('path', base_path());

        // Validate if path exists and is a directory
        if (!is_dir($path)) {
            return redirect()->route('explorer.index')->withErrors(['Invalid path.']);
        }

        $realPath = realpath($path);

        // Prevent accessing paths outside the base directory
        if (strpos($realPath, base_path()) !== 0) {
            return redirect()->route('explorer.index')->withErrors(['Access denied.']);
        }

        return $this->loadDirectory($realPath);
    }

    // Handle file uploads
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'required|string'
        ]);

        $path = $request->input('path');
        $file = $request->file('file');

        // Check if upload path is valid and writable
        if (!is_dir($path) || !is_writable($path)) {
            return back()->withErrors(['Cannot upload to the specified directory.']);
        }

        // Save the file
        $file->move($path, $file->getClientOriginalName());
        return back()->with('success', 'File uploaded successfully.');
    }

    // Preview a file
    public function preview($file)
    {
        $filePath = base_path($file);

        // Ensure the file exists and is within the base directory
        if (file_exists($filePath) && strpos($filePath, base_path()) === 0) {
            return response()->file($filePath);
        }

        abort(404, 'File not found.');
    }

    // Load directory contents
    private function loadDirectory($path)
    {
        $directories = scandir($path);

        // Filter hidden files and directories
        $directories = array_filter($directories, fn($item) => $item !== '.' && $item !== '..');

        $breadcrumbs = explode(DIRECTORY_SEPARATOR, $path);

        return view('explorer.index', compact('directories', 'path', 'breadcrumbs'));
    }
}
