<!DOCTYPE html>
<html>
<head>
    <title>Display Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

<div class="p-10">

    <h1 class="text-4xl font-bold text-center mb-10">
        SISTEM ANTRIAN KLINIK
    </h1>

    <!-- RUANG VITAL -->
    <div class="bg-red-600 p-6 rounded mb-8">
        <h2 class="text-2xl font-bold mb-2">🩺 RUANG VITAL</h2>
        <p id="vital" class="text-5xl font-bold">-</p>
    </div>

    <!-- POLI -->
    <div id="poliContainer" class="grid grid-cols-3 gap-6"></div>

</div>

<script>
async function loadDisplay() {
    const response = await fetch("{{ route('display.data') }}");
    const data = await response.json();

    // Update Vital
    document.getElementById('vital').innerText =
        data.vital ?? '-';

    // Update Poli
    const container = document.getElementById('poliContainer');
    container.innerHTML = '';

    data.polis.forEach(p => {

        let waitingHTML = '';
        p.waiting.forEach(w => {
            waitingHTML += `<span class="bg-gray-600 px-3 py-1 rounded mr-2">${w}</span>`;
        });

        container.innerHTML += `
            <div class="bg-gray-800 p-6 rounded">
                <h2 class="text-2xl font-bold mb-4 text-yellow-400">
                    ${p.poli}
                </h2>

                <div class="mb-4">
                    <p class="text-lg">Sedang Dipanggil:</p>
                    <p class="text-4xl font-bold text-green-400">
                        ${p.called ?? '-'}
                    </p>
                </div>

                <div>
                    <p class="text-lg mb-2">Waiting:</p>
                    ${waitingHTML}
                </div>
            </div>
        `;
    });
}

// Load pertama
loadDisplay();

// Update tiap 3 detik
setInterval(loadDisplay, 3000);
</script>

</body>
</html>