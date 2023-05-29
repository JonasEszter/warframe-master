@extends("layouts.public")
@section("content")

    <div class="container">
        <div class="row" id="characters-holder">
            <div class="col-lg-3 bg-info text-center" v-for="warframe in warframes">
                <h3 class="text-light" v-text="warframe.CharName"></h3>

                <a :href="'/warframe/'+warframe.CharacterID">
                    <img v-bind:src="warframe.Image" 
                    class="img-thumbnail img-fluid fit-image">
                </a>
            </div>
        </div>
    </div>

    <script type="module" src="{{URL::asset('js/builds.js')}}"></script>
@endsection