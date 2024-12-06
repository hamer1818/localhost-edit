<?php
// Folder creation logic remains similar but update path handling
$olusturulanKlasorAdi = @$_POST["klasorOlustur"];

if ($olusturulanKlasorAdi == "") {
    if (isset($_POST["klasorOlustur"]))
        echo "<script>alert('Folder name cannot be empty!');</script>";
} elseif (!is_dir($olusturulanKlasorAdi)) {
    mkdir($olusturulanKlasorAdi);
    // Create virtual host config for Laragon
    $vhostContent = "
    <VirtualHost *:80>
        ServerName {$olusturulanKlasorAdi}.test
        DocumentRoot \"%LARAGON_ROOT%/www/{$olusturulanKlasorAdi}\"
    </VirtualHost>";
    // Save to Laragon's auto-created vhosts
    file_put_contents("C:/laragon/etc/apache2/sites-enabled/{$olusturulanKlasorAdi}.test.conf", $vhostContent);
    echo "<script>alert('Folder created: {$olusturulanKlasorAdi}.test');</script>";
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
    <title>Laragon Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer components {
            .folder-button {
                @apply w-48 h-48 m-2 bg-gray-50 border border-gray-200 rounded-xl 
                       hover:bg-gray-100 transition-all duration-200 ease-in-out
                       flex items-center justify-center text-gray-700 cursor-pointer;
            }
            .modal-content {
                @apply bg-white rounded-lg shadow-xl p-6 w-96 mx-auto mt-32;
            }
            .input-field {
                @apply w-full px-4 py-2 rounded-full border border-gray-300 
                       focus:outline-none focus:ring-2 focus:ring-blue-400;
            }
            .button {
                @apply px-6 py-2 bg-blue-500 text-white rounded-full
                       hover:bg-blue-600 transition-colors duration-200;
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
                   class="input-field mx-auto block"
                   placeholder="Search projects...">
        </div>

        <!-- Folder Grid -->
        <div class="flex flex-wrap justify-center gap-4 p-4">
            <?php
            $klasorler = array_filter(glob('*', GLOB_ONLYDIR), 'is_dir');
            foreach ($klasorler as $klasor) {
                echo "<a href='http://{$klasor}.test' class='folder-button'>
                        <div>
                            <svg class='w-12 h-12 mb-2 mx-auto' fill='currentColor' viewBox='0 0 20 20'>
                                <path d='M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z'></path>
                            </svg>
                            <span>{$klasor}.test</span>
                        </div>
                    </a>";
            }
            ?>
            <button id="myBtn" class="folder-button">
                <div>
                    <svg class="w-12 h-12 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Create Project</span>
                </div>
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
                <button type="submit" class="button w-full">Create Project</button>
            </form>
        </div>
    </div>

    <footer class="fixed bottom-0 w-full py-4 bg-white border-t">
        <div class="container mx-auto text-center text-gray-600">
            <p>Laragon Project Manager v3.0</p>
            <p>Created by: <a href="https://github.com/hamer1818" class="text-blue-500 hover:text-blue-700">Hamza ORTATEPE</a></p>
        </div>
    </footer>

    <script>
        // Modal Logic
        const modal = document.getElementById("klasorOlusturModal");
        const btn = document.getElementById("myBtn");
        const closeBtn = document.querySelector(".close");

        btn.onclick = () => modal.classList.remove("hidden");
        closeBtn.onclick = () => modal.classList.add("hidden");
        window.onclick = (e) => {
            if (e.target == modal) modal.classList.add("hidden");
        }

        // Search Logic
        document.getElementById("searchInput").addEventListener("input", function(e) {
            const filter = e.target.value.toLowerCase();
            document.querySelectorAll(".folder-button").forEach(folder => {
                const text = folder.textContent.toLowerCase();
                folder.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>