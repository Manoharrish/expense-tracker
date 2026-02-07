<?php
include "db.php";

/* ---------- ADD EXPENSE ---------- */
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category = $_POST['category'];

    mysqli_query($conn,
        "INSERT INTO expenses (title, amount, date, category)
         VALUES ('$title', '$amount', '$date', '$category')"
    );
}

/* ---------- CATEGORY FILTER ---------- */
if (isset($_GET['filter_category']) && $_GET['filter_category'] != "") {
    $filter = $_GET['filter_category'];
    $query = "SELECT * FROM expenses WHERE category='$filter'";
} else {
    $query = "SELECT * FROM expenses";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Expense Tracker</h2>

<!-- ADD EXPENSE FORM -->
<form method="POST">
    <input type="text" name="title" placeholder="Expense Name" required>
    <input type="number" step="0.01" name="amount" placeholder="Amount" required>
    <input type="date" name="date" required>

    <select name="category" required>
        <option value="">Category</option>
        <option value="Food">Food</option>
        <option value="Travel">Travel</option>
        <option value="Gym">Gym</option>
        <option value="Shopping">Shopping</option>
        <option value="Other">Other</option>
    </select>

    <button type="submit" name="add">Add Expense</button>
</form>

<!-- FILTER BY CATEGORY -->
<form method="GET">
    <select name="filter_category">
        <option value="">Filter by Category</option>
        <option value="Food">Food</option>
        <option value="Travel">Travel</option>
        <option value="Gym">Gym</option>
        <option value="Shopping">Shopping</option>
        <option value="Other">Other</option>
    </select>

    <button type="submit">Filter</button>
    <a href="index.php">Reset</a>
</form>

<!-- EXPENSE TABLE -->
<table>
<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php
$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total += $row['amount'];

    echo "<tr>
        <td>{$row['title']}</td>
        <td>{$row['category']}</td>
        <td>₹{$row['amount']}</td>
        <td>{$row['date']}</td>
        <td>
            <a href='delete.php?id={$row['id']}'
               onclick=\"return confirm('Delete this expense?')\">
               Delete
            </a>
        </td>
    </tr>";
}
?>
</table>

<div class="total">
    Total Expense: ₹<?php echo $total; ?>
</div>

</div>
</body>
</html>
