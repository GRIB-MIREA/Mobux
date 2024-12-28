@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление пользователя</h1>
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
          <form action="{{ route('admin.user.store') }}" method="POST" class="w-100">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" name="name" placeholder="Имя" value="{{old('name')}}">
              @error('name')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="last_name" placeholder="Фамилия" value="{{old('last_name')}}">
              @error('last_name')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
              @error('email')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="password" placeholder="Пароль">
              @error('password')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="telegram_id" placeholder="Telegram ID" value="{{old('telegram_id')}}">
              @error('telegram_id')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="telegram_username" placeholder="Telegram Username" value="{{old('telegram_username')}}">
              @error('telegram_username')
                <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Выберите роль</label>
              <select name="role" class="form-control">
                @foreach ($roles as $id => $role)
                <option value="{{$id}}">{{$role}}</option>   
                @endforeach
              </select>
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