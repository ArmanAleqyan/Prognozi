@extends('admin.layouts.default')
@section('title')
    Прогнозы
@endsection

@section('content')

<style>
    input{
        color: white !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


</style>
    @if(session('created'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif
<div class="content-wrapper" bis_skin_checked="1">
    <br>
    <br>
    <br>
    <div class="col-12 grid-margin stretch-card" bis_skin_checked="1">
        <div class="card" bis_skin_checked="1">
            <div class="card-body" bis_skin_checked="1">
                <h4 class="card-title">Добавить Прогноз</h4>
                <form  action="{{route('create_prognoz_post')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                    @csrf
                    <br>

                    <div class="form-group" bis_skin_checked="1">
                        <label for="exampleSelectGender">Кубок любимый</label>
                        <select style="color: #e2e8f0" name="star" class="form-control" id="exampleSelectGender">
                            <option value="1">Нет</option>
                            <option value="0">Да</option>
                        </select>
                    </div>
                    <div class="form-group" bis_skin_checked="1">
                        <label for="">Вид спорта</label>
                        <input type="text" class="form-control" value="Футбол" placeholder="Вид спорта" name="sport_type" required>
                    </div>


                    <div class="form-group" bis_skin_checked="1">
                        <label for="exampleSelectGender">Страна</label>
                        <select style="color: #e2e8f0" name="country_id" class="country_select form-control" id="exampleSelectGender">
                            @foreach($country as $countr)
                            <option  value="{{$countr->id}}">{{$countr->name}}</option>
                                @endforeach
                        </select>
                    </div>

{{--                    <div class="form-group" bis_skin_checked="1">--}}
{{--                        <label for="">Лига</label>--}}
{{--                        <input type="text" class="form-control" id="" placeholder="Лига" name="liga" required>--}}
{{--                    </div>--}}
                    @php
                    $get_liga = \App\Models\Liga::where('country_id', $country->first()->id)->get();
                    $get_liga_two = \App\Models\Liga::where('country_id', $country->first()->id)->get();

                    @endphp

                    <div class="form-group display_none_div LigaSelect{{$country->first()->id}}" bis_skin_checked="1">
                        <label for="exampleSelectGender">Лига</label>
                        <select name="liga_id"  style="color: #e2e8f0" class="remove_name_select form-control" id="exampleSelectGender">
                            @foreach($get_liga as $liga)
                            <option value="{{$liga->id}}">{{$liga->name}}</option>
                                @endforeach
                        </select>
                    </div>

                    @foreach($country as $countr)
                        @if($countr->id !=  $country->first()->id)
                        <?php $get_ligas = \App\Models\Liga::where('country_id', $countr->id)->get() ?>
                        <div  class="display_none_div form-group LigaSelect{{$countr->id}}" bis_skin_checked="1" style="display: none">
                            <label for="exampleSelectGender">Лига</label>
                            <select style="color: #e2e8f0" name="" class="liga_select{{$countr->id}} form-control remove_name_select" id="exampleSelectGender">
                                @foreach($get_ligas as $get_liga)
                                    <option  value="{{$get_liga->id}}">{{$get_liga->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    @endforeach

                    <div class="form-group" bis_skin_checked="1">
                        <label for="">Тур</label>
                        <input type="text" class="form-control" id="" placeholder="Название" name="name" required>
                    </div>
{{--                    <div class="form-group" bis_skin_checked="1">--}}
{{--                        <label for="">Ссылка</label>--}}
{{--                        <input type="text" class="form-control" id="" placeholder="url" name="url">--}}
{{--                    </div>--}}

                    <div class="form-group" bis_skin_checked="1">
                        <label for="">Дата</label>
                        <input required type="date" class="form-control" id="" placeholder="url" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}" max="9999-12-31" name="date">
                    </div>
                    <div class="form-group" bis_skin_checked="1">
                        <label for="">Время</label>
                        <input required type="time" class="form-control" id="" placeholder="url"  name="time">
                    </div>

                    @php
                    $get_commands_liga = \App\Models\CommandLiga::where('liga_id', $get_liga_two->first()->id)->get('command_id')->pluck('command_id')->toarray();
                    $get_commands = \App\Models\Command::wherein('id', $get_commands_liga)->get();
                    @endphp

                    <div class="form-group" bis_skin_checked="1">
                        <label for="exampleSelectGender">Команда Дома</label>
                        <select name="command_home" style="color: #e2e8f0" class="form-control command_home" id="exampleSelectGender">
                            @foreach($get_commands as $command)
                            <option value="{{$command->id}}">{{$command->name_one}}</option>
                                @endforeach
                        </select>
                    </div>



                    <div class="form-group" bis_skin_checked="1">
                        <label for="exampleSelectGender">Команда В Гостях</label>
                        <select name="command_guest" style="color: #e2e8f0" class="form-control command_guest" id="exampleSelectGender">
                            @foreach($get_commands as $command)
                                <option value="{{$command->id}}">{{$command->name_one}}</option>
                            @endforeach
                        </select>
                    </div>



{{--                    <div style="display: flex; justify-content: space-between">--}}
{{--                    <div class="form-group" bis_skin_checked="1" style="width: 40%">--}}
{{--                        <label for="">Первая  команда</label>--}}
{{--                        <input required type="text" class="form-control" id="" placeholder="team_one" name="team_one">--}}
{{--                        <br>--}}
{{--                        <input  type="text" class="form-control" id="" placeholder="{команда}" name="team_one_two">--}}
{{--                        <div style="background-color: transparent;  border: none; display: block;" class="btn btn-primary" bis_skin_checked="1">--}}
{{--                            <div data-toggle="modal" data-target="#exampleModalCenter2" bis_skin_checked="1">--}}
{{--                                <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src="" alt="" id="blahas">--}}
{{--                                <br>--}}
{{--                            </div>--}}
{{--                            <input accept="image/*" style="display: none" name="team_one_logo" id="file-logos" class="btn btn-outline-success" type="file">--}}
{{--                            <br>--}}
{{--                            <label style="" for="file-logos" class="custom-file-upload btn btn-outline-success">--}}
{{--                                Лого первой команды--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}




{{--                    <div class="form-group" bis_skin_checked="1" style="width: 40%">--}}
{{--                        <label for="">Вторая  команда</label>--}}
{{--                        <input required type="text" class="form-control" id="" placeholder="team_two" name="team_two">--}}
{{--                        <br>--}}
{{--                        <input type="text" class="form-control" id="" placeholder="{команда}" name="team_two_two">--}}
{{--                        <div style="background-color: transparent;  border: none; display: block;" class="btn btn-primary" bis_skin_checked="1" >--}}
{{--                            <div data-toggle="modal" data-target="#exampleModalCenter" bis_skin_checked="1">--}}

{{--                                <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src="" id="blaha">--}}

{{--                                <br>--}}
{{--                            </div>--}}
{{--                            <input accept="image/*" style="display: none" name="team_two_logo" id="file-logo" class="btn btn-outline-success" type="file">--}}
{{--                            <br>--}}

{{--                            <label style="" for="file-logo" class="custom-file-upload btn btn-outline-success">--}}
{{--                                Лого второй команды--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    </div>--}}
                    <br>
                    <br>
                    <h3>КФ</h3>
                    <br>
                    <div id="editor-container"></div>
                    <div id="input-container" bis_skin_checked="1">
                    </div>
                    <button type="button" class="btn btn-inverse-light btn-fw" id="add-inputs">Добавить ещё</button>
                    <br><br>
                    <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Добавить</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{asset('admin//js/product.js')}}"></script>
@endsection

