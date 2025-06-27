<x-guest-layout>
    <div class="container flex bg-black w-[1100px] h-[600px] rounded-lg overflow-hidden shadow-lg shadow-black/50">
        <div class="left-panel flex-1 bg-[#590a8a] text-white flex flex-col items-center justify-center p-5">
            <h1 class="mb-5 text-4xl font-bold">WELCOME</h1>
            <img src="images/logo aeo (3).png" alt="Illustration" class="w-[400px]">
            <h1 class="mt-5 text-4xl font-bold">AETHRA ORGANIZER</h1>
        </div>
        <div class="right-panel flex-1 bg-[#111] text-white flex flex-col items-center justify-center p-8">
            <div class="profile-pic w-20 h-20 rounded-full bg-[url('https://tse1.mm.bing.net/th?id=OIP.KVzKeMipYUAaL7JLempsxwAAAA&pid=Api&P=0&h=180')] bg-center bg-cover mb-2"></div>
            <h2 class="mb-5 text-3xl font-semibold">Forgot Password</h2>

            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center px-4">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-sm">
                @csrf

                <div class="input-group relative w-full mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" class="w-full py-2.5 pl-4 pr-10 bg-[#222] border-none text-white rounded focus:outline-none focus:ring-2 focus:ring-[#3e7bfc]" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="login-btn w-full py-2.5 bg-[#3e7bfc] border-none text-white rounded-full font-bold mt-2 cursor-pointer transition duration-300 ease-in-out hover:bg-[#2858d8]">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>

                <p class="signup-text mt-4 text-sm text-gray-400 text-center">Remember your password? <a href="{{ route('login') }}" class="signup-btn text-cyan-400 font-bold no-underline hover:text-cyan-200">LOGIN</a></p>
            </form>
        </div>
    </div>
</x-guest-layout>
