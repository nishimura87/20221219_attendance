<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="title ">会員登録</h2>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="名前" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="パスワード" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required 
                                placeholder="確認用パスワード" />
            </div>
            <button class="register btn">
                {{ __('会員登録') }}
            </button>
        
            <a class="login txt">アカウントをお持ちの方はこちらから</a>
            <a class="login link" href="{{ route('login') }}">
                {{ __('ログイン') }}
            </a>
        </form>
    </x-auth-card>
</x-guest-layout>
