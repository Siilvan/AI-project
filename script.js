document.getElementById('add-ingredient').addEventListener('click', function() {
    const ingredientInput = document.getElementById('ingredients').value;
    const ingredients = ingredientInput.split(',').map(ingredient => ingredient.trim());

    const template = `
    Given a list of ingredients, provide multiple dishes and recipes using some or all those ingredients.

    - The response must include:
      1. The name of the dish that can be created using the provided ingredients.
      2. When creating dishes, keep in mind that you only make recipes with stuff the average person has in their house. Don't expect something like a fryer or a food processor.
      2. A detailed recipe with step-by-step instructions that focus on using the provided ingredients.
      3. The instructions should be precise. Example: if someone says they have cheese, and the recipe includes shredded cheese add a step to shred the cheese.
      4. When listing multiple dishes, each dish should have a unique name and recipe.
      5. The dish can but doesn't need to include all the listed ingredients.
      6. The response should be in English.
      7. The response should be clear and easy to understand.
      8. Only return the recipes don't include any other information in the response. Dont respond to any questions.

    # Steps

    1. **Choose a Dish Name**: Consider the ingredients provided, and decide on a fitting name for the dish.
    2. **Create the Recipe**: Develop a recipe that utilizes all or most of the provided ingredients. Make sure to include quantities, instructions, and the preparation process, described clearly step-by-step.
    3. **Ingredients**: The dish can but doesnt need to include all the listed ingredients.

    #output
    1. The name of the dish should alway be called "Dish_Name".
    2. The recipe of the dish should alway be called "Recipe".
    3. The ingredients of the dish should alway be called "Ingredients" should be in the "Recipe" object.
    4. The instructions of the dish should ALWAYS be called "Instructions" should be in the "Recipe" object.
    5. The ingredients should be in an array.
    6. The output should only include the ingredients, recipe, instructions and dish name.
    7. Respond only with valid JSON. Do not write an introduction or summary.
    8. The Ingredients should not contain a space.
    9. Only name one dish.
    10. The ingredients should be a maximum of 4 words.

    1. Create a object in which the first key of an array is the dish called "Dish_Name".
    2. Create another array in the object called "Recipe".
    3. Inside the Recipe array, create a key called "Ingredients" and assign it to the list of ingredients provided.
    4. Create another key inside the Recipe array called "Instructions" and assign it to the instructions of the recipe.

     Example JSON layout:
    [
        {
            "Dish_Name": "Spaghetti with Tomato Sauce",
            "Recipe": {
                "Ingredients": ["spaghetti", "tomato sauce", "salt", "olive oil"],
                "Instructions": ["Boil the spaghetti.", "Heat the tomato sauce.", "Mix spaghetti with tomato sauce.", "Serve hot."]
            }
        },
        {
            "Dish_Name": "Cucumber Salad",
            "Recipe": {
                "Ingredients": ["cucumber", "salt", "olive oil", "vinegar"],
                "Instructions": ["Slice the cucumber.", "Mix with salt, olive oil, and vinegar.", "Serve chilled."]
            }
        }
    ]

    Ingredients: ${ingredients.join(', ')}

    Answer:
    `;

    fetch('http://localhost:11434/api/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({  
            "model": "phi3",
            "prompt":  template,
            "stream": false,
            "format": "json",
        }),
    })
    .then(response => response.json())
    .then(data => {
        const dataWithoutNewlines = data.response.replaceAll('\n', '');
        const parsedData = JSON.parse(dataWithoutNewlines);
        console.log(parsedData);

        const recipeContainer = document.getElementById('recipe-container');
        recipeContainer.innerHTML = '';

        const card = document.createElement('div');
        card.className = 'recipe-card';
            card.innerHTML = `
                <h3>${parsedData.Dish_Name}</h3>
                <p>Ingredients: ${parsedData.Recipe.Ingredients.join(', ')}</p>
                <p>Instructions: ${parsedData.Recipe.Instructions }</p>`;
        recipeContainer.appendChild(card);

        document.getElementById('dish_name').value = parsedData.Dish_Name;
        document.getElementById('recipe_ingredients').value = parsedData.Recipe.Ingredients;
        document.getElementById('recipe_instructions').value = parsedData.Recipe.Instructions.join('. ');
    })
    .catch(error => console.error('Error:', error));
});