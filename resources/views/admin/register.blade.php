<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .form-error {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>

<body class="bg-gray-100">
  <div class="header bg-blue-500 py-2 px-4 flex justify-between items-center">
    <h1 class="header-title text-white">QMS</h1>
    <a class="header-link text-white" href="/">Home</a>
  </div>

  <div class="form-container max-w-md mx-auto bg-white rounded-md shadow-md mt-8 px-6 py-8">
    <h1 class="form-title text-2xl font-bold mb-8 text-center">Admin Registration</h1>

    @if(session('success'))
    <div class="bg-green-200 text-green-800 rounded-md p-4 mt-4 mb-8">
      {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}" class="w-full">
      @csrf

      <div class="mb-4">
        <label for="name" class="block font-medium mb-1">Name:</label>
        <input type="text" name="name" id="name" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('name')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="department" class="block font-medium mb-1">Department:</label>
        <select name="department" id="department" class="border border-gray-300 rounded-md p-2 w-full" required>
          <option value="">Select Department</option>
          <option value="Department 1">Department 1</option>
          <option value="Department 2">Department 2</option>
          <option value="Department 3">Department 3</option>
        </select>
        @error('department')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="post" class="block font-medium mb-1">Post:</label>
        <select name="post" id="post" class="border border-gray-300 rounded-md p-2 w-full" required>
          <option value="">Select Post</option>
        </select>
        @error('post')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="email" class="block font-medium mb-1">Email:</label>
        <input type="email" name="email" id="email" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('email')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="password" class="block font-medium mb-1">Password:</label>
        <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('password')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="block font-medium mb-1">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('password_confirmation')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="contact_number" class="block font-medium mb-1">Contact Number:</label>
        <input type="text" name="contact_number" id="contact_number" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('contact_number')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="address" class="block font-medium mb-1">Address:</label>
        <input type="text" name="address" id="address" class="border border-gray-300 rounded-md p-2 w-full" required>
        @error('address')
        <div class="form-error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="block bg-blue-500 text-white font-bold py-2 px-4 rounded-md w-full">Register</button>
    </form>
  </div>

  <div class="footer bg-gray-300 py-2 px-4 flex justify-end items-center mt-8">
    <img class="footer-logo mr-2 max-w-full h-auto" src="/images/logo.svg" alt="Organization Logo">
    <div class="footer-details">
      <p class="text-sm">&copy;MSeGS <br> All rights reserved.<br>Address: 123 Main Street <br> City, Country<br>Contact: info@example.com</p>
    </div>
  </div>

  <script>
    const departmentSelect = document.getElementById('department');
    const postSelect = document.getElementById('post');

    departmentSelect.addEventListener('change', () => {
      const department = departmentSelect.value;
      updatePostOptions(department);
    });

    function updatePostOptions(department) {
      // Clear the current options
      postSelect.innerHTML = '';

      if (department === 'Department 1') {
        addOption('Post 1');
        addOption('Post 2');
      } else if (department === 'Department 2') {
        addOption('Post 3');
        addOption('Post 4');
      } else if (department === 'Department 3') {
        addOption('Post 5');
        addOption('Post 6');
      }

      function addOption(value) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = value;
        postSelect.appendChild(option);
      }
    }
  </script>
</body>

</html>