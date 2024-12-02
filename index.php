<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredients = $_POST['ingredients'];
    
    $command = escapeshellcmd("python3 main.py " . escapeshellarg($ingredients));
    $output = shell_exec($command);
    
    header('Content-Type: application/json');
    echo $output;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leftover Ingredients Recipe Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h1>Leftover Recipe Finder</h1>
    </header>
    <main>
        <section class="input-section">
            <h2>Enter Your Ingredients</h2>
            <form id="ingredient-form" method="post">
                <input type="text" id="ingredients" name="ingredients" placeholder="Type your ingredients... (comma separated)">
                <button type="button" id="add-ingredient">Generate</button>
            </form>
            <div id="ingredient-list"></div>
        </section>

        <section class="recipe-section">
            <h2>Generated Recipes</h2>
            <div id="recipe-container"></div>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>