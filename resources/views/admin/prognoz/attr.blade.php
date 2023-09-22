@extends('admin.layouts.default')
@section('title')
    Атрибуты
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
                    <div style="display: flex; justify-content: space-between">
                    <h4 class="card-title">Атрибуты</h4>
                        <a style="display: flex; justify-content: center; align-items: center" class="btn btn-inverse-warning btn-fw" href="{{route('single_page_prognoz', $get->prognoz_id)}}">Назад</a>
                    </div>
                   
                        <form  action="{{route('update_attr')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>

                            <input type="hidden" name="group_id" value="{{$get->group_id}}">
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Название</label>
                            <input value="{{$get->title}}" type="text" class="form-control" id="" placeholder="Название" name="title" >
                        </div>

                        <input type="hidden" name="attr_id" value="{{$get->id}}">

                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Кф</label>
                            <input value="{{$get->kf}}" type="text" class="form-control" id="" placeholder="Кф" name="kf">
                        </div>

                            <div class="form-group" bis_skin_checked="1">
                                <label for="exampleSelectGender">Лучшая ставка</label>
                                <select style="color: #e2e8f0" name="super" class="form-control" id="exampleSelectGender">
                                    @if($get->super == 1 || $get->super == null)
                                    <option value="1">Нет</option>
                                    <option value="0">Да</option>
                                        @else
                                        <option value="0">Да</option>
                                        <option value="1">Нет</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group" bis_skin_checked="1">
                                <label for="exampleSelectGender">Исполнилось</label>
                                <select style="color: #e2e8f0" name="status" class="form-control" id="exampleSelectGender">
                                    @if($get->status == 0 )
                                    <option value="0">Нет</option>
                                    <option value="1">Да</option>
                                        @else
                                        <option value="1">Да</option>
                                        <option value="0">Нет</option>
                                    @endif
                                </select>
                            </div>

                        <div id="input-container">
                            <?php $old_attr = \App\Models\PrognozAttr::where('group_id', $get->group_id)->where('id', '!=', $get->id)->where('prognoz_id', $get->prognoz_id)->where('title','!=',' ')->where('kf','!=', ' ')->get(); ?>

                            @foreach($old_attr as $old)
                                    <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${i}" >
                                        <div style="display: flex; justify-content: space-between">
                                            <label >Название</label>

                                            <label >КФ   </label>
                                        </div>
                                        <div style="display: flex; justify-content: space-between">
                                            <input style="width: 30%" name="old_data[{{$old->id}}][start_time]" type="text" value="{{$old->title}}" class="form-control data" id="exampleInputName1" placeholder="Название" >
                                            @if($old->status == 0)
                                            <a  style="width: 15%; display: flex; justify-content: center; align-items: center" href="{{route('status_attr', $old->id)}}" type="text" value="{{$old->title}}" class="btn btn-inverse-success btn-fw"  >Исполнился </a>
                                           @else
                                                <a  style="width: 15%; display: flex; justify-content: center; align-items: center" href="{{route('status_attr', $old->id)}}" type="text" value="{{$old->title}}" class="btn btn-inverse-warning btn-fw">Не Исполнился </a>

                                            @endif
                                            <input style="-webkit-appearance: none; width: 30%" name="old_data[{{$old->id}}][price]" value="{{$old->kf}}" type="text" class="form-control data" id="exampleInputName1" placeholder="КФ" >
                                        </div>
                                    </div>
                                    @endforeach
                        </div>
                            <br>
                            <br>
                            <br>
                            <button type="button" class="btn btn-inverse-light btn-fw" id="add-inputs">Добавить ещё</button>
                        <br>
                        <br>
                        <br>


                        <textarea name="attr" id="myTextarea">{{$get->attr}}</textarea>

                        <br>
                        <br>

                            <div style="display: flex; justify-content: space-between">
                        <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Редактировать</button>
                                &nbsp; @if(auth()->user()->id == 1)
                        <a href="{{route('delete_attr', $get->id)}}"  class="btn btn-inverse-danger btn-fw">Удалить</a>
                                           @endif
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>

        tinymce.init({
            selector: `#myTextarea`,
            height: '400px',
            plugins: 'link image lists colorpicker',
            toolbar: 'undo redo | styleselect | bold italic | forecolor | link image | bullist numlist',
        });

        $(document).ready(function() {
            let i = 0;
            $('#add-inputs').click(function() {
                i++;
                $('#input-container').append(
                    `               <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${i}" >
                                        <div style="display: flex; justify-content: space-between">
                                        <label >Название</label>

                                        <label >КФ   <span  style="color: red; cursor: pointer; " class="x_button_input">x</span></label>
                                        </div>
                                        <div style="display: flex; justify-content: space-between">
                                        <input style="width: 30%" name="data[${i}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название" required>
                                        <input style="-webkit-appearance: none; width: 30%" name="data[${i}][price]" type="number" class="form-control data" id="exampleInputName1" placeholder="КФ" required>

                                    </div>
                                    </div>`);



                $('.x_button_input').on('click', function () {

                    $(this).closest('.delete_inputs_div').remove();
                });
            });

        })
    </script>

    {{--    <script src="{{asset('admin//js/product.js')}}"></script>--}}
@endsection

