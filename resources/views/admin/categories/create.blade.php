@extends('admin.layout')

@section('content')
!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Добавить категорию
            <small>приятные слова..</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            {{ Form::open(['route' => 'categories.store']) }}
            <div class="box-header with-border">
                <h3 class="box-title">Добавляем категорию</h3>
            @include('admin.errors')
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Название</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success pull-right">Добавить</button>
                {{ Form::close() }}
                <a class="btn btn-default" href="{{route('categories.index')}}">Назад</a>
            </div>

            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection