<!DOCTYPE html>
<html>
<head>
    <title>PHP div finder</title>
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
            text-align:center;
        }
        footer {
            margin-top:150px;
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

        footer p{
            /* her p tagini flex şeklinde kullan */
            flex: 1;
            text-align: center;
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
    </div>


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
        <p>php klasör bulucu v2.0 / php directory finder v2.0</p>
        <p>Yapımcı: <a href="https://github.com/hamer1818">Hamza ORTATEPE</a></p>
    </footer>
</body>
</html>
