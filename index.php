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
    <title>PHP div finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <style>
        .folder-button-container {
            display: flex;
            flex-wrap: wrap;
            padding: 10px 290px 10px 290px;
        }

        .folder-button {
            width: 195px;
            height: 195px;
            margin: 5px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .folder-button:hover {
            background-color: #ddd;
        }

        .search-bar {
            margin: 20px;
            text-align: center;

        }

        .search-bar input {
            width: 300px;
            height: 30px;
            border-radius: 15px;
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 16px;
            text-align: center;
        }

        footer {
            margin-top: 150px;
            bottom: 0;
            width: 100%;
            height: 50px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer a {
            color: #111;
            text-decoration: none;
        }

        footer a:hover {
            color: #333;
        }

        footer p {
            /* her p tagini flex şeklinde kullan */
            flex: 1;
            text-align: center;
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .ko-modal-ıcerik {
            background-color: #fefefe;
            margin: 18% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
            height: 270px;
            padding-left: 20px; 
        }
        .ko-modal-ıcerik > form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .ko-modal-ıcerik > form > *{
            margin: 5px ;
        }
        /* Modal Content/Box */
        .ky-modal-ıcerik {
            background-color: #fefefe;
            margin: 18% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
            height: 200px;
            padding-left: 20px; 
        }
        .ky-modal-ıcerik > form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .ky-modal-ıcerik > form > *{
            margin: 5px ;
        }
        
        hr{
            width: 100%;
            color:rgba(0, 0, 0, 0.4);
        }
        .yanyana{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }
        .yanyana > *{
            margin: 5px;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 15px 15px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .kyclose {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 15px 15px;
        }

        .kyclose:hover,
        .kyclose:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #klasorOlustur{
            width: 100%;
            height: 30px;
            border-radius: 25px;
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 16px;
            text-align: center;
        }
        #klasorYokEt{
            width: 100%;
            height: 30px;
            border-radius: 25px;
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 16px;
            text-align: center;
        }
        .klasor-btn{
            width: 100%;
            height: 30px;
            border-radius: 15px;
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 16px;
            text-align: center;
            margin-top: 10px;

        }
        .klasor-btn:hover{
            background-color: #6d706f;
            color: white;
        }
        #klasorYoket{
            border-radius: 40px;
        }
        #klasorYoket:hover{
            background-color: #6d706f;
            color: white;
            border-radius: 50px;
        }
    </style>


</head>

<body>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Arama yapın">
    </div>
    <div class="folder-button-container">
        <?php
        $klasorler = array_filter(glob('*', GLOB_ONLYDIR), 'is_dir');
        foreach ($klasorler as $klasor) {
            echo "<button class='folder-button' onclick=\"location.href='./$klasor'\">$klasor</button>";
        }
        ?>

        <button id="myBtn" class="folder-button">Klasör Oluştur</button>
        <button id="kyBtn" class="folder-button">Klasör Yok Et</button>

    </div>
    <div id="klasorOlusturModal" class="modal">
        <!-- Modal content -->
        <div class="ko-modal-ıcerik">
            <span class="close">&times;</span>
            <form action="./" method="post">
                <input type="text" id="klasorOlustur" class="mt-5" name="klasorOlustur" placeholder="Klasör İsmi Girin">
                <button class="klasor-btn" type="submit">Klasör Oluştur</button>
                <hr>
                <div class="yanyana">
                    <label for="phpOlsunMu"> PHP dosyası oluşturulsun mu?</label><br>
                    <input type="checkbox" id="phpOlsunMu" name="phpOlsunMu" value="phpOlsunMu">
                </div>
            </form>
        </div>
    </div>
    <div id="klasorYokEtModal" class="modal">
        <!-- Modal content -->
        <div class="ky-modal-ıcerik">
            <span class="kyclose pb-5">&times;</span>
            <form action="./" method="post">
                <input type="text" class="mt-5" id="klasorYokEt" name="klasorYokEt" placeholder="Klasör İsmi Girin">
                <button class="klasor-btn " type="submit">Klasör Yok Et</button>
            </form>
        </div>
    </div>



    <!-- klasör oluşturma script kodları burada -->
    <script>
        // Get the modal
        var modal = document.getElementById("klasorOlusturModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }


        // klasör yok etme script kodları burada
        var kyModal = document.getElementById("klasorYokEtModal");

        // Get the button that opens the modal
        var kybtn = document.getElementById("kyBtn");

        // Get the <span> element that closes the modal
        var kyspan = document.getElementsByClassName("kyclose")[0];

        // When the user clicks on the button, open the modal
        kybtn.onclick = function() {
            kyModal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        kyspan.onclick = function() {
            kyModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == kyModal) {
                kyModal.style.display = "none";
            }
        }
    </script>







    <script>
        var searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("input", function() {
            var filter = searchInput.value.toUpperCase();
            var folders = document.getElementsByClassName("folder-button");
            for (var i = 0; i < folders.length; i++) {
                var folder = folders[i];
                var folderName = folder.innerHTML.toUpperCase();
                if (folderName.indexOf(filter) > -1) {
                    folder.style.display = "";
                } else {
                    folder.style.display = "none";
                }
            }
        });
    </script>

    <footer>
        <p>php klasör bulucu v2.5 / php directory finder v2.5</p>
        <p>Yapımcı: <a href="https://github.com/hamer1818">Hamza ORTATEPE</a></p>
    </footer>
</body>

</html>
