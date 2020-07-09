@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">
        <div class="border" style="padding: 10px">
            <h3 id="id">Изменение автора № {{$data->id}}</h3>
            <hr>
            <form id="authorEditForm" onsubmit="editAuthor({{$data->id}})" enctype="multipart/form-data"
                  action="javascript:void(null);">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="surname" class="col-sm-2 col-form-label">Фамилия</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="surname" name="surname" value="{{$data->surname}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Имя</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="name" name="name" value="{{$data->name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="middlename" class="col-sm-2 col-form-label">Отчество</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="middlename" name="middlename" value="{{$data->middlename}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
