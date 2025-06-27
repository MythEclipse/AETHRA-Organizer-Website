<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container flex bg-black w-[1100px] h-[600px] rounded-lg overflow-hidden shadow-lg shadow-black/50">
        <div class="left-panel flex-1 bg-[#590a8a] text-white flex flex-col items-center justify-center p-5">
            <h1 class="mb-5 text-4xl font-bold">WELCOME</h1>
            <img src="images/logo aeo (3).png" alt="Illustration" class="w-[400px]">
            <h1 class="mt-5 text-4xl font-bold">AETHRA ORGANIZER</h1>
        </div>
        <div class="right-panel flex-1 bg-[#111] text-white flex flex-col items-center justify-center p-8">
            <div class="profile-pic w-20 h-20 rounded-full bg-[url('https://tse1.mm.bing.net/th?id=OIP.KVzKeMipYUAaL7JLempsxwAAAA&pid=Api&P=0&h=180')] bg-center bg-cover mb-2"></div>
            <h2 class="mb-5 text-3xl font-semibold">Login</h2>

            <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm">
                @csrf

                <div class="input-group relative w-full mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" class="w-full py-2.5 pl-4 pr-10 bg-[#222] border-none text-white rounded focus:outline-none focus:ring-2 focus:ring-[#3e7bfc]" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Username" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group relative w-full mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" class="w-full py-2.5 pl-4 pr-10 bg-[#222] border-none text-white rounded focus:outline-none focus:ring-2 focus:ring-[#3e7bfc]"
                           type="password"
                           name="password"
                           required autocomplete="current-password"
                           placeholder="Password" />
                    <span class="toggle-password absolute right-2.5 top-2.5 cursor-pointer text-xl" onclick="togglePassword()">👁️</span>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="login-btn w-full py-2.5 bg-[#3e7bfc] border-none text-white rounded-full font-bold mt-2 cursor-pointer transition duration-300 ease-in-out hover:bg-[#2858d8] ms-3">
                        {{ __('Log in') }}
                    </button>
                </div>

                <p class="signup-text mt-4 text-sm text-gray-400 text-center">No account yet? <a href={{ route('register') }} class="signup-btn text-cyan-400 font-bold no-underline hover:text-cyan-200">SIGN UP NOW</a></p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        }
    </script>
</x-guest-layout>
