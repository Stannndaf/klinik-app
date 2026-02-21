<!DOCTYPE html>
<html>
<head>
<title>Kiosk Klinik</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
@vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

<div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl p-12">

    {{-- 🔴 ERROR DISPLAY --}}
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 mb-6 rounded-xl text-center text-xl">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500 text-white p-4 mb-6 rounded-xl text-center text-xl">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- STEP 1 --}}
    <div id="step1" class="text-center">
        <h1 class="text-4xl font-bold mb-10">
            Pilih Jenis Pasien
        </h1>

        <div class="flex justify-center gap-10">
            <button onclick="goToStep(2,'umum')"
                class="bg-blue-600 text-white px-16 py-8 rounded-2xl text-3xl font-bold hover:bg-blue-700">
                UMUM
            </button>

            <button onclick="goToStep(2,'bpjs')"
                class="bg-green-600 text-white px-16 py-8 rounded-2xl text-3xl font-bold hover:bg-green-700">
                BPJS
            </button>
        </div>
    </div>

    {{-- STEP 2 --}}
    <div id="step2" class="hidden text-center">
        <h1 id="identifierTitle" class="text-3xl font-bold mb-8"></h1>

        <input type="text"
               id="identifierInput"
               class="w-full border-2 border-gray-300 rounded-xl p-6 text-2xl text-center mb-8">

        <button onclick="goToStep(3)"
            class="bg-blue-600 text-white px-12 py-4 rounded-xl text-2xl font-semibold">
            Lanjut
        </button>

        <div class="mt-6">
            <button onclick="goToStep(1)"
                class="text-gray-500 underline text-lg">
                Kembali
            </button>
        </div>
    </div>

    {{-- STEP 3 --}}
    <div id="step3" class="hidden text-center">
        <h1 class="text-3xl font-bold mb-8">
            Pilih Poli
        </h1>

        <div class="grid grid-cols-2 gap-6">
            @foreach($polis as $poli)
                <button onclick="selectPoli({{ $poli->id }}, '{{ $poli->name }}')"
                    class="bg-blue-500 text-white py-6 rounded-xl text-xl font-semibold hover:bg-blue-600">
                    {{ $poli->name }}
                </button>
            @endforeach
        </div>

        <div class="mt-8">
            <button onclick="goToStep(2)"
                class="text-gray-500 underline text-lg">
                Kembali
            </button>
        </div>
    </div>

    {{-- STEP 4 --}}
    <div id="step4" class="hidden text-center">
        <h1 class="text-3xl font-bold mb-8">
            Pilih Dokter
        </h1>

        <div id="doctorList" class="grid grid-cols-2 gap-6">
        </div>

        <div class="mt-8">
            <button onclick="goToStep(3)"
                class="text-gray-500 underline text-lg">
                Kembali
            </button>
        </div>
    </div>

    {{-- STEP 5 --}}
    <div id="step5" class="hidden text-center">
        <h1 class="text-3xl font-bold mb-6">
            Konfirmasi
        </h1>

        <p class="text-xl mb-2" id="confirmType"></p>
        <p class="text-xl mb-2" id="confirmPoli"></p>
        <p class="text-xl mb-6" id="confirmDoctor"></p>

        <form method="POST" action="{{ route('kiosk.process') }}">
            @csrf
            <input type="hidden" name="patient_type" id="formType">
            <input type="hidden" name="identifier" id="formIdentifier">
            <input type="hidden" name="poli_id" id="formPoli">
            <input type="hidden" name="doctor_id" id="formDoctor">

            <button class="bg-blue-600 text-white px-16 py-6 rounded-xl text-2xl font-bold">
                AMBIL NOMOR
            </button>
        </form>

        <div class="mt-8">
            <button onclick="goToStep(4)"
                class="text-gray-500 underline text-lg">
                Kembali
            </button>
        </div>
    </div>

</div>

<script>
let selectedType = '';
let selectedPoli = '';
let selectedDoctor = '';
let selectedPoliName = '';
let selectedDoctorName = '';

function goToStep(step, type = null) {
    document.querySelectorAll('[id^="step"]').forEach(el => el.classList.add('hidden'));

    if(type){
        selectedType = type;
        document.getElementById('identifierTitle').innerText =
            type === 'bpjs' ? 'Masukkan Nomor BPJS' : 'Masukkan Kode Pasien';
    }

    document.getElementById('step' + step).classList.remove('hidden');
}

function selectPoli(id, name){
    selectedPoli = id;
    selectedPoliName = name;
    goToStep(4);

    fetch('/api/doctors/' + id)
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(doc => {
                html += `
                <button onclick="selectDoctor(${doc.id},'${doc.name}')"
                    class="bg-green-500 text-white py-6 rounded-xl text-xl font-semibold hover:bg-green-600">
                    ${doc.name}
                </button>`;
            });
            document.getElementById('doctorList').innerHTML = html;
        });
}

function selectDoctor(id, name){
    selectedDoctor = id;
    selectedDoctorName = name;

    document.getElementById('formType').value = selectedType;
    document.getElementById('formIdentifier').value =
        document.getElementById('identifierInput').value;
    document.getElementById('formPoli').value = selectedPoli;
    document.getElementById('formDoctor').value = selectedDoctor;

    document.getElementById('confirmType').innerText = "Jenis: " + selectedType.toUpperCase();
    document.getElementById('confirmPoli').innerText = "Poli: " + selectedPoliName;
    document.getElementById('confirmDoctor').innerText = "Dokter: " + selectedDoctorName;

    goToStep(5);
}
</script>

</body>
</html>