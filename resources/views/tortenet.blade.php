@extends("layouts.public")
@section("content")
<div class="container">
    <h1>Történet</h1>

    <div id="tortenet-holder">
        <!--<div v-for="parent in parents" :key="parent.id">
            <div @click="select(parent.id)" class="timeline">   
            </div>
        </div>-->
        <div id="timeline-wrapper">
            <ul class="nav">
                <li class="step" v-for="date in dates" :key="date.id">
                    <div @click="select(date.id)" class="timeline" v-text="date.name"></div>
                </li>
            </ul>

            <div id="line">
                <div v-bind:style="{ width: computedWidth, left: computedLeft }" id="line-progress"></div>
            </div>
        </div>
        
        <div v-for="date in dates" :key="date.id">   
            <div :class="isSelected == date.id && 'active'" class="outside">
                <div v-for="lore in history" :key="lore.HistoryID">   
                    <div class="inside">
                        <p v-text="lore.HistoryText" v-if="lore.Period === date.id" ></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="module" src="{{ asset('js/tortenet.js') }}"></script>
@endsection