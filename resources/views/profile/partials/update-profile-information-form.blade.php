<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nama (BISA DIUBAH) -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- NIK (READONLY) -->
        <div>
            <x-input-label value="NIK" />
            <x-text-input type="text"
                class="mt-1 block w-full bg-gray-100"
                :value="$user->nik"
                readonly />
        </div>

        <!-- Jenis Pasien -->
        <div>
            <x-input-label value="Jenis Pasien" />
            <x-text-input type="text"
                class="mt-1 block w-full bg-gray-100"
                :value="strtoupper($user->insurance_type)"
                readonly />
        </div>

        <!-- Nomor BPJS (READONLY) -->
        @if($user->insurance_type === 'bpjs')
            <div>
                <x-input-label value="Nomor BPJS" />
                <x-text-input type="text"
                    class="mt-1 block w-full bg-gray-100"
                    :value="$user->bpjs_number"
                    readonly />
            </div>
        @endif

        <!-- No HP (BISA DIUBAH) -->
        <div>
            <x-input-label for="phone" value="No HP" />
            <x-text-input id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)" />
        </div>

        <!-- Tanggal Lahir (READONLY) -->
        <div>
            <x-input-label value="Tanggal Lahir" />
            <x-text-input type="date"
                class="mt-1 block w-full bg-gray-100"
                :value="$user->birth_date"
                readonly />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>