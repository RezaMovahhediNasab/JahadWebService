<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>نمایش محصولات</title>
</head>

<body>
    <div id="main">
        <table>
            <?php
            $url = "https://fakestoreapi.com/products";
            $response = file_get_contents($url);
            $values = json_decode($response, true);

            foreach ($values as $value) {
                $img = $value["image"];
                echo "<tr><td>" . "<img src='$img'>" . "</td><td>";
                // echo "".$value["id"] . " ";
                echo $value["title"] . "</br>";
                echo $value["price"] . "$ </br>";
                echo $value["category"] . "</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>