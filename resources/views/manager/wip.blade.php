<!-- resources/views/recipes/create.blade.php -->
@extends('manager.layout')

@section('main_content')
<div>
    <h1>Work In Progress</h1>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Resep Baru</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/recipes') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Resep:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <hr>
                        <div id="ingredients">
                            <div class="form-group">
                                <label for="ingredient_name">Nama Bahan:</label>
                                <input type="text" class="form-control" id="ingredient_name" name="ingredients[0][name]" required>
                            </div>
                            <div class="form-group">
                                <label for="ingredient_weight">Berat Bahan:</label>
                                <input type="number" class="form-control" id="ingredient_weight" name="ingredients[0][weight]" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addIngredient()">Tambah Bahan</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let ingredientIndex = 1;

    function addIngredient() {
        const ingredientsDiv = document.getElementById('ingredients');

        const ingredientDiv = document.createElement('div');
        ingredientDiv.classList.add('form-group');

        const nameLabel = document.createElement('label');
        nameLabel.setAttribute('for', 'ingredient_name_' + ingredientIndex);
        nameLabel.textContent = 'Nama Bahan:';

        const nameInput = document.createElement('input');
        nameInput.setAttribute('type', 'text');
        nameInput.classList.add('form-control');
        nameInput.setAttribute('id', 'ingredient_name_' + ingredientIndex);
        nameInput.setAttribute('name', 'ingredients[' + ingredientIndex + '][name]');
        nameInput.required = true;

        const weightLabel = document.createElement('label');
        weightLabel.setAttribute('for', 'ingredient_weight_' + ingredientIndex);
        weightLabel.textContent = 'Berat Bahan:';

        const weightInput = document.createElement('input');
        weightInput.setAttribute('type', 'number');
        weightInput.classList.add('form-control');
        weightInput.setAttribute('id', 'ingredient_weight_' + ingredientIndex);
        weightInput.setAttribute('name', 'ingredients[' + ingredientIndex + '][weight]');
        weightInput.required = true;

        ingredientDiv.appendChild(nameLabel);
        ingredientDiv.appendChild(nameInput);
        ingredientDiv.appendChild(weightLabel);
        ingredientDiv.appendChild(weightInput);

        ingredientsDiv.appendChild(ingredientDiv);

        ingredientIndex++;
    }
</script>
@endsection
