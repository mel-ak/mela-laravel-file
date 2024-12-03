<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Explorer</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold">Laravel File Explorer</h1>
        <div class="mt-4">
            <p>Current Path: {{ $path }}</p>
        </div>
        <ul class="mt-6">
            @foreach ($directories as $directory)
                <li>
                    <a href="{{ route('explorer.navigate', ['path' => $path . '/' . $directory]) }}"
                       class="text-blue-500 hover:underline">
                        {{ $directory }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
