@extends('admin.layouts.default')
@section('title')
    Лиги
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
                            <h4 class="card-title">Лиги</h4>
                            <a class="btn btn-inverse-warning btn-fw" href="{{route('create_liga')}}">Добавить</a>
                        </div>
                        <br>
                        <br>
                        <div class="table-responsive" bis_skin_checked="1">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> Название </th>
                                    <th> Страна </th>

                                </tr>
                                </thead>
                                @foreach($get as $pr)
                                    <tbody>
                                    <tr>
                                        <td> {{$pr->name}}</td>
                                        <td> {{$pr->country_name->name}}</td>

                                        <td style="display: flex; justify-content: flex-end">
                                            <a  href="{{route('single_page_liga', $pr->id)}}" class="btn btn-inverse-success btn-fw" bis_skin_checked="1">Редактировать</a>
                                            &nbsp;
                                            &nbsp; @if(auth()->user()->id == 1)
                                                <a  href="{{route('delete_liga', $pr->id)}}" class="btn btn-inverse-danger btn-fw" bis_skin_checked="1">Удалить</a>
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