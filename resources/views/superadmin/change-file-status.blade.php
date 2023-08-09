<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change File Status</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Change File Status</h1>

    <p class="mb-4">Current File Status: {{ $file->status }}</p>

    <form action="{{ route('superadmin.changeFileStatus', $file) }}" method="POST" class="mb-8">
      @csrf
      @method('PUT')
      <label for="status" class="block mb-2 font-semibold">New File Status:</label>
      <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="pending">Pending</option>
        <option value="Accepted">Accepted</option>
        <option value="Rejected">Rejected</option>
      </select>
      <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Change Status</button>
    </form>
  </div>
</body>

</html>