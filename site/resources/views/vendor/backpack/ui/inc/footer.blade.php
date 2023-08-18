@if (config('backpack.base.show_powered_by') || config('backpack.base.developer_link'))
    <div class="text-muted ml-auto mr-auto">
      @if (config('backpack.base.developer_link') && config('backpack.base.developer_name'))
      <a target="_blank" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>
      @endif
      @if (config('backpack.base.show_powered_by'))
      | <a target="_blank" href="http://backpackforlaravel.com?ref=panel_footer_link">Made with Backpack</a>
      @endif
    </div>
@endif
