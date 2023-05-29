@extends("layouts.public")
@section('content')
<div class="container" id="app">
    <h1>Feladatok</h1>

    <div v-for="pd in progressData">
        <label>
            <b v-text="pd.ItemName"></b>
            <input type="checkbox" @change="checkProgress"
            :checked="pd.ProgressID != null"
            :itemid="pd.ItemID"
            class="progress-check">
        </label>
    </div>

    <button v-if="nextLevel" type="button" @click="goToNextLevel"
    class="btn btn-success">Következő szint</button>

    <script type="module" src="{{URL::asset('js/todo.js')}}"></script>
</div>
@endsection