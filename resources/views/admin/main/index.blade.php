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
              <h3>123</h3>
              <p>Фото в портфолио</p>
            </div>
            <div class="icon">
              <i class="fas fa-image"></i>
            </div>
            <a href="{{route('admin.portfolio.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-success">
            <div class="inner">
              <h3>123</h3>
              <p>Отзывы</p>
            </div>
            <div class="icon">
              <i class="fas fa-comments"></i>
            </div>
            <a href="{{route('admin.feedback.index')}}" class="small-box-footer">Смотреть все <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection