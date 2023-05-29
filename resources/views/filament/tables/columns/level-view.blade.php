<div>
    @php
    $total = \App\CPU\Helpers::getLevel($getState());
    @endphp
    {{ $total['level'] }}
</div>
