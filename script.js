document.getElementById('add-ingredient').addEventListener('click', function() {
    const ingredientInput = document.getElementById('ingredient-input').value;
    const ingredients = ingredientInput.split(',').map(ingredient => ingredient.trim());

    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'ingredients=' + encodeURIComponent(ingredients.join(',')),
    })
    .then(response => response.json())
    .then(data => {

        console.log(data);

        const recipeContainer = document.getElementById('recipe-container');
        recipeContainer.innerHTML = '';

        data.forEach(recipe => {
            const card = document.createElement('div');
            card.className = 'recipe-card';
            card.innerHTML = `
                <h3>${recipe.dish_name}</h3>
                <p>Ingredients: ${recipe.recipe.ingredients.map(ing => `${ing.name} (${ing.amount})`).join(', ')}</p>
                <p>Instructions: ${recipe.recipe.instructions.join(' ')}</p>
            `;
            recipeContainer.appendChild(card);
        });
    })
    .catch(error => console.error('Error:', error));
});