<x-app-layout>
    <x-container class="--container">
        <h2 class="page-title">SMTP SETTINGS</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form class="grid grid-cols-2 gap-4 items-center" action="{{ route('smtp') }}" method="post" id="companySetting">
            @csrf
            @if ($smtp['id'] ?? false)
                <x-input type="hidden" name="id" value="{{ $smtp->id }}" />
            @endif
            <x-label class="mb-3">
                {{ __('Email address') }}:
                <x-input class="w-full block mt-1" type="email" name="email" :value="$smtp['email'] ?? ''" :placeholder="__('Email address')" autofocus required/>
            </x-label>
            <x-label class="mb-3">
                {{ __('SMTP server') }}:
                <x-input class="w-full block mt-1" type="text" name="server" :value="$smtp['server'] ?? ''" :placeholder="__('SMTP server')" required/>
            </x-label>
            <x-label class="mb-3">
                {{ __('SMTP port') }}:
                <x-input class="w-full block mt-1" type="number" name="port" :value="$smtp['port'] ?? ''" :placeholder="__('SMTP port')" required/>
            </x-label>
            <x-label class="mb-3">
                {{ __('SMTP login') }}:
                <x-input class="w-full block mt-1" type="text" name="login" :value="$smtp['login'] ?? ''" :placeholder="__('SMTP login')" required/>
            </x-label>
            <x-label class="mb-3">
                {{ __('SMTP password') }}:
                <x-input class="w-full block mt-1" type="text" name="password" :value="$smtp['password'] ?? ''" :placeholder="__('SMTP password')" required/>
            </x-label>

            <div class="text-right">
                <input type="submit" value="Save SMTP settings" class="btn mt-2">
            </div>
        </form>
    </x-container>
</x-app-layout>
