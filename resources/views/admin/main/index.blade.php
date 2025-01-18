@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Панель управления</h1>
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
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$data['cardCount']}}</h3>
              <p>Магазинов в боте</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{route('admin.card.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{$data['promocodeCount']}}</h3>
              <p>Предложений в боте</p>
            </div>
            <div class="icon">
              <i class="fas fa-ticket-alt"></i>
            </div>
            <a href="{{route('admin.promocode.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$data['categoryCount']}}</h3>
              <p>Категорий в боте</p>
            </div>
            <div class="icon">
              <i class="fas fa-toggle-on"></i>
            </div>
            <a href="{{route('admin.category.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$data['telegramUserCount']}}</h3>
              <p>Людей в рассылке</p>
            </div>
            <div class="icon">
              <i class="fas fa-comment-dots"></i>
            </div>
            <a href="{{route('admin.mail.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection