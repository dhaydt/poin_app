<x-filament::page>
  @php
  $poinHistory = \App\CPU\Helpers::getPoinHistory(app('request')->id);
  $user = \App\Models\User::find(app('request')->id);
  @endphp

  <div wire:id="RYEIxyD0m7RdOyy6dQIi" class="filament-widget col-span-1      filament-account-widget">
    <div class="p-2 space-y-2 bg-white rounded-xl shadow">


      <div class="space-y-2">
        <div class="px-4 py-2 space-y-4">
          <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            <div>
              <h2 class="text-lg sm:text-xl font-bold tracking-tight" style="text-transform: capitalize">
                History Poin {{ $user['name'] }}
              </h2>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div  class="filament-tables-component">
          <div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container">
            <div class="filament-tables-header-container" x-show="hasHeader = (true || selectedRecords.length)">
              <div x-show="true || selectedRecords.length"
                class="filament-tables-header-toolbar flex items-center justify-between p-2 h-14" x-bind:class="{ 'gap-2': false || selectedRecords.length, }">
                <div class="flex items-center gap-2">
                  <div class="filament-dropdown filament-tables-bulk-actions" x-show="selectedRecords.length" style="display: none;">

                    <div x-ref="panel" x-float.placement.bottom-start.flip.offset="{ offset: 8 }"
                      x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95"
                      class="filament-dropdown-panel absolute z-10 w-full divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black/5 transition max-w-[14rem]"
                      style="display: none;">
                      <div class="filament-dropdown-list p-1">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="filament-tables-table-container overflow-x-auto relative border-t" x-bind:class="{ 'rounded-t-xl': ! hasHeader, 'border-t': hasHeader, }">
              <table class="filament-tables-table w-full text-start divide-y table-auto">
                <thead>
                  <tr class="bg-gray-500/5">
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-no">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          No
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-outlet.name">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Outlet
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-user.name">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Customer
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-user.phone">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          No HP
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-admin.name">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Karyawan
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-no-receipt">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          No Receipt
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-pembelian">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Tipe
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-pembelian">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Pembelian
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-poin">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Poin
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-isredeem">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Sudah diredeem ?
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-isexpired">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Sudah expire ?
                        </span>


                      </button>
                    </th>
                    <th class="filament-tables-header-cell p-0 filament-table-header-cell-created-at">
                      <button type="button"
                        class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default ">

                        <span>
                          Tanggal
                        </span>


                      </button>
                    </th>
                  </tr>
                </thead>

                <tbody class="divide-y whitespace-nowrap">
                  @foreach ($poinHistory as $i => $p)
                  <tr class="filament-tables-row transition hover:bg-gray-50" x-bind:class="{ 'bg-gray-50 ': isRecordSelected('37'), }">
                    <td class="filament-tables-reorder-cell w-4 px-4 whitespace-nowrap hidden">
                    </td>
                    <td class="filament-tables-cell filament-table-cell-no">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">
                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                              <span class="">
                                {{ $i+1 }}
                              </span>
                            </div>
                          </div>
                        </a>
                      </div>
                    </td>
                    <td class="filament-tables-cell filament-table-cell-outlet.name">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">
                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                              <span class="">
                                {{ $p['outlet']['name'] }}
                              </span>
                            </div>
                          </div>
                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-user.name"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.user.name"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">
                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                              <span class="">
                                {{ $p['user']['name'] }}
                              </span>
                            </div>
                          </div>
                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-user.phone">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">
                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                              <span class="">
                                {{ $p['user']['phone'] }}
                              </span>
                            </div>
                          </div>

                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-admin.name"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.admin.name"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['user']['name'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-no-receipt"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.no_receipt"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['no_receipt'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-pembelian"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.pembelian"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['type'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>
                    <td class="filament-tables-cell filament-table-cell-pembelian"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.pembelian"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['pembelian'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-poin"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.poin"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['poin'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>

                    <td class="filament-tables-cell filament-table-cell-isredeem">
                      @if ($p['type'] == 'add')
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-icon-column filament-tables-icon-column-size-lg px-4 py-3">
                            @if ($p['isredeem'] == 1)
                            <svg class="text-success-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @else
                            <svg class="text-danger-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                            @endif
                          </div>

                        </a>
                      </div>
                      @endif
                    </td>

                    <td class="filament-tables-cell filament-table-cell-isexpired">
                      @if ($p['type'] == 'add')
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-icon-column filament-tables-icon-column-size-lg px-4 py-3">
                            @if ($p['isexpired'] == 1)
                            <svg class="text-success-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @else
                            <svg class="text-danger-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                            @endif
                          </div>

                        </a>
                      </div>
                      @endif
                    </td>

                    <td class="filament-tables-cell filament-table-cell-created-at"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.record.37.column.created_at"
                      wire:loading.remove.delay="wire:loading.remove.delay"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="filament-tables-column-wrapper">
                        <a href="javascript:"
                          class="flex w-full justify-start text-start">
                          <div class="filament-tables-text-column px-4 py-3">

                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">

                              <span class="">
                                {{ $p['created_at'] }}
                              </span>

                            </div>

                          </div>

                        </a>
                      </div>
                    </td>
                    <td class="w-full px-4 py-4 animate-pulse hidden" colspan="11"
                      wire:loading.class.remove.delay="hidden"
                      wire:key="6OQTcHb2gVaYdyXmJpUC.table.records.37.loading-cell"
                      wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage">
                      <div class="h-4 bg-gray-300 rounded-md"></div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
          </div>

          

        </div>
      </div>

    </div>
  </div>
</x-filament::page>