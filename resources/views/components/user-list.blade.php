@props(['array', 'groups'])

{{-- @php // перенести в обработчки
    $arGroups = array_combine(
        array_column($groups, 'id'),
        array_column($groups, 'studgroup_id')
    ); 
@endphp --}}

<div {{ $attributes->merge(['class' => 'users-list']) }}>
    @foreach ($array as $item)
        <div class="users-list__item user-item">
            <div class="user-item__name">
                {{ $item['user_lastname'] . ' '. $item['user_firstname'] . $item['user_patronymic'] }}
            </div>

            @if ( $item['studgroup_id'])
                <div class="user-item__group">
                    {{ $groups[$item['studgroup_id']] }}
                </div>
            @else
                <div class="user-item__group">
                    {{ implode(', ', $groups[$item['id']]) }}
                </div>
            @endif
        </div>
    @endforeach
</div>