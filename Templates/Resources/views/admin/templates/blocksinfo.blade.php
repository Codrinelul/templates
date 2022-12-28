@if(is_array($pages)&& count($pages))
    @foreach($pages as $pageId => $page)
        <?php $i =0; ?>
        @foreach($page['blocks'] as $blockId => $block)
            <tr class="row_blocks_info">
                @if($i == 0)
                    <td class="rowContainer" rowspan="{{count($page['blocks'])}}">
                        {{$page['name']}}
                        <input id="{{ $pageId }}" class="changePageCustomRulesBtn custom_options_btn" data-pageid="{{ 'page_' . $pageId }}" data-page="{{ $page['name'] }}" type="button" value="{{ __('Change Page Custom Rules') }}">
                    </td>
                    <?php $i++?>
                @endif
                <td>{{$block['name']}}</td>
                <td>{{$block['type']}}</td>
                <td>
                    @foreach($block['customoptions'] as $key=>$value)
                        {{$key}}={{$value}}<br/>
                    @endforeach
                </td>
                <td>
                    <input data-blockid="{{ 'block_' . $blockId }}" data-pageid="{{ 'page_' . $pageId }}" data-page="{{ $page['name'] }}" class="changeCustomRulesBtn custom_options_btn" data-blocktype="{{ $block['type'] }}" data-blockname="{{ $block['name'] }}"  type="button" value="{{ __('Change Custom Rules') }}" />
                </td>
            </tr>
        @endforeach
    @endforeach
@endif
