<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
  <div class="wrapper">
    <div class="header bg-blue-500 py-2 px-4 flex justify-between items-center">
      <h1 class="header-title text-white">Admin Portal</h1>
      <a class="header-link text-white" href="/">Home</a>
    </div>

    <div class="form-container max-w-lg mx-auto bg-white rounded-md shadow-md mt-8 px-6 py-8">
      <h2 class="form-title text-2xl font-bold mb-8 text-center">Admin Login</h2>

      @if (session('email_sent'))
      <div class="bg-green-200 text-green-800 rounded-md p-4 mt-4 mb-8">
        OTP has been sent to your email address.
      </div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}" class="w-full">
        @csrf
        <div class="mb-4">
          <label for="email" class="block font-medium mb-1">Email:</label>
          <input type="email" name="email" id="email" class="border border-gray-300 rounded-md p-2 w-full" required>
          @error('email')
          <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-4">
          <label for="password" class="block font-medium mb-1">Password:</label>
          <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2 w-full" required>
          @error('password')
          <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Login</button>
      </form>

      <hr class="my-8">

      @if (session('email_sent'))
      <h3 class="text-2xl font-bold mb-4">OTP Verification</h3>
      <form method="POST" action="{{ route('admin.verify-otp') }}" class="w-full">
        @csrf
        <div class="mb-4">
          <label for="otp" class="block font-medium mb-1">OTP:</label>
          <input type="text" name="otp" id="otp" class="border border-gray-300 rounded-md p-2 w-full" required>
          @error('otp')
          <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Verify OTP</button>
      </form>
      @endif
    </div>

    <div class="bg-gray-200 py-2 px-4 flex items-center justify-end flex-wrap mt-auto">
      <img class="mr-2 h-8" src="/images/logo.svg" alt="Organization Logo">
      <div>
        <p>&copy;MSeGS <br> All rights reserved.<br>Address: 123 Main Street <br> City, Country<br>Contact: info@example.com</p>
      </div>
    </div>
  </div>
</body>

</html>