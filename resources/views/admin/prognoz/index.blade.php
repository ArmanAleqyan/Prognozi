@extends('admin.layouts.default')
@section('title')
  Прогнозы
@endsection

@section('content')
    <div class="content-wrapper" bis_skin_checked="1">
        <br>
        <br>
        <br>

        <div class="row " bis_skin_checked="1">
            <div class="col-12 grid-margin" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-body" bis_skin_checked="1">
                        <div style="display: flex; justify-content: space-between; align-items: center">
                        <h4 class="card-title">Прогнозы</h4>
                            <a class="btn btn-inverse-warning btn-fw" href="{{route('create_prognoz')}}">Добавить</a>
                        </div>
                        <br>
                        <br>
                        <div class="table-responsive" bis_skin_checked="1">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> Название </th>
                                    <th> Команда  </th>
                                    <th> Команда </th>
                                    <th> Дата начала </th>
                                    <th> Время Начала </th>
                                </tr>
                                </thead>
                                @foreach($get as $pr)
                                <tbody>
                                <tr>
                                    <td> {{$pr->title}}</td>
                                    <td> {{$pr->team_one}} </td>
                                    <td> {{$pr->team_two}}</td>
                                    <td> {{$pr->start_date}} </td>
                                    <td> {{$pr->start_time}} </td>
                                    <td style="display: flex; justify-content: flex-end">
                                        <a  href="{{route('single_page_prognoz', $pr->id)}}" class="btn btn-inverse-success btn-fw" bis_skin_checked="1">Редактирование </a>
                                        &nbsp; @if(auth()->user()->id == 1)
                                        &nbsp;&nbsp;   <a  href="{{route('delete_prognoz', $pr->id)}}" class="btn btn-inverse-danger btn-fw" bis_skin_checked="1">Удалить</a>
                                                   @endif
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