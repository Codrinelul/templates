@php
    $availableVars = [];
@endphp
@foreach ($pdfVars as $blocks)
    @foreach ($blocks as $vars)
        @foreach ($vars as $var => $varValue)
            @if (Str::startsWith(strtolower($var), 'variable'))
                @php
                    $availableVars[] = $varValue;
                @endphp
            @endif
        @endforeach
    @endforeach
@endforeach
@php
    /* $list->items->sortBy(function($model) use ($order){
        return array_search($model->getKey(), $order);
    } */
    $variables = $variables->whereIn('name', $availableVars);
@endphp
<ul id="variable_list">
    @foreach ($variables as $variable)
        <li data-variable="{{ $variable->id }}"><span class="fa fa-arrows-v"></span>{{ $variable->name }}</li>
    @endforeach
</ul>
