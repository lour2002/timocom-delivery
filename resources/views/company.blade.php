<x-app-layout>
    <x-container class="--container">
        <h2 class="page-title">COMPANY SETTINGS</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form class="grid grid-cols-2 gap-4 items-center" action="/company" method="post" id="companySetting">
            @csrf
            @if ($settings['id'] ?? false)
                <input type="hidden" name="id" value="{{$settings['id']}}" />
            @endif

            <div class="mb-3">
                <x-label for="timocomId" :value="__('TIMOCOM ID').':'" />
                <x-input id="timocomId" class="w-full block mt-1" type="number" name="timocomId" :value="$settings['timocom_id'] ?? ''" :placeholder="__('TIMOCOM ID')"   />
            </div>
            <div class="mb-3">
                <x-label for="companyName" :value="__('Company name').':'" />
                <x-input id="companyName" class="w-full block mt-1" type="text" name="companyName" :value="$settings['name'] ?? ''" :placeholder="__('Company name')" autofocus />
            </div>
            <div class="mb-3">
                <x-label for="contactPerson" :value="__('Contact person').':'" />
                <x-input id="contactPerson" class="w-full block mt-1" type="text" name="contactPerson" :value="$settings['contact_person'] ?? ''" :placeholder="__('Contact person')" required />
            </div>
            <div class="mb-3">
                <x-label for="phone" :value="__('Phone').':'" />
                <x-input id="phone" class="w-full block mt-1" type="text" name="phone" :value="$settings['phone'] ?? ''" :placeholder="__('Phone')"  />
            </div>
            <div class="mb-3">
                <x-label for="email" :value="__('Email').':'" />
                <x-input id="email" class="w-full block mt-1" type="email" name="email" :value="$settings['email'] ?? ''" :placeholder="__('Email')" required />
            </div>
            <div class="text-right">
                <x-button value="Save Company setting" class="mt-2" color="--primary" />
            </div>
        </form>
    </x-container>
</x-app-layout>
