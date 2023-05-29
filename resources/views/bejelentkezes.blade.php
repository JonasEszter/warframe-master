@extends("layouts.public")
@section('content')
<div class="container">
    <div class="box mw-500px text-center center-tag">
        <form method="POST">
            <div>
                <h3>Felhasználónév/email</h3>
                <input type="text" class="form-control mb-3" 
                name="userName" placeholder="felhasználónév">
            </div>

            <div>
                <h3>Jelszó</h3>
                <input type="password" name="pass"
                class="form-control  mb-3" placeholder="jelszó">
            </div>

            <button name="login" class="btn btn-primary btn-md mt-3">
                Bejelentkezés
            </button>
        </form>
    </div>
</div>
@endsection