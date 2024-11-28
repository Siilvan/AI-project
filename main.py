import sys
import json
from langchain_ollama import OllamaLLM
from langchain_core.prompts import ChatPromptTemplate

template = """
Given a list of ingredients, provide multiple dishes and recipes using some or all those ingredients.

- The response must include:
  1. The name of the dish that can be created using the provided ingredients.
  2. When creating dishes, keep in mind that you only make recipes with stuff the average person has in their house. Don't expect something like a fryer or a food processor.
  2. A detailed recipe with step-by-step instructions that focus on using the provided ingredients.
  3. The instructions should be precise. Example: if someone says they have cheese, and the recipe includes shredded cheese add a step to shred the cheese.
  4. When listing multiple dishes, each dish should have a unique name and recipe.
  5. The dish can but doesn't need to include all the listed ingredients.
  6. The response should be in JSON format.
  7. The response should be in English.
  8. The response should be clear and easy to understand.
  9. If listing a dish of which not all the ingredients are provided, make sure to list the dish separately from the dishes that only use the provided ingredients.
  10. Only return the recipes don't include any other information in the response. Dont respond to any questions.


# Steps

1. **Choose a Dish Name**: Consider the ingredients provided, and decide on a fitting name for the dish.
2. **Create the Recipe**: Develop a recipe that utilizes all or most of the provided ingredients. Make sure to include quantities, instructions, and the preparation process, described clearly step-by-step.
3. **Ingredients**: The dish can but doesnt need to include all the listed ingredients.
# Output Format

The response should be formatted in JSON with the following structure:

json
{{
  "dish_name": "Dish Name",
  "recipe": {{
    "ingredients": [
      {{"name": "ingredient 1", "amount": "quantity"}},
      {{"name": "ingredient 2", "amount": "quantity"}}
    ],
    "instructions": [
      "Step 1: Description of step 1...",
      "Step 2: Description of step 2..."
    ]
  }},
}}

Ingredients: {question}

Answer:
"""

model = OllamaLLM(model="llama3")
prompt = ChatPromptTemplate.from_template(template)
chain = prompt | model

def generate_recipes(ingredients):
    question = ', '.join(ingredients)
    result = chain.invoke({"question": question})
    return result

if __name__ == "__main__":
    ingredients = sys.argv[1].split(',')
    recipes = generate_recipes(ingredients)
    print(recipes)