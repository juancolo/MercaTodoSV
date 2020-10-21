@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        <div id="app">
            <hr>
            <input type="submit" value="Crear Categoría" class="btn btn-primary float-right">
            <form action="">
                <h2>Crear Categoría</h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="name" class="form-control" type="text" name="name" id="name">
                    <label for="type">Slug</label>
                    <input v-model="generateSlug" class="form-control" type="text" name="slug" id="slug" readonly>
                    <label for="slug">Type</label>
                    <input class="form-control" type="text" name="type" id="type">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                </div>
            </form>
            <hr>
        </div>
    </div>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                name: 'Juan Colorado'
            },
            computed: {
                generateSlug : function (){
                    var char = {
                        "á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
                        "Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
                        "ñ":"n", "Ñ":"N", " ":"-", "_":"-", ".":"-",
                    }
                    var expr = /[áéíóúÁÉÍÓÚ_.]/g;

                    return this.name.trim().toLowerCase().replace(expr, function (e){
                        return char[e]
                    })
                }
            }
        });
    </script>
@endsection
