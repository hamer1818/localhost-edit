<?php

// klasorOlustur inputuna girilen değeri alıyoruz
$olusturulanKlasorAdi = @$_POST["klasorOlustur"];

// eğer klasorOlustur inputu boş değilse

if ($olusturulanKlasorAdi == "") {
    if (isset($_POST["klasorOlustur"]))
    echo "<script>alert('Klasör adı boş olamaz!');</script>";
} elseif (!is_dir($olusturulanKlasorAdi)) {
    mkdir($olusturulanKlasorAdi);
    echo "<script>alert('$olusturulanKlasorAdi isminde klasör oluşturuldu');</script>";

} else {
    echo "<script>alert('Klasör zaten mevcut: $olusturulanKlasorAdi');</script>";
}


if (isset($_POST["phpOlsunMu"])){
    // olusturulanKlasorAdi değişkenindeki klasörün içine index.php dosyası oluşturuyoruz
    $dosya = fopen("$olusturulanKlasorAdi/index.php", "w");
    // index.php dosyasının içine yazılacak kodları bir txt dosyasını okuyarak çekiyoruz.
    $kod = fopen("phpOlusturOrnek.txt", "r");
    $kod = fread($kod, filesize("phpOlusturOrnek.txt"));
    // echo $kod;
    // index.php dosyasının içine kodları yazıyoruz
    fwrite($dosya, $kod);
    // index.php dosyasını kapatıyoruz
    fclose($dosya);
    echo "<script>alert('index.php dosyası oluşturuldu');</script>";

}

// klasorYokEt inputuna girilen değeri alıyoruz
$yokEdilenKlasorAdi = @$_POST["klasorYokEt"];

// eğer klasorYokEt inputu boş değilse
if ($yokEdilenKlasorAdi == "") {
    if (isset($_POST["klasorYokEt"]))
    echo "<script>alert('Klasör adı boş olamaz!');</script>";
} elseif (is_dir($yokEdilenKlasorAdi)) {
    // eğer klasör boş değilse önce içindeki dosyaları silip sonra klasörü siliyoruz
    $dosyalar = glob($yokEdilenKlasorAdi . "/*");
    foreach ($dosyalar as $dosya) {
        unlink($dosya);
    }

    rmdir($yokEdilenKlasorAdi);
    echo "<script>alert('$yokEdilenKlasorAdi isminde klasör yok edildi');</script>";
} else {
    echo "<script>alert('Klasör zaten mevcut değil: $yokEdilenKlasorAdi');</script>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>XAMPP Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer components {
            .folder-card {
                @apply w-56 h-56 m-3 bg-white rounded-xl shadow-md hover:shadow-lg
                       transition-all duration-200 flex flex-col items-center justify-center
                       cursor-pointer border border-gray-100;
            }
            .modal-content {
                @apply bg-white rounded-lg shadow-xl p-6 w-96 mx-auto mt-32;
            }
            .input-field {
                @apply w-full px-4 py-2 rounded-lg border border-gray-200
                       focus:outline-none focus:ring-2 focus:ring-blue-400;
            }
            .btn {
                @apply px-6 py-2 bg-gray-800 text-white rounded-lg
                       hover:bg-gray-700 transition-colors duration-200;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Search Bar -->
        <div class="my-8">
            <input type="text" 
                   id="searchInput" 
                   class="input-field max-w-md mx-auto block"
                   placeholder="Search projects...">
        </div>

        <!-- Folder Grid -->
        <div class="flex flex-wrap justify-center p-4">
            <?php
            $klasorler = array_filter(glob('*', GLOB_ONLYDIR), 'is_dir');
            foreach ($klasorler as $klasor) {
                echo "<a href='./{$klasor}' class='folder-card'>
                        <div class='text-center'>
                            <svg class='w-16 h-16 mb-3 mx-auto text-gray-600' fill='currentColor' viewBox='0 0 20 20'>
                                <path d='M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z'></path>
                            </svg>
                            <span class='text-gray-700 font-medium'>{$klasor}</span>
                        </div>
                    </a>";
            }
            ?>
            <button id="myBtn" class="folder-card">
                <svg class="w-16 h-16 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-gray-700 font-medium">Create Project</span>
            </button>
            <button id="kyBtn" class="folder-card">
                <svg class="w-16 h-16 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span class="text-gray-700 font-medium">Delete Project</span>
            </button>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div id="klasorOlusturModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Create New Project</h3>
                <button class="close text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form action="./" method="post">
                <input type="text" 
                       name="klasorOlustur" 
                       class="input-field mb-4"
                       placeholder="Project Name">
                <div class="flex items-center gap-2 mb-4">
                    <input type="checkbox" 
                           id="phpOlsunMu" 
                           name="phpOlsunMu"
                           class="rounded text-blue-500">
                    <label>Include PHP file?</label>
                </div>
                <button type="submit" class="btn w-full">Create Project</button>
            </form>
        </div>
    </div>

    <!-- Delete Project Modal -->
    <div id="klasorYokEtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Delete Project</h3>
                <button class="kyclose text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form action="./" method="post">
                <input type="text" 
                       name="klasorYokEt" 
                       class="input-field mb-4"
                       placeholder="Project Name">
                <button type="submit" class="btn w-full bg-red-600 hover:bg-red-700">Delete Project</button>
            </form>
        </div>
    </div>

    <footer class="fixed bottom-0 w-full py-4 bg-white border-t">
        <div class="container mx-auto text-center text-gray-600">
            <p>XAMPP Project Manager v3.0</p>
            <p>Created by: <a href="https://github.com/hamer1818" class="text-blue-500 hover:text-blue-700">Hamza ORTATEPE</a></p>
        </div>
    </footer>

    <script>
        // Modal Logic
        const modal = document.getElementById("klasorOlusturModal");
        const kyModal = document.getElementById("klasorYokEtModal");
        const btn = document.getElementById("myBtn");
        const kybtn = document.getElementById("kyBtn");
        const closeBtn = document.querySelector(".close");
        const kyCloseBtn = document.querySelector(".kyclose");

        function toggleModal(modalEl, display) {
            modalEl.classList.toggle("hidden", !display);
        }

        btn.onclick = () => toggleModal(modal, true);
        kybtn.onclick = () => toggleModal(kyModal, true);
        closeBtn.onclick = () => toggleModal(modal, false);
        kyCloseBtn.onclick = () => toggleModal(kyModal, false);

        window.onclick = (e) => {
            if (e.target == modal) toggleModal(modal, false);
            if (e.target == kyModal) toggleModal(kyModal, false);
        }

        // Search Logic
        document.getElementById("searchInput").addEventListener("input", function(e) {
            const filter = e.target.value.toLowerCase();
            document.querySelectorAll(".folder-card").forEach(folder => {
                const text = folder.textContent.toLowerCase();
                folder.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>
