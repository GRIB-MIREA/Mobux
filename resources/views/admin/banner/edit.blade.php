@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование баннера</h1>
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
          <form action="{{route('admin.banner.update', $banner->id)}}" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <label for="exampleInputFile">Изменить изображение</label>
              <div class="w-50 mb-3">
                <img src="{{url('storage/' . $banner->image)}}" alt="image" class="w-50">
              </div>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="image">
                  <label class="custom-file-label">Выберите файл</label>
                </div>
                <div class="input-group-append">
                  <span class="input-group-text">Загрузка</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="link" placeholder="Ссылка" value="{{$banner->link}}">
              @error('link')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Обновить">
            </div> 
          </form>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection