<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite('resources/css/app.css')

<head>
    <title>Welcome to QMS</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #F3F4F6;
            padding: 20px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
        }

        .header-buttons {
            display: flex;
            gap: 20px;
        }

        .header-button {
            padding: 8px 12px;
            background-color: #4299e1;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .options-container {
            display: none;
            flex-direction: column;
            gap: 10px;
            position: absolute;
            background-color: #fff;
            border: 1px solid #cbd5e0;
            padding: 10px;
            z-index: 1;
        }

        .header-button:hover+.options-container,
        .options-container:hover {
            display: flex;
        }

        .options-container a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background-color: #4299e1;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .options-container a:hover {
            background-color: #3182ce;
        }

        .user-button {
            padding: 8px 12px;
            background-color: #4299e1;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .user-button:hover {
            background-color: #3182ce;
        }

        .image-container {
            position: relative;
            height: 67.52vh;
            /* Adjust the height to fit the viewport */
            max-width: 100%;
            overflow: hidden;
            display: flex;
            /* Add this line to make the container a flex container */
            justify-content: center;
            /* Add this line to horizontally center the image */
        }

        .carousel-image {
            display: none;
            height: 100%;
            max-width: 90%;
            /* Adjust the width of the image to your preference */
            object-fit: cover;
            object-position: center;
        }


        .footer {
            background-color: #E5E7EB;
            padding: 10px 20px;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            min-height: 50px;
            /* Updated max-height */
        }

        .footer-logo {
            margin-right: 10px;
            max-width: 100px;
            height: auto;
        }

        .footer-details {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-title">
            QMS
        </div>
        <div class="header-buttons">
            <!-- Registration Button -->
            <!-- Registration Button -->
            <div class="button-container">
                <button class="header-button registration-button">Registration</button>
                <!-- Registration Options -->
                <div class="options-container registration-options">
                    <a href="{{ route('admin.register') }}">Admin</a>
                    <a href="{{ route('employee.register') }}">Employee</a>
                    <!-- <a href="{{ route('admin.register') }} class=" px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Employee</a> -->

                </div>
            </div>

            <!-- Login Button -->
            <div class="button-container">
                <button class="header-button login-button">Login</button>
                <!-- Login Options -->
                <div class="options-container login-options">
                    <a href="{{ route('admin.login') }}">Admin</a>
                    <a href="{{ route('employee.login') }}">Employee</a>

                </div>
            </div>

            <!-- User Button -->
            <a href=" {{route ('user.home') }}" class="header-button user-button">User</a>
        </div>
    </div>

    <div class="image-container">
        <!-- Replace the image paths with your actual images -->
        <img class="carousel-image" src="/images/1.png" alt="Image 1">
        <img class="carousel-image" src="/images/2.png" alt="Image 2">
        <img class="carousel-image" src="/images/3.png" alt="Image 3">
    </div>

    <div class="footer">
        <img class="footer-logo" src="/images/logo.svg" alt="Organization Logo">
        <div class="footer-details">
            <p>&copy;MSeGS <br> All rights reserved.<br>Address: 123 Main Street <br> City, Country<br>Contact: info@example.com</p>
        </div>
    </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const registrationButton = document.querySelector('.registration-button');
            const registrationOptions = document.querySelector('.registration-options');
            const loginButton = document.querySelector('.login-button');
            const loginOptions = document.querySelector('.login-options');
            const carouselImages = document.querySelectorAll('.carousel-image');
            let currentImageIndex = 0;

            registrationButton.addEventListener('mouseenter', () => {
                registrationOptions.style.display = 'flex';
            });

            registrationOptions.addEventListener('mouseleave', () => {
                registrationOptions.style.display = 'none';
            });

            loginButton.addEventListener('mouseenter', () => {
                loginOptions.style.display = 'flex';
            });

            loginOptions.addEventListener('mouseleave', () => {
                loginOptions.style.display = 'none';
            });

            setInterval(() => {
                carouselImages[currentImageIndex].style.display = 'none';
                currentImageIndex = (currentImageIndex + 1) % carouselImages.length;
                carouselImages[currentImageIndex].style.display = 'block';
            }, 3000);
        });
    </script>
</body>

</html>