<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت محصولات</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php

function getProducts() {
    $api_url = 'https://fakestoreapi.com/products';
    $products_json = file_get_contents($api_url);
    return json_decode($products_json, true);
}

function displayProducts($products) {
    if (!empty($products)) {
        echo "<h2>لیست محصولات</h2>";
        echo "<table>";
        echo "<tr><th>شناسه</th><th>نام</th><th>قیمت</th><th>عملیات</th></tr>";
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['id'] . "</td>";
            echo "<td>" . $product['title'] . "</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "<td><a href='crud.php?action=edit&id=" . $product['id'] . "'>ویرایش</a> | <a href='crud.php?action=delete&id=" . $product['id'] . "'>حذف</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "محصولی یافت نشد.";
    }
}


function addProduct($title, $price) {
    $api_url = 'https://fakestoreapi.com/products';
    $data = array(
        'title' => $title,
        'price' => $price
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);
    return $result !== false;
}


function deleteProduct($product_id) {
    $api_url = "https://fakestoreapi.com/products/$product_id";
    $options = array(
        'http' => array(
            'method' => 'DELETE'
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);
    return $result !== false;
}


function getProductDetails($product_id) {
    $api_url = "https://fakestoreapi.com/products/$product_id";
    $product_json = file_get_contents($api_url);
    return json_decode($product_json, true);
}


function editProduct($product_id, $title, $price) {
    $api_url = "https://fakestoreapi.com/products/$product_id";
    $data = array(
        'title' => $title,
        'price' => $price
    );
    $options = array(
        'http' => array(
            'method' => 'PUT',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);
    return $result !== false;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['add_product'])) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $success = addProduct($title, $price);
        if ($success) {
            echo "<p>محصول با موفقیت اضافه شد.</p>";
        } else {
            echo "<p>خطا در اضافه کردن محصول.</p>";
        }
    }
    
    
    if (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $success = editProduct($product_id, $title, $price);
        if ($success) {
            echo "<p>محصول با موفقیت ویرایش شد.</p>";
        } else {
            echo "<p>خطا در ویرایش محصول.</p>";
        }
    }
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $product_id = $_GET['id'];
    
    if ($action == 'edit') {
        
        $product = getProductDetails($product_id);
        if (!empty($product)) {
            echo "<h2>ویرایش محصول</h2>";
            echo "<form action='crud.php' method='post'>";
            echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
            echo "<label for='title'>نام محصول:</label><br>";
            echo "<input type='text' id='title' name='title' value='" . $product['title'] . "' required><br><br>";
            echo "<label for='price'>قیمت:</label><br>";
            echo "<input type='number' id='price' name='price' value='" . $product['price'] . "' required><br><br>";
            echo "<input type='submit' name='edit_product' value='ثبت ویرایش'>";
            echo "</form>";
        } else {
            echo "<p>محصولی با این شناسه یافت نشد.</p>";
        }
    } elseif ($action == 'delete') {
        
        $success = deleteProduct($product_id);
        if ($success) {
            echo "<p>محصول با موفقیت حذف شد.</p>";
        } else {
            echo "<p>خطا در حذف محصول.</p>";
        }
    }
}


$products = getProducts();
displayProducts($products);

?>

<hr>
<h2>اضافه کردن محصول جدید</h2>
<form action="crud.php" method="post">
    <label for="title">نام محصول:</label><br>
    <input type="text" id="title" name="title" required><br><br>
    
    <label for="price">قیمت:</label><br>
    <input type="number" id="price" name="price" required><br><br>
    
    <input type="submit" name="add_product" value="ثبت">
</form>

</body>
</html>
