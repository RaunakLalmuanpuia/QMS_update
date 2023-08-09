<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Dashboard</title>
  <!-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
  <div class="container mx-auto p-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Employee Dashboard</h2>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Logout</button>
      </form>
    </div>

    <!-- Content -->
    <div class="mb-8">
      <p class="mb-4">Welcome, {{ $name }}</p>

      <!-- File Upload Form -->
      <form action="{{ route('employee.upload-file') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
          <label for="file" class="block font-bold mb-1">Choose File</label>
          <input type="file" class="border border-gray-300 p-2 rounded w-full" id="file" name="file">
          @error('file')
          <div class="text-red-500 mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-4">
          <label for="filename" class="block font-bold mb-1">File Name</label>
          <input type="text" class="border border-gray-300 p-2 rounded w-full" id="filename" name="filename">
          @error('filename')
          <div class="text-red-500 mt-2">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Upload File</button>
      </form>

      <!-- Display Uploaded Files -->
      <h3 class="text-xl font-bold mt-8">Uploaded Files</h3>
      @if($files->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-100 text-center">File Name</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Status</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Feedback</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($files as $file)
            @if($file->deleted_by_employee !== 'removed')
            <tr>
              <td class="py-2 px-4 text-center" >{{ $file->filename }}</td>
              <td class="py-2 px-4 text-center">{{ $file->status }}</td>
              <td class="py-2 px-4 text-center">{{ $file->feedback }}</td>
              <td class="py-2 px-4 text-center">
                <div class="flex items-center text-center">
                  <a href="{{ route('employee.view-file', ['id' => $file->id]) }}" class="mr-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded text-center">View</a>
                  <form action="{{ route('employee.delete-file', ['id' => $file->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded text-center">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <p>No files uploaded yet.</p>
      @endif
    </div>

    <!-- Footer -->
    <footer class="text-center text-gray-500 text-sm mt-8">
      &copy; {{ date('Y') }} MseGs. All rights reserved.
    </footer>
  </div>
</body>

</html>