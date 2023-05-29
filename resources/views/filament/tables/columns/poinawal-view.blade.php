<div class="">
    @php
    $user = \App\Models\Poin::find($getState());
    $total = \App\CPU\Helpers::poinAwal($user['user_id']);
    @endphp
    {{ $total }}
</div>