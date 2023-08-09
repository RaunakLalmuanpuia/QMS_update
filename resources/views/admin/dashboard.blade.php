<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="container mx-auto">

    <!-- Header -->
    <div class="bg-gray-800 text-white py-4 px-6 flex justify-between items-center">
      <h2 class="text-2xl">Admin Dashboard</h2>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Logout</button>
        <a href="{{ route('admin.employee-approval') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded ml-4">Approve</a>
      </form>
    </div>

    <!-- Content -->
    <div class="my-8">
      <p class="mb-4">Welcome, {{ $name }}</p>
      <h3 class="text-xl font-bold mb-4">Pending Files</h3>
      @if($pendingFiles->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-100">Employee Name</th>
              <th class="py-2 px-4 bg-gray-100">File Name</th>
              <th class="py-2 px-4 bg-gray-100">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pendingFiles as $file)
            @if($file->deleted_by_admin !== 'removed')
            <tr>
              <td class="py-2 px-4">
                {{ $file->employee->name }}
              </td>
              <td class="py-2 px-4">
                <a href="{{ route('admin.view-file', ['id' => $file->id]) }}" class="text-blue-500 hover:underline">{{ $file->filename }}</a>
              </td>
              <td class="py-2 px-4">
                <form action="{{ route('admin.verify-file', ['id' => $file->id]) }}" method="POST">
                  @csrf
                  <div class="mb-2">
                    <label for="status" class="form-label font-bold">Status</label>
                    <select class="form-control" id="status" name="status">
                      <option value="accepted">Accepted</option>
                      <option value="rejected">Rejected</option>
                    </select>
                  </div>
                  <div class="mb-2">
                    <label for="feedback" class="form-label font-bold">Feedback</label>
                    <textarea class="form-control border border-gray-300 rounded w-full" id="feedback" name="feedback" rows="3"></textarea>
                  </div>
                  <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Verify</button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded ml-2">Delete</button>
                  </div>
                </form>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="py-2 px-4">
                <!-- Add any additional information or details here -->
                <!-- Differentiate between two pending files -->
                <hr class="border-gray-300 my-4">
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <p>No pending files.</p>
      @endif

      <h3 class="text-xl font-bold mt-8">Verified Files</h3>
      @if($verifiedFiles->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-100 text-center">Employee Name</th>
              <th class="py-2 px-4 bg-gray-100 text-center">File Name</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Status</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Feedback</th>
              <th class="py-2 px-4 bg-gray-100 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($verifiedFiles as $file)
            @if($file->deleted_by_admin !== 'removed')
            <tr>
              <td class="py-2 px-4 text-center">{{ $file->employee->name }}</td>
              <td class="py-2 px-4 text-center">
                <a href="{{ route('admin.view-file', ['id' => $file->id]) }}" class="text-blue-500 hover:underline text-center">{{ $file->filename }}</a>
              </td>
              <td class="py-2 px-4 text-center">{{ $file->status }}</td>
              <td class="py-2 px-4 text-center">{{ $file->feedback }}</td>
              <td class="py-2 px-4 text-center">
                <div class="btn-group text-center">
                  <form action="{{ route('employee.delete-file', ['id' => $file->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded text-center">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="5" class="py-2 px-4">
                <!-- Add any additional information or details here -->
                <!-- Differentiate between two verified files -->
                <hr class="border-gray-300 my-4">
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <p>No verified files.</p>
      @endif
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="text-center text-gray-500 text-sm mt-8">
      &copy; {{ date('Y') }} MseGs. All rights reserved.
    </footer>
  </div>
</body>

</html>