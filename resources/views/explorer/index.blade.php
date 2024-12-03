<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Laravel File Explorer</h1>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Breadcrumb Navigation -->
        <nav class="mb-6">
            @foreach ($breadcrumbs as $key => $crumb)
                @if ($key < count($breadcrumbs) - 1)
                    <a href="{{ route('explorer.navigate', ['path' => implode(DIRECTORY_SEPARATOR, array_slice($breadcrumbs, 0, $key + 1))]) }}"
                       class="text-blue-500 hover:underline">{{ $crumb }}</a> /
                @else
                    <span class="text-gray-700">{{ $crumb }}</span>
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
            <input type="file" name="file" class="mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
        </form>

        <!-- File/Directory Listing -->
        <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($directories as $directory)
                <li class="p-4 border rounded shadow hover:bg-gray-50">
                    <a href="{{ route('explorer.navigate', ['path' => $path . '/' . $directory]) }}"
                       class="block text-blue-500 font-semibold hover:underline">
                        @if (is_dir($path . '/' . $directory))
                            📁 {{ $directory }}
                        @else
                            📄 {{ $directory }}
                        @endif
                    </a>

                    <!-- File Preview -->
                    @if (!is_dir($path . '/' . $directory))
                        <a href="{{ route('explorer.preview', ['file' => $path . '/' . $directory]) }}" target="_blank"
                           class="text-sm text-gray-500 hover:underline">Preview</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('li').forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(term) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
