<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Insurance API</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Insurance Portal</h1>
    </nav>
    
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)]">
        <div class="text-center bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Welcome to Our Insurance Portal</h1>
            <p class="text-gray-600 mb-6">Get started by logging in or registering an account.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>
