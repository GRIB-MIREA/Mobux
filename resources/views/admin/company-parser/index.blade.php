@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Парсер компаний</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="row">
        <div class="col-lg-4">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Новый запуск</h3>
            </div>
            <form action="{{ route('admin.company-parser.store') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="city">Город</label>
                  <input id="city" type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Например: Москва" required>
                </div>
                <div class="form-group">
                  <label for="category">Категория</label>
                  <input id="category" type="text" name="category" value="{{ old('category') }}" class="form-control" placeholder="Например: Кофейни" required>
                </div>
                <div class="form-group">
                  <label for="provider">Провайдер</label>
                  <select id="provider" name="provider" class="form-control">
                    @foreach ($providers as $providerKey => $providerLabel)
                      <option value="{{ $providerKey }}" @selected(old('provider', config('company_parser.default_provider')) === $providerKey)>
                        {{ $providerLabel }} ({{ $providerKey }})
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="limit">Лимит результатов</label>
                  <input id="limit" type="number" min="1" max="100" name="limit" value="{{ old('limit', config('company_parser.default_limit', 50)) }}" class="form-control">
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Запустить парсер</button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-4">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $stats['total_companies'] }}</h3>
                  <p>Всего компаний в базе</p>
                </div>
                <div class="icon">
                  <i class="fas fa-building"></i>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ $stats['without_website'] }}</h3>
                  <p>Без указанного сайта</p>
                </div>
                <div class="icon">
                  <i class="fas fa-unlink"></i>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $stats['completed_runs'] }}</h3>
                  <p>Завершенных запусков</p>
                </div>
                <div class="icon">
                  <i class="fas fa-check"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Последние запуски</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Параметры</th>
                    <th>Провайдер</th>
                    <th>Статус</th>
                    <th>Результаты</th>
                    <th>Создан</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($runs as $run)
                    @php
                      $statusClass = match($run->status) {
                        \App\Models\CompanyParserRun::STATUS_COMPLETED => 'success',
                        \App\Models\CompanyParserRun::STATUS_FAILED => 'danger',
                        \App\Models\CompanyParserRun::STATUS_PROCESSING => 'info',
                        default => 'secondary',
                      };
                    @endphp
                    <tr>
                      <td>{{ $run->id }}</td>
                      <td>
                        <div><strong>{{ $run->city }}</strong></div>
                        <div>{{ $run->category }} / лимит {{ $run->result_limit }}</div>
                      </td>
                      <td>{{ $run->provider }}</td>
                      <td>
                        <span class="badge badge-{{ $statusClass }}">{{ $run->status }}</span>
                        @if ($run->error_message)
                          <div class="text-danger small">{{ $run->error_message }}</div>
                        @endif
                      </td>
                      <td>
                        <div>Всего: {{ $run->results_count }}</div>
                        <div>Новых: {{ $run->new_companies_count }}</div>
                        <div>Обновлено: {{ $run->updated_companies_count }}</div>
                      </td>
                      <td>{{ $run->created_at?->format('d.m.Y H:i') }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">Запусков пока нет.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
              {{ $runs->links() }}
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Компании</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('admin.company-parser.index') }}" class="row">
            <div class="col-md-3 mb-3">
              <input type="text" name="company_search" class="form-control" placeholder="Название компании" value="{{ request('company_search') }}">
            </div>
            <div class="col-md-2 mb-3">
              <input type="text" name="city_filter" class="form-control" placeholder="Город" value="{{ request('city_filter') }}">
            </div>
            <div class="col-md-2 mb-3">
              <input type="text" name="category_filter" class="form-control" placeholder="Категория" value="{{ request('category_filter') }}">
            </div>
            <div class="col-md-2 mb-3">
              <select name="provider_filter" class="form-control">
                <option value="">Все провайдеры</option>
                @foreach ($providers as $providerKey => $providerLabel)
                  <option value="{{ $providerKey }}" @selected(request('provider_filter') === $providerKey)>{{ $providerLabel }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3 d-flex align-items-center">
              <div class="form-check">
                <input type="hidden" name="without_website" value="0">
                <input class="form-check-input" type="checkbox" value="1" id="without_website" name="without_website" @checked($withoutWebsite)>
                <label class="form-check-label" for="without_website">
                  Только без сайта
                </label>
              </div>
            </div>
            <div class="col-md-1 mb-3">
              <button type="submit" class="btn btn-primary btn-block">Фильтр</button>
            </div>
          </form>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Компания</th>
                <th>Город</th>
                <th>Категория</th>
                <th>Сайт</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Обновлено</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($companies as $company)
                <tr>
                  <td>{{ $company->id }}</td>
                  <td>
                    <div><strong>{{ $company->name }}</strong></div>
                    <div class="text-muted small">{{ $company->provider }}</div>
                  </td>
                  <td>{{ $company->city }}</td>
                  <td>{{ $company->category }}</td>
                  <td>
                    @if ($company->website)
                      <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a>
                    @else
                      <span class="text-danger">Не указан</span>
                    @endif
                  </td>
                  <td>
                    @if ($company->phone)
                      {{ $company->phone }}
                    @else
                      <div>Не указан</div>
                      @if ($company->map_url)
                        <div class="small mt-1">
                          <a href="{{ $company->map_url }}" target="_blank" rel="noopener noreferrer">Открыть на карте</a>
                        </div>
                      @endif
                    @endif
                  </td>
                  <td>{{ $company->address ?: 'Не указан' }}</td>
                  <td>{{ $company->updated_at?->format('d.m.Y H:i') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center">Компании не найдены.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer clearfix">
          {{ $companies->links() }}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
