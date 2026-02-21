<!DOCTYPE html>
<html>
<head>
    <title>Display Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

    <div class="h-screen flex flex-col justify-center items-center">

        <h1 class="text-4xl font-bold mb-10">
            ANTRIAN KLINIK
        </h1>

        <div class="mb-12 text-center">
            <h2 class="text-2xl mb-4">Sedang Dipanggil</h2>

            <div id="current-number" class="text-8xl font-bold text-green-400">
                {{ $current ? $current->queue_number : '-' }}
            </div>
        </div>

        <div class="w-1/2">
            <h2 class="text-xl mb-4 text-center">Antrian Berikutnya</h2>

            <div id="next-queues" class="grid grid-cols-5 gap-4 text-center text-3xl">
                @foreach($next as $queue)
                    <div class="bg-gray-800 p-4 rounded">
                        {{ $queue->queue_number }}
                    </div>
                @endforeach
            </div>
        </div>

    </div>

<script>
let lastNumber = document.getElementById('current-number').innerText;

setInterval(() => {
    fetch('/display-data')
        .then(response => response.json())
        .then(data => {

            // Update current number
            if (data.current && data.current.queue_number != lastNumber) {

                document.getElementById('current-number').innerText = data.current.queue_number;

                // Animasi
                document.getElementById('current-number').classList.add('animate-pulse');

                // Suara beep sederhana
                let audio = new Audio('https://www.soundjay.com/buttons/sounds/button-3.mp3');
                audio.play();

                lastNumber = data.current.queue_number;
            }

            // Update next queues
            let nextContainer = document.getElementById('next-queues');
            nextContainer.innerHTML = '';

            data.next.forEach(queue => {
                nextContainer.innerHTML += `
                    <div class="bg-gray-800 p-4 rounded">
                        ${queue.queue_number}
                    </div>
                `;
            });

        });

}, 3000); // cek tiap 3 detik
</script>

</body>
</html>
