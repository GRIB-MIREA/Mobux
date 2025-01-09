@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление пометки</h1>
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
          <form action="{{ route('admin.stamp.store') }}" method="POST" class="w-100">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Название пометки">
              @error('title')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="icon" placeholder="Иконка">
              <p>Заполнить поле атрибутом d="<b>ТЕМ ЧТО ТУТ НАПИСАНО</b>" из тега patch</p>
              <a href="https://flowbite.com/icons/" target="_blank">Иконки тут</a>
              @error('icon')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="color" placeholder="Цвет иконки">
              <p>Заполнять поле в формате цветов Tailwind, например blue-500</p>
              <a href="https://tailwindcss.com/docs/customizing-colors" target="_blank">Все цвета тут</a>
              @error('color')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Добавить">
          </form>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection