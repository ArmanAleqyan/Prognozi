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
                    <h4 class="card-title">Добавить Команду</h4>
                    <form  action="{{route('create_command_post')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>

                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Лиги</label>
                            <select required name="liga_id[]"  style="color: #e2e8f0; height: 170px" multiple class="form-control" id="exampleSelectGender">
                                @foreach($get as $liga)
                                <option value="{{$liga->id}}">{{$liga->country_name->name}} / {{$liga->name}}  </option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Название</label>
                            <input type="text" class="form-control" id="" placeholder="Название" name="name_one" required>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Название(en)</label>
                            <input type="text" class="form-control" id="" placeholder="Название" name="name_two" required>
                        </div>
                        <div bis_skin_checked="1">
                            <img style="object-fit: cover; object-position: center; max-height: 200px; max-width: 200px; width: 100%;" src="" alt="image" id="blahas">
                            <br>
                            <input accept="image/*" style="display: none" name="logo" id="file-logos" class="btn btn-outline-success" type="file" required>
                            <br>
                            <label style="width: 200px" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                Выберете Лого *
                            </label>
                        </div>
                        <br>

                        <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cache the input field and the submit button
            var logoInput = $('#file-logos');
            var submitButton = $('.submit_button');

            // Initially, hide the submit button
            submitButton.hide();

            logoInput.on('change', function() {
                // Check if a file has been selected
                if ($(this).val()) {
                    // If a file has been selected, show the submit button
                    submitButton.show();
                } else {
                    // If no file has been selected, hide the submit button
                    submitButton.hide();
                }
            });

        });
    </script>
    {{--    <script src="{{asset('admin//js/product.js')}}"></script>--}}
@endsection

