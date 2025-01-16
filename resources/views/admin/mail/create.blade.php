@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Создание рассылки</h1>
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
          <form action="{{ route('admin.mail.send') }}" method="POST" class="w-100">
            @csrf
            <div class="form-group">
              <label>Напишите текст рассылки</label>
              <textarea id="summernote" name="message">{{old('message')}}</textarea>
              @error('message')
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