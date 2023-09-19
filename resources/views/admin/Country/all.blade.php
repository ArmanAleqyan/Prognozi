@extends('admin.layouts.default')
@section('title')
    Страны
@endsection

@section('content')
    <div class="content-wrapper" bis_skin_checked="1">
        <br>
        <br>
        <br>
        @if(session('deleted'))
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

        <div class="row " bis_skin_checked="1">
            <div class="col-12 grid-margin" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-body" bis_skin_checked="1">
                        <div style="display: flex; justify-content: space-between; align-items: center">
                            <h4 class="card-title">Страны</h4>
                            <a class="btn btn-inverse-warning btn-fw" href="{{route('create_country_page')}}">Добавить</a>
                        </div>
                        <br>
                        <br>
                        <div class="table-responsive" bis_skin_checked="1">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> Название </th>
                                    <th> Флаг </th>

                                </tr>
                                </thead>
                                @foreach($get as $pr)
                                    <tbody>
                                    <tr>
                                        <td> {{$pr->name}}</td>
                                        <td><img src="{{asset('uploads/'.$pr->photo)}}" alt=""></td>

                                        <td style="display: flex; justify-content: flex-end">
                                            <a  href="{{route('single_page_country', $pr->id)}}" class="btn btn-inverse-success btn-fw" bis_skin_checked="1">Редактировать</a>
                                            &nbsp;
                                            &nbsp;
                                            <a  href="{{route('delete_country', $pr->id)}}" class="btn btn-inverse-danger btn-fw" bis_skin_checked="1">Удалить</a>
                                        </td>
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
@endsection