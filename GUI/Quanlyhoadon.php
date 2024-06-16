<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <h1>QUẢN LÍ HÓA ĐƠN </h1>
    <style>
        /* Google Font Import */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            button {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Management</h1>
        <form id="orderForm" method="post" action="add_order.php">
            <div class="form-group">
                <label for="orderID">Order ID</label>
                <input type="text" id="orderID" name="orderID" required>
            </div>
            <div class="form-group">
                <label for="customerName">Customer Name</label>
                <input type="text" id="customerName" name="customerName" required>
            </div>
            <div class="form-group">
                <label for="product">Product</label>
                <input type="text" id="product" name="product" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="orderDate">Order Date</label>
                <input type="date" id="orderDate" name="orderDate" required>
            </div>
            <button type="submit">Submit Order</button>
        </form>
        
        <form id="searchForm" method="get" action="search_order.php" style="margin-top: 20px;">
            <div class="form-group">
                <label for="search">Search Orders</label>
                <input type="text" id="search" name="search" required>
            </div>
            <button type="submit">Search</button>
        </form>
    </div>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "DONHANG";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MADONHANG = $_POST['MADONHANG'];
    $MAHANG = $_POST['MAHANG'];
    $TENKHACHHANG = $_POST['TENKHACHHANG'];
    $SOLUONG= $_POST['SOLUONG'];
    $DIACHIHANG = $_POST['DIACHIHANG'];
    $TRANGTHAI = $_POST['TRANGTHAI'];

    $sql = "INSERT INTO orders (MADONHANG, MAHANG, TENKHACHHANG, SOLUONG, DIACHIDONHANG, TRANGTHAI) VALUES ('$MADONHANG', '$MAHANG', '$TENKHACHHANG', '$SOLUONG', '$DIACHIHANG', '$TRANGTHAI')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $orderID = $_POST['orderID'];
    $customerName = $_POST['customerName'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $orderDate = $_POST['orderDate'];

    $sql = "UPDATE orders SET orderID='$orderID', customerName='$customerName', product='$product', quantity='$quantity', price='$price', orderDate='$orderDate' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM orders WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
include 'config.php';

$search = $_GET['search'];
$sql = "SELECT * FROM orders WHERE orderID LIKE '%$search%' OR customerName LIKE '%$search%' OR product LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Order ID: " . $row["orderID"] . " - Customer Name: " . $row["customerName"] . " - Product: " . $row["product"] . " - Quantity: " . $row["quantity"] . " - Price: " . $row["price"] . " - Order Date: " . $row["orderDate"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

</body>
</html>
