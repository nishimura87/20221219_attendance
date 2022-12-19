<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="title ">ログイン</h2>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" />

                <x-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" 
                    placeholder="パスワード" />
            </div>
            <button class="login btn">
            {{ __('ログイン') }}
            </button>
            <a class="register txt">アカウントをお持ちの方はこちらから</a>
            <a class="register link" href="{{ route('register') }}">
                    {{ __('会員登録') }}
            </a>
        </form>
    </x-auth-card>
</x-guest-layout>
