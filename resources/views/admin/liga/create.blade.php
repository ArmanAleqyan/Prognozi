@extends('admin.layouts.default')
@section('title')
    Лиги
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
                    <h4 class="card-title">Добавить Лигу</h4>
                    <form  action="{{route('create_liga_post')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Страна</label>
                            <select name="country_id" style="color: #e2e8f0;" class="form-control" id="exampleSelectGender">
                                @foreach($get as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach

                            </select>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Лига</label>
                            <input type="text" class="form-control" id="" placeholder="Лига" name="name" required>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Ссылка</label>
                            <input type="text" class="form-control" id="" placeholder="Ссылка" name="url" required>
                        </div>

                        <br>

                        <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    {{--    <script src="{{asset('admin//js/product.js')}}"></script>--}}
@endsection

