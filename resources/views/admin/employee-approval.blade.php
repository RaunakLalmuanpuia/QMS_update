<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Approval</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-3xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Employee Approval</h2>

    <!-- Pending Employees -->
    <h3 class="text-xl font-bold">Pending Employees</h3>
    @if($employees->count() > 0)
    <table class="w-full bg-white shadow-md rounded-lg mt-4">
      <thead>
        <tr class="bg-gray-200">
          <th class="py-2 px-4 font-bold">Name</th>
          <th class="py-2 px-4 font-bold">Email</th>
          <th class="py-2 px-4 font-bold">Department</th>
          <th class="py-2 px-4 font-bold">Post</th>
          <th class="py-2 px-4 font-bold">Contact Number</th>
          <th class="py-2 px-4 font-bold">Address</th>
          <th class="py-2 px-4 font-bold">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $employee)
        <tr class="border-b border-gray-200">
          <td class="py-2 px-4">{{ $employee->name }}</td>
          <td class="py-2 px-4">{{ $employee->email }}</td>
          <td class="py-2 px-4">{{ $employee->department }}</td>
          <td class="py-2 px-4">{{ $employee->post }}</td>
          <td class="py-2 px-4">{{ $employee->contact_number }}</td>
          <td class="py-2 px-4">{{ $employee->address }}</td>
          <td class="py-2 px-4 flex justify-center">
            <form action="{{ route('admin.approve-employee', ['id' => $employee->id]) }}" method="POST" class="mr-2">
              @csrf
              <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full">Approve</button>
            </form>
            <form action="{{ route('admin.reject-employee', ['id' => $employee->id]) }}" method="POST">
              @csrf
              <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full">Reject</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="mt-4">No pending employees.</p>
    @endif

    <!-- Approved Employees -->
    <h3 class="text-xl font-bold mt-8">Approved Employees</h3>
    @if($approvedEmployees->count() > 0)
    <table class="w-full bg-white shadow-md rounded-lg mt-4">
      <thead>
        <tr class="bg-gray-200">
          <th class="py-2 px-4 font-bold">Name</th>
          <th class="py-2 px-4 font-bold">Email</th>
          <th class="py-2 px-4 font-bold">Department</th>
          <th class="py-2 px-4 font-bold">Post</th>
          <th class="py-2 px-4 font-bold">Contact Number</th>
          <th class="py-2 px-4 font-bold">Address</th>
        </tr>
      </thead>
      <tbody>
        @foreach($approvedEmployees as $employee)
        <tr class="border-b border-gray-200">
          <td class="py-2 px-4">{{ $employee->name }}</td>
          <td class="py-2 px-4">{{ $employee->email }}</td>
          <td class="py-2 px-4">{{ $employee->department }}</td>
          <td class="py-2 px-4">{{ $employee->post }}</td>
          <td class="py-2 px-4">{{ $employee->contact_number }}</td>
          <td class="py-2 px-4">{{ $employee->address }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="mt-4">No approved employees.</p>
    @endif

  </div>
</body>

</html>