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
                    <form  action="{{route('update_prognoz')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <br>

                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Кубок любимый</label>
                            <select style="color: #e2e8f0" name="star" class="form-control" id="exampleSelectGender">
                                @if($get->star == 1)
                                <option value="1">Нет</option>
                                <option value="0">Да</option>
                                    @else
                                    <option value="0">Да</option>
                                    <option value="1">Нет</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Вид спорта</label>
                            <input value="{{$get->sport_type}}" type="text" class="form-control" id="" placeholder="Вид спорта" name="sport_type" required>
                        </div>


                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Страна</label>
                            <select style="color: #e2e8f0" name="country_id" class="form-control country_select" id="exampleSelectGender">
                                @foreach($country as $countr)
                                    @if($get->country_id == $countr->id)
                                    <option selected value="{{$countr->id}}">{{$countr->name}}</option>
                                    @else
                                        <option value="{{$countr->id}}">{{$countr->name}}</option>

                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="prognoz_id" value="{{$get->id}}">

{{--                        <div class="form-group" bis_skin_checked="1">--}}
{{--                            <label for="">Лига</label>--}}
{{--                            <input value="{{$get->liga}}" type="text" class="form-control" id="" placeholder="Лига" name="liga" required>--}}
{{--                        </div>--}}



                        @php
                        if ($get->liga_id != null){
                            $get_liga = \App\Models\Liga::where('country_id', $get->country_id)->get();
                        }else{
                         $get_liga = \App\Models\Liga::where('country_id', $get->country_id)->get();
                        }
                        @endphp

                        <div class="form-group display_none_div LigaSelect{{$get->country_id}}" bis_skin_checked="1">
                            <label for="exampleSelectGender">Лига</label>
                            <select name="liga_id"  style="color: #e2e8f0" class="remove_name_select form-control" id="exampleSelectGender">
                                @foreach($get_liga as $liga)
                                    <option value="{{$liga->id}}">{{$liga->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach($country as $countr)
                            @if($countr->id != $get->country_id)
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
                            <input value="{{$get->title}}" type="text" class="form-control" id="" placeholder="Название" name="name" required>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Ссылка</label>
                            <input value="{{$get->url}} " type="text" class="form-control" id="" placeholder="url" name="url">
                        </div>

                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Дата</label>
                            <input required type="date" value="{{$get->start_date}}" class="form-control" id="" placeholder="url" min="{{$get->start_date}}" max="9999-12-31" name="date">
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="">Время</label>
                            <input required type="time" value="{{$get->start_time}}" class="form-control" id="" placeholder="url"  name="time">
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="form-group" bis_skin_checked="1" style="width: 40%">
                                <label for="">Первая  команда</label>
                                <input value="{{$get->team_one}}" required type="text" class="form-control" id="" placeholder="team_one" name="team_one">
                                <br>
                                <input   value="{{$get->team_one_two}}" type="text" class="form-control" id="" placeholder="{команда}" name="team_one_two">
                                <div style="background-color: transparent;  border: none; display: block;" class="btn btn-primary" bis_skin_checked="1">
                                    <div data-toggle="modal" data-target="#exampleModalCenter2" bis_skin_checked="1">
                                        <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src="{{asset('uploads/'.$get->team_one_logo)}}" alt="" id="blahas">
                                        <br>
                                    </div>
                                    <input accept="image/*" style="display: none" name="team_one_logo" id="file-logos" class="btn btn-outline-success" type="file">
                                    <br>
                                    <label style="" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                        Лого первой команды
                                    </label>
                                </div>
                            </div>





                            <div class="form-group" bis_skin_checked="1" style="width: 40%">
                                <label for="">Вторая  команда</label>
                                <input required type="text" class="form-control" id="" value="{{$get->team_two}}" placeholder="team_two" name="team_two">
                                <br>
                                <input type="text" class="form-control" id="" placeholder="{команда}" value="{{$get->team_two_two}}"  name="team_two_two">
                                <div style="background-color: transparent;  border: none; display: block;" class="btn btn-primary" bis_skin_checked="1" >
                                    <div data-toggle="modal" data-target="#exampleModalCenter" bis_skin_checked="1">

                                        <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src="{{asset('uploads/'.$get->team_two_logo)}}" id="blaha">

                                        <br>
                                    </div>
                                    <input accept="image/*" style="display: none" name="team_two_logo" id="file-logo" class="btn btn-outline-success" type="file">
                                    <br>

                                    <label style="" for="file-logo" class="custom-file-upload btn btn-outline-success">
                                        Лого второй команды
                                    </label>
                                </div>
                            </div>
                        </div>
                        @php
                            $get_analize = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->where('group_id', 9999999999)->first();
                            @endphp
                        <div class="form-group" bis_skin_checked="1">
                            <label for="exampleSelectGender">Анализ</label>
                            <textarea name="analize" id="tinymceanalize">@if(isset($get_analize)){{$get_analize->attr}}@endif</textarea>
                        </div>

                        <br>
                        <br>
                        <h3>Событие</h3>
                        <br>
                        @if(!$get->attr->isempty())

                        @foreach($get->attr->groupBy('group_id') as $atributes)
                        <div id="editor-container"></div>
                        <div id="input-container" bis_skin_checked="1">
                        </div>
                        @endforeach
                        @else
                            <div id="editor-container"></div>
                            <div id="input-container" bis_skin_checked="1">
                            </div>
                            @endif


                        <button type="button" class="btn btn-inverse-light btn-fw" id="add-inputs">Добавить ещё</button>
                        <br><br>
                        <br><br>
                        <br><br>
                        <div style="display: flex; justify-content: space-between;">
                        <button type="submit" class="submit_button btn btn-inverse-success btn-fw">Применить</button>
                            @if($get->show_analize == 0)
                        <a href="{{route('show_analize', $get->id)}}" type="submit" class="submit_button btn btn-inverse-success btn-fw">Выставить на показ анализы </a>
                            @else
                                <a href="{{route('show_analize', $get->id)}}" type="submit" class="submit_button btn btn-inverse-success btn-fw">Снять показ анализа </a>

                            @endif
                        </div>
                    </form>
                </div>

                <br>
                <br>
                <br>
                <div class="row " bis_skin_checked="1">
                    <div class="col-12 grid-margin" bis_skin_checked="1">
                        <div class="card" bis_skin_checked="1">
                            <div class="card-body" bis_skin_checked="1">
                                <h4 class="card-title">КФ</h4>
                                <div class="table-responsive" bis_skin_checked="1">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> Название </th>
                                            <th> КФ</th>
                                            <th> Лучшая ставка</th>
                                            <th> Риск</th>
                                            <th> Событие</th>
                                        </tr>
                                        </thead>
                                        @foreach($get->attr->where('attr', '!=', null) as $attr)
                                        <tbody>
                                        <tr>
                                            <td> {{$attr->title}} </td>
                                            <td> {{$attr->kf}}</td>
                                                @if($attr->super == 0 && $attr->super != null)
                                                <td>Да</td>
                                            @else
                                                <td>Нет</td>
                                                @endif
                                            <td>{{$attr->risk}}</td>
                                            <td>{{$attr->sobitie}}</td>
                                            <td style="display: flex; justify-content: flex-end"><a  href="{{route('single_page_prognoz_attr', $attr->id)}}" class="btn btn-inverse-warning btn-fw">Редактировать</a></td>
                                        </tr>

                                        </tbody>
                                            @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <script>
        tinymce.init({
            height: "400px",
            selector: `#tinymceanalize`,
            plugins: "link image lists colorpicker",
            toolbar:  "undo redo | styleselect | bold italic | forecolor | link image | bullist numlist",
        });
    </script>


















    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <?php $i = \App\Models\PrognozAttr::where('prognoz_id', $get->id)->orderby('id', 'desc')->first()->group_id??0;  ?>
    <script >



        $('.country_select').change(function() {

            // Get the selected value
            var selectedValue = $(this).val();

            $('.display_none_div').hide();
            $('.remove_name_select').removeAttr('name');
            $(`.LigaSelect${selectedValue}`).show()
            $(`.liga_select${selectedValue}`).attr('name', 'liga_id')

        });

        const formDataArray = [];
        let i = "<?php echo $i  ?>";


        $(document).ready(function() {

            const option_one_array = [
                "Исход матча",
                "Исход матча (Двойной шанс)",
                "Тотал голов",
                "Фора (Гандикап)",
                "Забьют - не забьют",
                "Индивидуальный тотал голов",
                "Точный счет",
                "Исход и тотал голов",
                "Исход и обе забьют",
                "Исход 1-го тайма",
                "Тотал голов в 1-м тайме",
                "Угловые: Исходы",
                "Тотал угловых",
                "Индивидуальный тотал угловых",
                "Желтые карты: Исход",
                "Тотал желтых карт",
                "Индивидуальный тотал желтых карт",
            ];
            const option_two_array = ["Минимальный", "Низкий", "Средний" , "Высокий" ,"Экстремальный"];
            $('#add-inputs').click(function() {

                i++;
                const container = $(`
            <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${i}" >
      <div style="display: flex; justify-content: space-between">
                    <label>Событие</label>
                    <label>Риск </label>

                </div>
                <div style="display: flex; justify-content: space-between">

                          <select style="color: #e2e8f0; width: 30%" name="data[${i}][sobitie]" class="form-control" id="exampleSelectGender">

                                                                </select>

                     <select style="color: #e2e8f0; width: 30%" name="data[${i}][risk]" class="form-control" id="exampleSelectGender">

                                                                </select>


                </div>
                <br>
                <div style="display: flex; justify-content: space-between">
                    <label>Название</label>
                    <label>КФ
                    </label>
                <label for="exampleSelectGender">Лучшая ставка</label>
                </div>
                <div style="display: flex; justify-content: space-between">
                    <input required style="width: 30%" name="data[${i}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название" >
                    <input required style="-webkit-appearance: none; width: 30%" name="data[${i}][price]" type="text" class="form-control data" id="exampleInputName1" placeholder="КФ">
                    <input name="data[${i}][id]" type="hidden" value="${i}" class="form-control data" id="exampleInputName1" placeholder="КФ">
     <div class="form-group" bis_skin_checked="1">

                            <select style="color: #e2e8f0" name="data[${i}][super]" class="form-control" id="exampleSelectGender">
                                                                <option value="1">Нет</option>
                                                                  <option value="0">Да</option>
                                                                </select>
                        </div>
                </div>

                <br>
<!--                   <button data_id="${i}" type="button" class="btn btn-inverse-light btn-fw addsub${i}" >Добавить ещё</button>-->
                <br>
                <br>
                <div class="tinymce-editor-container">
                    <textarea id="tinymce_${i}" name="data[${i}][description]" class="tinymce-editor"></textarea>
                </div>
            </div>  <br><br> `
                );





                //////// Stexic dzer chtakl

                $('#input-container').append(container);
                const selectElementOne = $('.delete_inputs_div').find('select[name="data[' + i + '][sobitie]"]');
                const selectElementTwo = $('.delete_inputs_div').find('select[name="data[' + i + '][risk]"]');

                function populateSelect(selectElement, optionArray) {
                    selectElement.empty(); // Очищаем текущие option элементы в select
                    optionArray.forEach(function (optionText, index) {
                        const option = $('<option></option>');
                        option.val(optionText); // Устанавливаем значение равное индексу в массиве
                        option.text(optionText); // Устанавливаем текст option
                        selectElement.append(option); // Добавляем option в select
                    });
                }

                // Вызываем функцию для заполнения select элементов данными из массивов
                populateSelect(selectElementOne, option_one_array);
                populateSelect(selectElementTwo, option_two_array);

                tinymce.init({
                    height: '400px',
                    selector: `#tinymce_${i}`,
                    plugins: 'link image lists colorpicker',
                    toolbar: 'undo redo | styleselect | bold italic | forecolor | link image | bullist numlist',
                });

                $(`.addsub${i}`).on('click', function () {
                    let data_id = $(this).attr('data_id')
                    const new_container = $(`
                <br>
              <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${data_id}" >
                <div style="display: flex; justify-content: space-between">
                    <label>Название</label>
                    <label>КФ
                    </label>
                </div>
                <div style="display: flex; justify-content: space-between">

                    <input style="width: 30%" name="data[${data_id}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название" >
                    <input style="-webkit-appearance: none; width: 30%" name="data[${data_id}][price]" type="text" class="form-control data" id="exampleInputName1" placeholder="КФ">
                    <input  name="data[${data_id}][id]" value="${data_id}" type="hidden" class="form-control data" id="exampleInputName1" placeholder="КФ">

                </div>


            </div>
            `)

                    $(`.new_inputs${data_id}`).append(new_container)

                })

            });

            $('form').submit(function(event) {
                event.preventDefault();

                $('.delete_inputs_div').each(function() {
                    const startTime = $(this).find('[name^="data["][name$="[start_time]"]').val();
                    const price = $(this).find('[name^="data["][name$="[price]"]').val();
                    const id = $(this).find('[name^="data["][name$="[id]"]').val()
                    const supers = $(this).find('[name^="data["][name$="[super]"]').val();
                    const description = JSON.stringify(tinymce.get(`tinymce_${$(this).attr('data_id')}`).getContent());


                    const sobitie = $(this).find('select[name^="data["][name$="[sobitie]"]').val();
                    const risk = $(this).find('select[name^="data["][name$="[risk]"]').val();



                    formDataArray.push({
                        start_time: startTime,
                        price: price,
                        description: description,
                        id:id ,
                        super: supers,
                        sobitie: sobitie,
                        risk: risk
                    });
                });


            });
        });

        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                const form = $(this)[0]; // Get the actual form element
                const formData = new FormData(form); // Create a FormData object

                formDataArray.forEach((value, index) => {
                    formData.append(`datas[${index}]`, JSON.stringify(value));
                });

                formDataArray.length = 0;
                // formData.append(formDataArray)
                $('.submit_button').hide();

                // Send the form data using AJAX
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData, // Use the FormData object
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {
                        alert('Прогноз успешно редактирован');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        $('.submit_button').show();
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        }
                    }
                });
            });
        });


    </script>
@endsection

