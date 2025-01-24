@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование промокода</h1>
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
          <form action="{{route('admin.promocode.update', $promocode->id)}}" method="POST" class="w-100">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Название промокода" value="{{$promocode->title}}">
              @error('title')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="reward" placeholder="Награда" value="{{$promocode->reward}}">
              @error('reward')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="link" placeholder="Ссылка" value="{{$promocode->link}}">
              @error('link')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Выберите магазин</label>
              <select name="card_id" class="form-control">
                @foreach ($cards as $card)
                <option value="{{$card->id}}" {{$card->id == $promocode->card_id ? 'selected' : '' }}>{{$card->title}}</option>   
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="date" class="form-control" name="expiration_date" placeholder="Срок действия" value="{{$promocode->expiration_date}}">
              @error('expiration_date')
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