<x-filament::page>
  <div class="filament-forms-card-component p-6 bg-white rounded-xl border border-gray-300">
    <div class="filament-page-actions flex flex-wrap items-center gap-4 grid-cols-2 justify-start shrink-0">
      <a class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 basis-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action"
        href="{{ route('reset', [auth()->user()->hasRole(['admin', 'manager'])]) }}" dusk="filament.admin.action.create">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span class="">
          Reset data belanja
        </span>
      </a>
    </div>
  </div>
</x-filament::page>