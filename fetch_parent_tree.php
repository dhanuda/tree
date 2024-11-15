<?php
header('Content-Type: text/html');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "treeview";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$proj_id = intval($_GET['proj_id']);

// Function to generate HTML for the accordion
function fetchChildren($parentId, $conn, $level = 0) {
    $sql = "SELECT * FROM project_milestone WHERE proj_id = $parentId";
    $result = $conn->query($sql);

    $html = '';
    $cardCounter = 0;

    while ($row = $result->fetch_assoc()) {
        $cardCounter++;
        $accordionId = 'accordion' . $row['id'];
        $collapseId = 'collapse' . $row['id'];

        $html .= '<div class="card">';
        $html .= '<div class="card-header" id="heading' . $row['id'] . '">';
        $html .= '<h5 class="mb-0">';
        $html .= '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#' . $collapseId . '" aria-expanded="true" aria-controls="' . $collapseId . '">';
        $html .= htmlspecialchars($row['subject']);
        $html .= '</button></h5></div>';
        $html .= '<div id="' . $collapseId . '" class="collapse' . ($level === 0 ? ' show' : '') . '" aria-labelledby="heading' . $row['id'] . '" data-parent="#accordionParentTree">';
        $html .= '<div class="card-body">';
        $html .= htmlspecialchars($row['description']);

        // Fetch and display children
        $html .= fetchChildren($row['id'], $conn, $level + 1);
        
        $html .= '</div></div></div>';
    }

    return $html;
}

// Generate accordion content
$accordionHtml = fetchChildren($proj_id, $conn);

// Output the HTML
echo $accordionHtml;

// Close connection
$conn->close();
?>
