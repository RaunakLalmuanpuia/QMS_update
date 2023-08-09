<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Superadmin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-8">Superadmin Dashboard</h1>

    <h2 class="text-2xl font-bold mb-4">Admins</h2>
    <ul class="list-disc list-inside mb-8">
      @foreach ($admins as $admin)
      <li><a href="{{ route('superadmin.viewAdmin', $admin) }}" class="text-blue-500 hover:underline">{{ $admin->name }}</a></li>
      @endforeach
    </ul>

    <h2 class="text-2xl font-bold mb-4">Employees</h2>
    <ul class="list-disc list-inside mb-8">
      @foreach ($employees as $employee)
      <li><a href="{{ route('superadmin.viewEmployee', $employee) }}" class="text-blue-500 hover:underline">{{ $employee->name }}</a></li>
      @endforeach
    </ul>

    <h2 class="text-2xl font-bold mb-4">Files</h2>
    <table class="w-full bg-white shadow-md rounded-lg mb-8">
      <thead>
        <tr>
          <th class="py-2 px-4 font-bold">File Name</th>
          <th class="py-2 px-4 font-bold">Uploaded By</th>
          <th class="py-2 px-4 font-bold">Verified By</th>
          <th class="py-2 px-4 font-bold">Status</th>
          <th class="py-2 px-4 font-bold">Feedback</th>
          <th class="py-2 px-4 font-bold">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($files as $file)
        <tr>
          <td class="py-2 px-4">{{ $file->filename }}</td>
          <td class="py-2 px-4">{{ $file->employee->name }}</td>
          <td class="py-2 px-4">@if($file->admin){{ $file->admin->name }}@else N/A @endif</td>
          <td class="py-2 px-4">{{ $file->status }}</td>
          <td class="py-2 px-4">{{ $file->feedback }}</td>
          <td class="py-2 px-4">
            <div class="relative inline-block text-left">
              <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="file-actions-menu-{{ $file->id }}" aria-expanded="false" aria-haspopup="true" onclick="toggleDropdown('file-actions-menu-{{ $file->id }}')">
                Actions
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 3.5a1 1 0 011 1v11a1 1 0 01-2 0v-11a1 1 0 011-1zm-2.293.207a1 1 0 010 1.414L4.414 9H9a1 1 0 110 2H4.414l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </button>

              <div id="file-actions-menu-{{ $file->id }}-dropdown" class="hidden origin-top-left absolute left-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="file-actions-menu-{{ $file->id }}" tabindex="-1">
                <div class="py-1" role="none">
                  <form id="delete-form-{{ $file->id }}" action="{{ route('superadmin.deleteFile', $file) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $file->id }}').submit();" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1">Delete</button>
                  </form>
                  <a href="{{ route('superadmin.changeFileStatus', $file) }}" method="PUT" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1">Change Status</a>
                  <a href="{{ route('superadmin.editFeedback', $file) }}" method="POST" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1">Edit Feedback</a>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script>
    function toggleDropdown(id) {
      const dropdown = document.getElementById(id + '-dropdown');
      dropdown.classList.toggle('hidden');
    }
  </script>
</body>

</html>