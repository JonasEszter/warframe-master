@extends("layouts.public")
@section("content")

    <div id="app" class="text-center">
        <h1>Warframe</h1>

        @if($loggedIn)
            <button type="button" class="btn btn-primary" 
            data-toggle="modal" data-target="#exampleModal">
                Mentés
            </button>
        @else 
            <a href="/login" type="button" class="btn btn-primary">A mentéshez jelentkezz be!</a>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Összeállítás elmentése</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Elnevezés</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" ref="buildName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                        <button type="button" class="btn btn-primary" @click="saveSet">Mentés</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Összeállítás módosítása</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Bezárás</button>
                    <button type="button" class="btn btn-primary">Módosítások mentése</button>
                </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    <div class="row">
        <div class="col-lg-2">
            <img v-bind:src="warframe.Image" class="img-fluid">

            <table class="table table-striped table-dark table-hover text-center">
                <tr>
                    <td>Kapacitás</td>
                    <td id="capacity">30</td>
                </tr>
                <tr>
                    <td>Név</td>
                    <td v-text="warframe.CharName"></td>
                </tr>
                <tr>
                    <th>Energia</th>
                    <td v-bind:id="'property' + effectTypes.energy" v-text="warframe.CharPower"></td>
                </tr>
                <tr>
                    <th>Életerő</th>
                    <td v-bind:id="'property' + effectTypes.health" v-text="warframe.Health"></td>
                </tr>
                <tr>
                    <th>Pajzs</th>
                    <td v-bind:id="'property' + effectTypes.shield" v-text="warframe.Shield"></td>
                </tr>
                <tr>
                    <th>Sebesség</th>
                    <td v-bind:id="'property' + effectTypes.speed" v-text="warframe.Speed"></td>
                </tr>
                <tr>
                    <th>Védelem</th>
                    <td v-bind:id="'property' + effectTypes.armor" v-text="warframe.Armor"></td>
                </tr>
                <tr>
                    <th>Aura</th>
                    <td v-text="warframe.TypeName"></td>
                </tr>
            </table>
        </div>

        <div class="col-lg-5 bg-light box" style="max-width: 70%">
            <div style="align-items: center; justify-content: center;" class="flexbox">
                <div>
                    <select class="polarity-select" id="polarity-select0">
                        <option value="0">-</option>
                        <option v-for="polarity in polarities" 
                        :value="polarity.TypeID"
                        v-text="polarity.TypeName"></option>
                    </select>
                    <select class="mod-level" id="mod-level0" disabled>
                        <option value="1">1</option>
                    </select>

                    <div id="holder" class="bg-info text-center mb-1 box card-holder"
                    modtype="aura" selectid="polarity-select0" modlevelid="mod-level0"
                    style="width:220px;height:312px;padding:5px;"></div>
                </div>
                
                <div>
                    <select class="polarity-select" id="polarity-select1">
                        <option value="0">-</option>
                        <option v-for="polarity in polarities" 
                        :value="polarity.TypeID"
                        v-text="polarity.TypeName"></option>
                    </select>
                    <select class="mod-level" id="mod-level1" disabled>
                        <option value="1">1</option>
                    </select>

                    <div id="holder" class="bg-info text-center mb-1 box card-holder"
                    modtype="aura" selectid="polarity-select1" modlevelid="mod-level1"
                    style="width:220px;height:312px;padding:5px;"></div>
                </div>
            </div>

                <div style="align-items: center; justify-content: center;" class="flexbox">
                    @for($i = 0; $i < 8; $i++)
                        <div>
                            <select class="polarity-select" id="polarity-select{{$i+2}}">
                                <option value="0">-</option>
                                <option v-for="polarity in polarities" 
                                :value="polarity.TypeID"
                                v-text="polarity.TypeName"></option>
                            </select>

                            <select class="mod-level" id="mod-level{{$i+2}}" disabled>
                                <option value="1">1</option>
                            </select>

                            <div id="holder" class="bg-info text-center mb-1 box card-holder"
                            modtype="not-aura" selectid="polarity-select{{$i+2}}" modlevelid="mod-level{{$i+2}}"
                            style="width:220px;height:312px;padding:5px;"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="col-lg-5 bg-light box" style="max-width: 33%">
                <div class="flexbox" style="height:800px;overflow:auto;">
                    <div v-for="mod in mods" v-bind:id="'mod-holder' + mod.ModID" modtype="card-holder" ref="card"
                        class="bg-info text-center mb-1 card" style="width:200px;height:284px;padding:5px;">
                        <img v-bind:polarity="mod.Polarity" v-bind:basedrain="mod.BaseDrain"
                        v-bind:modlevel="mod.ModLevel" v-bind:effectvalue="mod.EffectValue"
                        v-bind:effecttype="mod.EffectType" v-bind:compatname="mod.CompatName"
                        v-bind:src="mod.ModImg" v-bind:modid="mod.ModID" v-bind:id="'mod' + mod.ModID">
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    <script>
    
    </script>

    <script type="module" src="{{URL::asset('js/warframe.js')}}"></script>
@endsection