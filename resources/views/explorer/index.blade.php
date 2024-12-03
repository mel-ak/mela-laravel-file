<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mela File Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Mela File Explorer</h1>

        <!-- Error & Success Messages -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Breadcrumb Navigation -->
        <nav class="flex gap-x-2 text-sm mb-6">
            @foreach ($breadcrumbs as $key => $crumb)
                @if ($key < count($breadcrumbs) - 1)
                    <a href="{{ route('explorer.navigate', ['path' => implode(DIRECTORY_SEPARATOR, array_slice($breadcrumbs, 0, $key + 1))]) }}"
                       class="text-blue-500 hover:underline">{{ $crumb }}</a>
                    <span class="text-gray-400">/</span>
                @else
                    <span class="font-bold">{{ $crumb }}</span>
                @endif
            @endforeach
        </nav>

        <!-- Search Bar -->
        <input type="text" id="search" placeholder="Search files or folders..."
               class="mb-4 p-2 border rounded w-full">

        <!-- Upload Form -->
        <form action="{{ route('explorer.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="hidden" name="path" value="{{ $path }}">
            <div class="flex items-center gap-4">
                <input type="file" name="file" class="p-2 border rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Upload
                </button>
            </div>
        </form>

        <!-- Upload Progress -->
        <div id="upload-progress" class="hidden bg-blue-200 rounded h-2 mb-2">
            <div class="bg-blue-600 h-2" style="width: 0%;" id="progress-bar"></div>
        </div>

        <!-- File/Directory Listing -->
        @if (count($directories) === 0)
            <p class="text-center text-gray-500">This directory is empty.</p>
        @else
            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($directories as $directory)
                    <li class="p-4 border rounded shadow hover:bg-gray-50">
                        @php
                            $fileIcons = [
                                'txt' => '📄',
                                'jpg' => '🖼️',
                                'png' => '🖼️',
                                'pdf' => '📚',
                                'folder' => '📁',
                            ];
                            $extension = is_dir($path . '/' . $directory) ? 'folder' : pathinfo($directory, PATHINFO_EXTENSION);
                        @endphp

                        <a href="{{ is_dir($path . '/' . $directory) 
                                    ? route('explorer.navigate', ['path' => $path . '/' . $directory]) 
                                    : route('explorer.preview', ['file' => $path . '/' . $directory]) }}"
                           class="block text-blue-500 font-semibold hover:underline">
                            <span class="mr-2">{{ $fileIcons[$extension] ?? '📄' }}</span>{{ $directory }}
                        </a>

                        @if (!is_dir($path . '/' . $directory))
                            <a href="{{ route('explorer.preview', ['file' => $path . '/' . $directory]) }}" target="_blank"
                               class="text-sm text-gray-500 hover:underline">Preview</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <script>
        // Search functionality
        document.getElementById('search').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('li').forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(term) ? 'block' : 'none';
            });
        });

        // Simulated upload progress
        const form = document.querySelector('form');
        const progressBar = document.getElementById('progress-bar');
        const uploadProgress = document.getElementById('upload-progress');

        form.addEventListener('submit', (e) => {
            uploadProgress.classList.remove('hidden');
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                progressBar.style.width = progress + '%';
                if (progress >= 100) clearInterval(interval);
            }, 100);
        });
    </script>
</body>
</html>
