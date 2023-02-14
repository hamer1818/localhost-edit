<!-- form içinden gelen veri ile yönlendirme işlemi yapıyoruz -->

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP KLASÖR BULMA SİSTEMİ V0.1</title>
    <style>
        body{
            background-color: #000;
            color: #fff;
        }
        .form{
            /* ortala */
            margin: 0 auto;
            /* genişlik */
            width: 350px;
            /* yükseklik */
            height: 300px;
            /* arka plan */
            background-color: #000;
            /* kenarlık */
            border: 1px solid #fff;
            /* kenarlık yuvarlağı */
            border-radius: 5px;
            /* içerik */
            padding: 20px;
            /* içerik yuvarlağı */
            border-radius: 5px;
            margin-top: 100px;

        }
        #input{
            width: 90%;
            height: 30px;
            border: 1px solid #fff;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 10px 5px;
            font-size: 15px;
            margin-top: 30px;
        }
        #buton{
            width: 100%;
            height: 30px;
            border: 1px solid #fff;
            border-radius: 5px;
            padding: 5px;
            background-color: #fff;
            color: #000;
            cursor: pointer;
            margin-top: 50px;
        }
        #buton:hover{
            background-color: #000;
            color: #fff;
        }
    </style>
    <script>
        <?php
            if($DurumKodu == 0){
                echo "alert('Lütfen klasör ismi giriniz!')";
            }else if($DurumKodu == 1){
                echo "alert('Klasör bulunamadı!')";
            }else if($DurumKodu == 2){
                echo "alert('Klasör bulundu!')";
            }
        ?>
    </script>
</head>
<body>
    <form action="yonlendir.php" method="post" class="form">
        <h1>PHP KLASÖR BULMA SİSTEMİ V0.1</h1>
        <input type="text" name="klasorIsmi" placeholder="klasor ismi giriniz" id="input" title="htdocs içindeki klasör ismi yazın">
        <input type="submit" value="Gönder" id="buton">
    </form>
</body>
</html>