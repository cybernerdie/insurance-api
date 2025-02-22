<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Insurance Portal</h1>
    </nav>

    <div class="flex items-center justify-center min-h-[calc(100vh-64px)]">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Login</h1>
            <form onsubmit="loginUser(event)" class="space-y-4">
                <p id="error" class="text-red-600 text-center font-medium"></p>

                <div>
                    <label class="block text-gray-700 font-medium">Email:</label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Password:</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Login
                </button>
            </form>
            <p class="text-center mt-4 text-gray-600">
                Don't have an account? <a href="{{ route('register') }}"
                    class="text-blue-600 hover:underline">Register here</a>.
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            const token = localStorage.getItem('jwt_token');
            if (token) {
                window.location.href = '/quotation';
            }
        };

        async function loginUser(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const requestData = {
                email: formData.get('email'),
                password: formData.get('password')
            };

            const errorElement = document.getElementById('error');
            errorElement.textContent = '';

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('jwt_token', data.data.token);
                    localStorage.setItem('user_name', data.data.user.name);
                    localStorage.setItem('user_email', data.data.user.email);
                    window.location.href = "/quotation";
                } else {
                    errorElement.textContent = data.message || 'Login failed. Please try again.';
                }
            } catch (error) {
                errorElement.textContent = 'An error occurred. Please try again.';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const userName = localStorage.getItem('user_name') || 'John Doe';
            const userEmail = localStorage.getItem('user_email') || 'test@example.com';

            document.getElementById('user-name').innerText = userName;
            document.getElementById('user-email').innerText = userEmail;
        });
    </script>
</body>

</html>
