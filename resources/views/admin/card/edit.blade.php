@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование магазина</h1>
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
          <form action="{{route('admin.card.update', $card->id)}}" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Имя" value="{{$card->title}}">
              @error('title')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <textarea type="text" class="form-control" name="description" placeholder="Имя">{{$card->description}}</textarea>
              @error('description')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Изменить изображение</label>
              <div class="w-50 mb-3">
                <img src="{{url('storage/' . $card->image)}}" alt="image" class="w-50">
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
              <input type="text" class="form-control" name="rules" placeholder="Правила акции" value="{{$card->rules}}">
              @error('rules')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="promocode" placeholder="Промокод" value="{{$card->promocode}}">
              @error('promocode')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="reward" placeholder="Награда" value="{{$card->reward}}">
              @error('reward')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="link" placeholder="Ссылка" value="{{$card->link}}">
              @error('link')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="number" class="form-control" name="position" placeholder="Позиция" value="{{$card->position}}">
              @error('position')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="stamp" placeholder="Пометка" value="{{$card->stamp}}">
              @error('stamp')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Выберите категорию</label>
              <select name="category_id" class="form-control">
                @foreach ($categories as $category)
                <option value="{{$category->id}}" {{$category->id == $card->category_id ? 'selected' : '' }}>{{$category->title}}</option>   
                @endforeach
              </select>
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