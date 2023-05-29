@extends('layouts.public')
@section("content")
<h1 class="kezdolap">Kezdőlap</h1>
<div class=koszonto>
    <h2>Köszöntő</h2>
    <p>Gyorsan szeretnél információhoz jutni a játék működésévelkapcsolatban?
    A frissitéseket azonnal szeretnéd elérni?
    Információra van szükséged, de túl sok weboldalt kell megnyitnod,
    hogy tovább tud haladni a játékkal?
    Ez az általam kifejlesztett weboldal segít neked!
    Olyan, mintha egy mentor állna melletted, aki megtanítja a játék
    összes titkát és fortélyát.
    Minden információ egy helyen!
    A menüpontok segítségével minden felmerülő kérdésedre választ
    kaphatsz rövid időn belül.
    Nagyon jó tanulást és szórakozást kívánok a Warframe-hoz!
    Amennyiben elnyerte tetszésed a weblapon kérlek, hogy ajánld
    másnak is, hogy minél többen ismerhessék meg ezt a nagyszerű játékot.
    Ha olyan ötleted van, mellyel még jobbá vagy még érthetőbbé tehetjük a
    weboldalt, jelezd a eszter@kitalaltcim.hu e-mail címen. Ha kivitelezhető az
    ötleted szívesen lefejlesztem.</p>
</div>
<div class="ismerteto">
    <h2>Tárgyismertető</h2>
    <div class="ismerteto-body">
        <div class="ismerteto-text">
            <p>Célja, hogy a játkosok megtalálják azokat a tárgyakat, amiket a játék során szereztek és eldönthessék, mit kezdenek vele.
                Ez fontos, hiszen ha nem tudjuk milyen tárgyról is van szó, nem nagyon tudunk vele mit kezdeni. Ritka-e vagy mihez kapcsolható.
                A 4 kép közül kiválasztva a megfelelő kategóriát kap egy információt az adott tárgyról, amit nehéz küldetése során sezrzett meg.
                Ha eldöntötte milyen tárgy is került az Ön birtokába, akkor jöhet is a következő!
            </p>
        </div>
        <div class="ismerteto-kat">
            <div class="kategoriak">
                <div class="kategoria">
                    <img src="../images/kezdolap/warframe.jpg" alt="">
                    <div class="body">
                        <div><h3>Warframek</h3></div>
                        <p>A warframe-k erősek lehetnek a megfelelő kezekben. Mindegyik más képességgel és harcstílussal rendelkezik.
                            Megszerzésük sem olyan egyszerű. Melyik warframe fog passzolni Önhöz?
                        </p>
                        <a href="https://warframe.fandom.com/wiki/Warframes"><button>Tovább</button></a>
                    </div>
                </div>
                <div class="kategoria">
                <img src="../images/kezdolap/weapon.jpg" alt="">
                    <div class="body">
                        <div><h3>Fegyverek</h3></div>
                        <p>Egy csendes íj vagy netán egy gyors puska vagy piszolyra vágyik? Akármelyik is legyen az,
                            mindig jól jöhet. De nem árt információt szerezni arról, melyiket hogyan lehet használni.
                            Célra tölts.. és TŰZ! Vagy egy kard, az is elvégzi a feladatot.
                        </p>
                        <a href="https://warframe.fandom.com/wiki/Weapons"><button>Tovább</button></a>
                    </div>
                </div>
                <div class="kategoria active">
                <img src="../images/kezdolap/relics.jpg" alt="">
                    <div class="body">
                        <div><h3>Relikek</h3></div>
                        <p>Ősi relikviák, mely izgalmasabbnál izgalmasabb lehetőséget rejt magában. Nyissa fel hát ezeket
                            és tudjon meg többet róluk, milyen kincsek lapulnak meg ezekben. Tartalmuk különbözően értékes lehet,
                            de melyik fogja ütni a markát?
                        </p>
                        <a href="https://warframe.fandom.com/wiki/Void_Relic"><button>Tovább</button></a>
                    </div>
                </div>
                <div class="kategoria">
                <img src="../images/kezdolap/mods.jpg" alt="">
                    <div class="body">
                        <div><h3>Modok</h3></div>
                        <p>Kártyákat nem csak pókernél vagy röminél használatos. Sőt! Itt hatalmas szerepet játszanak a fegyverek, Warframek
                            és még sok más erősítésében. Rengeteg kártya, de tudja meg hol lehet megszerezni a ritkábbnál ritkábbakat.
                        </p>
                        <a href="https://warframe.fandom.com/wiki/Mod"><button>Tovább</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="todo">
    <h2>Teendő lista</h2>
    @if($loggedIn)
        <a href="/todo_list" type="button" class="btn btn-primary">Todo lista</a>
    @else 
        <a href="/login" type="button" class="btn btn-primary">Bejelentkezés</a>
    @endif
</div>
<div class="hirek">
    <h2>Hírek</h2>
    <div class="hirek-container">
        <div class="hirek-row" id="news-holder">
            <div class="hirek-card" v-for="hirek in news">
                <img v-bind:src="hirek.ImageLink" class="hirekImg">
                <h3 class="hirek-message" v-text="hirek.NewsTitle"></h3>
                <p v-text="hirek.NewsDate"></p>
                <a :href="hirek.NewsLink"><button>Bővebben</button></a>
            </div>
        </div>
    </div>
</div>
<script type="module" src="{{URL::asset('js/news.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.kategoria').click(function(){
            $(this).addClass('active').siblings().removeClass('active')
        });
    });
</script>
@endsection
