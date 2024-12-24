@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление нового магазина</h1>
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
          <form action="{{ route('admin.card.store') }}" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Название магазина" value="{{old('title')}}">
              @error('title')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="description" placeholder="Описание магазина" value="{{old('description')}}">
              @error('description')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Добавить логотип</label>
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
              <input type="text" class="form-control" name="rules" placeholder="Правила акции" value="{{old('rules')}}">
              @error('rules')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="promocode" placeholder="Промокод" value="{{old('promocode')}}">
              @error('promocode')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="reward" placeholder="Награда" value="{{old('reward')}}">
              @error('reward')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="link" placeholder="Ссылка" value="{{old('link')}}">
              @error('link')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="number" class="form-control" name="position" placeholder="Позиция" value="{{old('position')}}">
              @error('position')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="stamp" placeholder="Пометка" value="{{old('stamp')}}">
              @error('stamp')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Выберите категорию</label>
              <select name="category_id" class="form-control">
                @foreach ($categories as $category)
                <option value="{{$category->id}}" {{$category->id == old('category_id') ? 'selected' : '' }}>{{$category->title}}</option>   
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Добавить">
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