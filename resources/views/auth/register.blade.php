<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Insurance Portal</h1>
    </nav>

    <div class="flex items-center justify-center min-h-[calc(100vh-64px)]">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Register</h1>
            <form onsubmit="registerUser(event)" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium">Name:</label>
                    <input type="text" name="name" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                    <p id="name-error" class="field-error text-red-600 mt-1"></p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Email:</label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                    <p id="email-error" class="field-error text-red-600 mt-1"></p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Password:</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                    <p id="password-error" class="field-error text-red-600 mt-1"></p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Confirm Password:</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                    <p id="password_confirmation-error" class="field-error text-red-600 mt-1"></p>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Register
                </button>
            </form>
            <p class="text-center mt-4 text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login
                    here</a>.
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

        async function registerUser(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const requestData = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            };

            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            });

            const data = await response.json();
            const errorElement = document.getElementById('general-error');

            const fieldErrors = document.querySelectorAll('.field-error');
            fieldErrors.forEach(error => error.textContent = '');

            if (response.ok) {
                window.location.href = "/login";
            } else {
                if (data.errors) {
                    if (data.errors.name) {
                        document.getElementById('name-error').textContent = data.errors.name[0];
                    }
                    if (data.errors.email) {
                        document.getElementById('email-error').textContent = data.errors.email[0];
                    }
                    if (data.errors.password) {
                        document.getElementById('password-error').textContent = data.errors.password[0];
                    }
                }
            }
        }
    </script>
</body>

</html>
