<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" :value="__('NIK (16 Digit)')" />
            <x-text-input id="nik"
                class="block mt-1 w-full"
                type="text"
                name="nik"
                maxlength="16"
                :value="old('nik')"
                required />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Jenis Pasien -->
        <div class="mt-4">
            <x-input-label for="insurance_type" :value="__('Jenis Pasien')" />

            <select id="insurance_type"
                name="insurance_type"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                onchange="toggleBpjsField()">
                <option value="umum">Umum</option>
                <option value="bpjs">BPJS</option>
            </select>

            <x-input-error :messages="$errors->get('insurance_type')" class="mt-2" />
        </div>

        <!-- Nomor BPJS -->
        <div class="mt-4 hidden" id="bpjs_field">
            <x-input-label for="bpjs_number" :value="__('Nomor BPJS')" />
            <x-text-input id="bpjs_number"
                class="block mt-1 w-full"
                type="text"
                name="bpjs_number" />
            <x-input-error :messages="$errors->get('bpjs_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Register
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleBpjsField() {
            const type = document.getElementById('insurance_type').value;
            const field = document.getElementById('bpjs_field');

            if (type === 'bpjs') {
                field.classList.remove('hidden');
            } else {
                field.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', toggleBpjsField);
    </script>
</x-guest-layout>