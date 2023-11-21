<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if 'country' GET variable is set
if (isset($_GET['country'])) {
    $country = $_GET['country'];
    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => '%' . $country . '%']);
} else {
    // Default query to select all countries
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . ' is ruled by ' . htmlspecialchars($row['head_of_state'], ENT_QUOTES, 'UTF-8'); ?></li>
<?php endforeach; ?>
</ul>
