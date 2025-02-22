<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Quotation</title>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Insurance Portal</h1>
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p id="user-name" class="font-semibold">John Doe</p>
                <p id="user-email" class="text-sm text-gray-600">john@example.com</p>
            </div>
            <button onclick="logout()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </div>
    </nav>

    <div class="flex items-center justify-center min-h-[calc(100vh-64px)]">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Get Travel Insurance Quote</h1>

            <form onsubmit="getQuotation(event)" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium">Age (comma-separated):</label>
                    <input type="text" name="age" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Currency:</label>
                    <select name="currency_id" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Start Date:</label>
                    <input type="date" name="start_date" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">End Date:</label>
                    <input type="date" name="end_date" required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Get Quotation
                </button>
            </form>

            <button onclick="clearForm()"
                class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg hover:bg-gray-600 transition">
                Clear Form
            </button>

            <div id="result" class="mt-4"></div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    window.onload = function() {
        const token = localStorage.getItem('jwt_token');
        if (!token) {
            window.location.href = '/login';
        }
    };

    async function getQuotation(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const requestData = {
            age: formData.get('age'),
            currency_id: formData.get('currency_id'),
            start_date: formData.get('start_date'),
            end_date: formData.get('end_date')
        };

        const token = localStorage.getItem('jwt_token');

        const response = await fetch('/api/quotation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(requestData)
        });

        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = '';

        const data = await response.json();

        if (response.ok) {
            resultDiv.innerHTML = `
                <div class="bg-green-100 text-green-800 p-4 rounded-md mt-4">
                    <p class="font-semibold">Total Price: <span class="font-bold">${data.data.total}</span></p>
                    <p>Currency: <span class="font-bold">${data.data.currency_id}</span></p>
                    <p>Quotation ID: <span class="font-bold">${data.data.quotation_id}</span></p>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="bg-red-100 text-red-800 p-4 rounded-md mt-4">
                    <p>Error: ${data.message}</p>
                </div>
            `;
        }
    }

    async function logout() {
        const token = localStorage.getItem('jwt_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                localStorage.removeItem('jwt_token');
                window.location.href = '/login';
            } else {
                alert('Logout failed. Please try again.');
            }
        } catch (error) {
            alert('An error occurred. Please check your internet connection.');
        }
    }

    function clearForm() {
        document.querySelector('form').reset();
        document.getElementById('result').innerHTML = '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const userName = localStorage.getItem('user_name') || 'John Doe';
        const userEmail = localStorage.getItem('user_email') || 'test@example.com';

        document.getElementById('user-name').innerText = userName;
        document.getElementById('user-email').innerText = userEmail;
    });
</script>