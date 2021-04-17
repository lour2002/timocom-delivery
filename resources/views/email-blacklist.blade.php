<x-app-vue-layout>
    <x-container class="--container">
        <h1 class="page-title">EMAIL BLACKLIST</h1>
        <div class="flex mb-3 items-end">
            <x-label class="flex-grow mr-4">
                <b>Email address</b>
                <x-input class="block w-full mt-1" type="email" v-model="email" ref="newEmail" required />
            </x-label>
            <x-label class="flex-grow mr-4">
                <b>Time to remove from list</b>
                <select class="input block w-full mt-1" v-model="ttl">
                    <option value="86400">24 hour</option>
                    <option value="112800">48 hour</option>
                    <option value="259200">72 hour</option>
                    <option value="604800">week</option>
                    <option value="2592000">month</option>
                </select>
            </x-label>
            <x-button class="flex-shrink" type="button" color="--success" value="ADD EMAIL" v-on:click="addEmailToBlackList"/>
        </div>
        <table class="w-full" ref="blacklist">
            <tr>
                <th class="border-t py-2 border-b text-left"></th>
                <th class="border-t py-2 border-b text-left">Email</th>
                <th class="border-t border-b text-right">Date Deleted</th>
            </tr>
            <template :key="email.id" v-for="email in blacklist">
                <tr>
                    <td class="border-t py-2">
                        <x-button color="--red" value="Del" v-on:click="removeEmailFromBlackList($event, email.id)"/>
                    </td>
                    <td class="border-t py-2" v-text="email.email"></td>
                    <td class="border-t py-2 text-right" v-text="email.ttl"></td>
                </tr>
            </template>
            @foreach ($list as $email)
            <tr>
                <td class="border-t py-2">
                    <x-button color="--red" value="Del" v-on:click="removeEmailFromBlackList($event, {{$email['id']}})"/>
                </td>
                <td class="border-t py-2">{{$email['email']}}</td>
                <td class="border-t py-2 text-right">{{$email['ttl']}}</td>
            </tr>
            @endforeach
        </table>
    </x-container>
</x-app-vue-layout>
