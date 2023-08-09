<!DOCTYPE html>
<html>

<head>
  <title>User Homepage</title>
  <!-- Add the Tailwind CSS stylesheet -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  
</head>

<body class="bg-gray-100">
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">User Homepage</h1>
    <a href="{{ route('homepage') }}" class="block mt-6 text-right text-blue-500 hover:underline">Back to Homepage</a>

    <form action="{{ route('user.search') }}" method="POST" class="mb-6">
      @csrf
      <div class="flex items-center space-x-4">
        <input type="text" name="search" placeholder="Search for a file" class="px-4 py-2 border border-gray-300 rounded-md">
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-md">
          <option value="filename">File Name</option>
          <option value="uploaded_by">Uploaded By</option>
          <option value="verified_by">Verified By</option>
          <option value="status">Status</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
      </div>
    </form>

    <table class="w-full border-collapse">
      <thead>
        <tr>
          <th class="px-4 py-2 bg-gray-200 border text-center">File</th>
          <th class="px-4 py-2 bg-gray-200 border text-center">Uploaded By</th>
          <th class="px-4 py-2 bg-gray-200 border text-center">Verified By</th>
          <th class="px-4 py-2 bg-gray-200 border text-center">Status</th>
          <th class="px-4 py-2 bg-gray-200 border text-center">Feedback</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($files as $file)
        <tr>
          <td class="px-4 py-2 border text-center">
            <a href="{{ route('user.view', ['filename' => $file->filename]) }}" class="text-blue-500 hover:underline">{{ $file->filename }}</a>
          </td>
          <td class="px-4 py-2 border text-center">{{ $file->employee->name }}</td>
          <td class="px-4 py-2 border text-center">
            @if ($file->verified_by_admin)
            {{ $file->admin->name }}
            @else
            N/A
            @endif
          </td>
          <td class="px-4 py-2 border text-center">{{ $file->status }}</td>
          <td class="px-4 py-2 border text-center">{{ $file->feedback_by_admin }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-4 py-2 border text-center">No files found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    @if (isset($search))
    <a href="{{ route('user.home') }}" class="block mt-6 text-blue-500 hover:underline">Back to User Homepage</a>
    @endif
  </div>
</body>

</html>
