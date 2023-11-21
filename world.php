<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$results = []; // Initialize the results array

// Check if a country name is passed in the GET request
if (isset($_GET['country']) && trim($_GET['country']) != '') {
    $country = $_GET['country'];

    // Check if the context is for cities
    if (isset($_GET['context']) && $_GET['context'] === 'cities') {
      // SQL JOIN to get cities for the specified country
      $stmt = $conn->prepare(
          "SELECT ci.name, ci.district, ci.population 
           FROM cities ci
           JOIN countries co ON ci.country_code = co.code
           WHERE co.name LIKE :country"
      );
      $stmt->bindValue(':country', '%' . $country . '%');
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // Output the table for cities
      echo '<table>';
      echo '<tr><th>Name</th><th>District</th><th>Population</th></tr>';
      foreach ($results as $row) {
          echo '<tr>';
          echo '<td>' . htmlspecialchars($row['name']) . '</td>';
          echo '<td>' . htmlspecialchars($row['district']) . '</td>';
          echo '<td>' . htmlspecialchars($row['population']) . '</td>';
          echo '</tr>';
      }
      echo '</table>';
  } else {

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', '%' . $country . '%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the table for countries
    echo '<table>';
    echo '<tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['continent']) . '</td>';
        echo '<td>' . htmlspecialchars($row['independence_year']) . '</td>';
        echo '<td>' . htmlspecialchars($row['head_of_state']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
  }
} else {
    // If no country is specified, select all countries
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    // Output the table for all countries
    echo '<table>';
    echo '<tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['continent']) . '</td>';
        echo '<td>' . htmlspecialchars($row['independence_year']) . '</td>';
        echo '<td>' . htmlspecialchars($row['head_of_state']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
