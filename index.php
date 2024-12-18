<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "recipes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dish_name = $_POST['dish_name'];
    $ingredients = $_POST['recipe_ingredients'];
    $instructions = $_POST['recipe_instructions'];

    $sql = "INSERT INTO recipes (dish_name, ingredients, instructions) VALUES ('$dish_name', '$ingredients', '$instructions')";

    if ($conn->query($sql) === TRUE) {
        echo "New recipe saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Cook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h1>AI Cook</h1>
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

        <section class="save-recipe-section">
            <h2>Save Recipe</h2>
            <form method="post">
                <input type="text" name="dish_name" id="dish_name" placeholder="Dish Name" required>
                <textarea name="recipe_ingredients" id="recipe_ingredients" placeholder="Ingredients" required></textarea>
                <textarea name="recipe_instructions" id="recipe_instructions" placeholder="Instructions" required></textarea>
                <button type="submit" name="save-recipe">Save Recipe</button>
            </form>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>