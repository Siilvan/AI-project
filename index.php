<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Cook</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $dish_name = $data['dish_name'];
    $recipe_ingredients = $data['recipe_ingredients'];
    $recipe_instructions = $data['recipe_instructions'];

    $servername = "localhost";
    $username = "bit_academy";
    $password = "bit_academy"; 
    $dbname = "recipes_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO recipes (dish_name, ingredients, instructions) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $dish_name, $recipe_ingredients, $recipe_instructions);

    if ($stmt->execute()) {
        echo "Recipe saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
<body>
    <header class="header">
        <h1>AI Cook</h1>
    </header>
    <main>
        <section class="input-section">
            <h2>Select Your Ingredients</h2>
            <form id="ingredient-form" method="post">
                <div id="ingredient-list">
                    <div class="ingredient-category">
                        <label for="vegetables">Vegetables</label>
                        <select id="vegetables" multiple>
                            <option value="tomato">Tomato</option>
                            <option value="onion">Onion</option>
                            <option value="garlic">Garlic</option>
                            <option value="pepper">Pepper</option>
                            <option value="carrot">Carrot</option>
                            <option value="broccoli">Broccoli</option>
                            <option value="spinach">Spinach</option>
                            <option value="lettuce">Lettuce</option>
                            <option value="cucumber">Cucumber</option>
                            <option value="zucchini">Zucchini</option>
                        </select>
                    </div>
                    <div class="ingredient-category">
                        <label for="proteins">Proteins</label>
                        <select id="proteins" multiple>
                            <option value="chicken">Chicken</option>
                            <option value="beef">Beef</option>
                            <option value="pork">Pork</option>
                            <option value="tofu">Tofu</option>
                            <option value="beans">Beans</option>
                            <option value="fish">Fish</option>
                            <option value="shrimp">Shrimp</option>
                            <option value="eggs">Eggs</option>
                        </select>
                    </div>
                    <div class="ingredient-category">
                        <label for="dairy">Dairy</label>
                        <select id="dairy" multiple>
                            <option value="cheese">Cheese</option>
                            <option value="milk">Milk</option>
                            <option value="yogurt">Yogurt</option>
                            <option value="butter">Butter</option>
                            <option value="cream">Cream</option>
                            <option value="sour cream">Sour Cream</option>
                        </select>
                    </div>
                    <div class="ingredient-category">
                        <label for="spices">Spices</label>
                        <select id="spices" multiple>
                            <option value="salt">Salt</option>
                            <option value="pepper">Pepper</option>
                            <option value="cumin">Cumin</option>
                            <option value="paprika">Paprika</option>
                            <option value="oregano">Oregano</option>
                            <option value="basil">Basil</option>
                            <option value="thyme">Thyme</option>
                            <option value="cinnamon">Cinnamon</option>
                        </select>
                    </div>
                    <div class="ingredient-category">
                        <label for="oils">Oils</label>
                        <select id="oils" multiple>
                            <option value="olive oil">Olive Oil</option>
                            <option value="vegetable oil">Vegetable Oil</option>
                            <option value="coconut oil">Coconut Oil</option>
                            <option value="sesame oil">Sesame Oil</option>
                            <option value="canola oil">Canola Oil</option>
                        </select>
                    </div>
                    <div class="ingredient-category">
                        <label for="grains">Grains</label>
                        <select id="grains" multiple>
                            <option value="rice">Rice</option>
                            <option value="pasta">Pasta</option>
                            <option value="quinoa">Quinoa</option>
                            <option value="bread">Bread</option>
                            <option value="oats">Oats</option>
                        </select>
                    </div>
                </div>
                <button type="button" id="add-ingredient">Generate</button>
            </form>
        </section>

        <section class="recipe-section">
            <h2>Generated Recipes</h2>
            <div id="recipe-container"></div>
        </section>

        <section class="save-recipe-section">
            <h2>Save Recipe</h2>
            <button id="save-recipe">Save Recipe</button>
            <input type="hidden" id="dish_name">
            <input type="hidden" id="recipe_ingredients">
            <input type="hidden" id="recipe_instructions">
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html> 