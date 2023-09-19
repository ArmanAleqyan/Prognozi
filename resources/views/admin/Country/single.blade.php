@extends('admin.layouts.default')
@section('title')
    Страна
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
                    <h4 class="card-title">Редактирование Страны </h4>
                    <form  action="{{route('update_country')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>

                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Страна</label>
                            <input type="text" class="form-control" id="" placeholder="Страна" name="name" value="{{$get->name}}" required>
                        </div>

                        <input type="hidden" name="country_id" value="{{$get->id}}">

                        <div bis_skin_checked="1">
                            <img style="object-fit: cover; object-position: center; max-height: 200px; max-width: 200px; width: 100%;" src="{{asset('uploads/'.$get->photo)}}" alt="image" id="blahas">
                            <br>
                            <input accept="image/*" style="display: none" name="photo" id="file-logos" class="btn btn-outline-success" type="file" >
                            <br>
                            <label style="width: 200px" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                Выберете флаг *
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

