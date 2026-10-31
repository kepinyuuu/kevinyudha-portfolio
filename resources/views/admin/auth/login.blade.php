<x-layouts.admin :title="'Login Admin'">
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Kevin Portfolio</h1>
            <p class="text-gray-500 mt-1 text-sm">Admin Dashboard</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Masuk ke Dashboard</h2>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                <p class="text-red-700 text-sm">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" id="admin-login-form">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="admin-label" for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" class="admin-input" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div>
                        <label class="admin-label" for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" class="admin-input" required>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300 text-amber-700">
                        <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors" id="login-submit">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.admin>
