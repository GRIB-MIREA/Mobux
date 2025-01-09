@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование пометки</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-12">
          <form action="{{route('admin.stamp.update', $stamp->id)}}" method="POST" class="w-100">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Название пометки" value="{{$stamp->title}}">
              @error('title')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="icon" placeholder="Иконка" value="{{$stamp->icon}}">
              @error('icon')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="color" placeholder="Цвет иконки" value="{{$stamp->color}}">
              @error('color')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Обновить">
          </form>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection