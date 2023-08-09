<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
  <div class="flex flex-col min-h-screen">
    <div class="bg-blue-500 py-2 px-4 flex items-center justify-between">
      <h1 class="text-white text-xl font-bold">Employee Portal</h1>
      <a class="text-white" href="/">Home</a>
    </div>

    <div class="mx-auto w-full max-w-md mt-8 p-8 bg-white shadow-md rounded-md">
      <h2 class="text-2xl mb-8">Employee Login</h2>

      @if (session('email_sent'))
      <div class="bg-green-200 text-green-800 rounded-md p-4 mt-4 mb-8">
        OTP has been sent to your email address.
      </div>
      @endif

      <form method="POST" action="{{ route('employee.login.post') }}">
        @csrf
        <div class="mb-4">
          <label for="email" class="block font-medium">Email:</label>
          <input type="email" name="email" id="email" class="border border-gray-300 rounded-md p-2 w-full" required>
          @error('email')
          <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-4">
          <label for="password" class="block font-medium">Password:</label>
          <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2 w-full" required>
          @error('password')
          <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Login</button>
      </form>

      <hr class="my-8">

      @if (session('email_sent'))
      <h3 class="text-xl mb-4">OTP Verification</h3>
      <form method="POST" action="{{ route('employee.verify-otp') }}">
        @csrf
        <div class="mb-4">
          <label for="otp" class="block font-medium">OTP:</label>
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