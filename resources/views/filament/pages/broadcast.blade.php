<x-filament::page>
  <div class="card p-2 shadow-lg">
    <div class="card-header">
      <h2 class="fw-bold">Broadcast Promo / Pemberitahuan</h2>
    </div>
    <div class="card-body">
      <form action="{{ route('broadcast') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-6">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label fw-bold">Provinsi</label>
              <select name="province" class="form-select" aria-label="Default select example">
                <option value="">--Pilih provinsi tujuan--</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label fw-bold">Kota</label>
              <select class="form-select" name="city" aria-label="Default select example">
                <option value="">--Pilih kota tujuan--</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="" class="form-label fw-bold">Jenis Kelamin</label>
          <div class="">
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="kelamin[]" type="checkbox" id="inlineCheckbox1" value="laki-laki">
              <label class="form-check-label" for="inlineCheckbox1">Laki - laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="kelamin[]" type="checkbox" id="inlineCheckbox2" value="perempuan">
              <label class="form-check-label" for="inlineCheckbox2">Perempuan</label>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="" class="form-label fw-bold">Pekerjaan</label>
          <div class="">
            @php
            $works = \App\CPU\Helpers::getPekerjaan();
            @endphp
            <div class="row">
              @foreach ($works as $w)
              <div class="col-4 col-md-3 col-lg-2 mb-4">
                <div class="form-check form-check-inline mb-2">
                  <input class="form-check-input" name="pekerjaan[]" type="checkbox" id="inlineCheckbox1"
                    value="{{ $w['name'] }}">
                  <label class="form-check-label" for="inlineCheckbox1">{{ $w['name'] }}</label>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
      <button class="btn btn-warning" type="submit">Kirim Broadcast</button>
    </div>
    </form>
  </div>
  </div>
</x-filament::page>