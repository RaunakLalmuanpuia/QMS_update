<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Details</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-4">Admin Details</h1>

    <p class="mb-2"><span class="font-bold">Name:</span> {{ $admin->name }}</p>

    <p class="mb-2"><span class="font-bold">Email:</span> {{ $admin->email }}</p>
    <p class="mb-2"><span class="font-bold">Department:</span> {{ $admin->department }}</p>
    <p class="mb-2"><span class="font-bold">Post:</span> {{ $admin->post }}</p>
    <p class="mb-2"><span class="font-bold">Contact Number:</span> {{ $admin->contact_number }}</p>
    <p class="mb-2"><span class="font-bold">Address:</span> {{ $admin->address }}</p>
    <p class="mb-4"><span class="font-bold">Homepage:</span> <a href="{{ route('admin.dashboard', $admin) }}" class="text-blue-500 hover:underline">Go to Homepage</a></p>

    <form action="{{ route('superadmin.deleteAdmin', $admin) }}" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Delete Admin</button>
    </form>
  </div>
</body>

</html>