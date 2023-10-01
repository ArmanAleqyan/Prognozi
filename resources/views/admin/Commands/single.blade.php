@extends('admin.layouts.default')
@section('title')
    Команды
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
                    <h4 class="card-title">Редактирование  Команды</h4>
                    <form  action="{{route('update_command')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>

                        @foreach($get_command->liga as $liga)
                        <h6>{{$liga->ligas->country_name->name}} / {{$liga->ligas->name}} <a href="{{route('delete_liga_for_command', $liga->id)}}" style="cursor: pointer; " class="badge badge-danger">Удалить</a></h6>
                        @endforeach
                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Лиги</label>
                            <select name="liga_id[]"  style="color: #e2e8f0; height: 170px" multiple class="form-control" id="exampleSelectGender">
                                @foreach($get as $liga)
                                    <option value="{{$liga->id}}">{{$liga->country_name->name}} / {{$liga->name}}  </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="command_id" value="{{$get_command->id}}">

                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Название</label>
                            <input type="text" class="form-control" id="" value="{{$get_command->name_one}}" placeholder="Название" name="name_one" required>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Название(en)</label>
                            <input type="text" class="form-control" id="" value="{{$get_command->name_two}}" placeholder="Название" name="name_two" required>
                        </div>
                        <div bis_skin_checked="1">
                            <img style="object-fit: cover; object-position: center; max-height: 200px; max-width: 200px; width: 100%;" src="{{asset('uploads/'.$get_command->logo)}}" alt="image" id="blahas">
                            <br>
                            <input accept="image/*" style="display: none" name="logo" id="file-logos" class="btn btn-outline-success" type="file" >
                            <br>
                            <label style="width: 200px" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                Выберете Лого *
                            </label>
                        </div>
                        <br>

                        <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Редактировать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    {{--    <script src="{{asset('admin//js/product.js')}}"></script>--}}
@endsection

