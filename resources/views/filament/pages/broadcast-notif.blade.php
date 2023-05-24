<x-filament::page>
  <form class="filament-form space-y-6" action="{{ route('broadcast') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1      filament-forms-component-container gap-6">
      <div class="col-span-full">
        <div>
          <div class="grid grid-cols-1   lg:grid-cols-2   filament-forms-component-container gap-6">
            <div class="col-span-full">
              <div class="filament-forms-card-component p-6 bg-white rounded-xl border border-gray-300">
                <div class="grid grid-cols-1   lg:grid-cols-2   filament-forms-component-container gap-6">
                  <div class="col-span-1" wire:key="e15jt53F2Qq35tajnsEz.data.name.Filament\Forms\Components\TextInput">
                    <div class="filament-forms-field-wrapper">
                      <div class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                          <label
                            class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse"
                            for="data.name">
                            <span class="text-sm font-medium leading-4 text-gray-700">
                              Provinsi<span class="whitespace-nowrap">
                              </span>
                            </span>
                          </label>
                        </div>
                        <div
                          class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                          @php
                            $country = \KodePandai\Indonesia\Models\Province::all();
                          @endphp
                          <div class="flex-1">
                            <select name="province_id"
                              class="filament-forms-input text-gray-900 block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300">
                              <option value="">Semua</option>
                              @foreach ($country as $c)
                              <option value="{{ $c['code'] }}">{{ $c['name'] }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-span-1" wire:key="e15jt53F2Qq35tajnsEz.data.name.Filament\Forms\Components\TextInput">
                    <div class="filament-forms-field-wrapper">

                      <div class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                          <label
                            class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse"
                            for="data.name">
                            <span class="text-sm font-medium leading-4 text-gray-700">
                              Kota<span class="whitespace-nowrap">
                              </span>
                            </span>
                          </label>
                        </div>
                        @php
                            $city = \KodePandai\Indonesia\Models\City::all();
                          @endphp
                        <div
                          class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                          <div class="flex-1">
                            <select name="city_id"
                              class="filament-forms-input text-gray-900 block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300">
                              <option value="">Semua</option>
                              @foreach ($city as $c)
                              <option value="{{ $c['code'] }}">{{ $c['name'] }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-span-2"
                    wire:key="e15jt53F2Qq35tajnsEz.data.phone.Filament\Forms\Components\TextInput">
                    <div class="filament-forms-field-wrapper">
                      <div class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                          <label
                            class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse"
                            for="data.phone">
                            <span class="text-sm font-medium leading-4 text-gray-700">
                              Kelamin<span class="whitespace-nowrap">
                              </span>
                            </span>
                          </label>
                        </div>
                        <div
                          class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                          <div class="flex-1">
                            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                  <div class="flex items-center pl-3">
                                      <input id="vue-checkbox-list" type="checkbox" value="laki-laki" name="kelamin[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                      <label for="vue-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Laki - Laki</label>
                                  </div>
                              </li>
                              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                  <div class="flex items-center pl-3">
                                      <input id="react-checkbox-list" type="checkbox" value="perempuan" name="kelamin[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                      <label for="react-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Perempuan</label>
                                  </div>
                              </li>
                          </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-span-2"
                  wire:key="e15jt53F2Qq35tajnsEz.data.phone.Filament\Forms\Components\TextInput">
                  <div class="filament-forms-field-wrapper">
                    <div class="space-y-2">
                      <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                        <label
                          class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse"
                          for="data.phone">
                          <span class="text-sm font-medium leading-4 text-gray-700">
                            Pekerjaan<span class="whitespace-nowrap">
                            </span>
                          </span>
                        </label>
                      </div>
                      @php
                        $works = \App\Models\Work::get();
                      @endphp
                      <div
                        class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                        <div class="flex-1">
                          <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach ($works as $w)
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-2">
                                    <input type="checkbox" value="{{ $w['name'] }}" name="pekerjaan[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $w['name'] }}</label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div>
      <div class="filament-page-actions flex flex-wrap items-center gap-4 justify-end filament-form-actions">
        <button type="submit" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="animate-spin filament-button-icon w-5 h-5 mr-1 -ml-2 rtl:ml-1 rtl:-mr-2"
            wire:loading.delay="wire:loading.delay" wire:target="create">
            <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
              d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
              fill="currentColor"></path>
            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
          </svg>

          <span class="flex items-center gap-1">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              class="animate-spin filament-button-icon w-5 h-5 mr-1 -ml-2 rtl:ml-1 rtl:-mr-2" x-show="isUploadingFile"
              style="display: none;">
              <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
                d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                fill="currentColor"></path>
              <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
            </svg>

            <span x-show="! isUploadingFile" class="">
              Kirim Broadcast
            </span>
          </span>
        </button>
      </div>
    </div>
  </form>
</x-filament::page>