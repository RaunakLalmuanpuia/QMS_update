<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Edit Feedback</h1>

    <form action="{{ route('superadmin.updateFeedback', $file) }}" method="POST" class="mb-8">
      @csrf
      @method('PUT')
      <label for="feedback" class="block mb-2 font-semibold">Feedback:</label>
      <textarea name="feedback" id="feedback" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $file->feedback }}</textarea>
      <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Save Feedback</button>
    </form>
  </div>
</body>

</html>