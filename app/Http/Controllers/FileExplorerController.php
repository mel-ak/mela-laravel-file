<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileExplorerController extends Controller
{
    public function index()
    {
        $path = base_path(); // Starting directory
        $directories = scandir($path);

        return view('explorer.index', compact('directories', 'path'));
    }

    public function navigate(Request $request)
    {
        $path = $request->input('path', base_path());
        $directories = scandir($path);

        return view('explorer.index', compact('directories', 'path'));
    }
}
