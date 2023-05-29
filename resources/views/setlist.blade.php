@extends("layouts.public")
@section('content')
<div class="container">
    <div class="row" id="sets-holder">
        <div class="col-lg-3 bg-info text-center" v-for="set in sets">
            <h2 class="text-light" v-text="set.SetName"></h2>
            <h3 class="text-light" v-text="set.CharName"></h3>
            <h4 class="text-light" v-text="'Készítő: ' + set.name"></h4>

            <a :href="'/warframe/'+set.CharacterID + '/' + set.SetID">
                <img v-bind:src="set.Image" 
                class="img-thumbnail img-fluid fit-image">
            </a>
        </div>
    </div>

    <script type="module" src="{{URL::asset('js/sets.js')}}"></script>
</div>
@endsection