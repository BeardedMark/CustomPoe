<div class="flex-col-8 pos-fixed mar-t-98 mar-r-21 w-auto z-1" style="top: 0; right: 0;">
    <a class="decor-icon-sidebar scroll-portal" href="{{ route('pages.menu') }}"></a>
    
    @isset($info)
        {{-- <a class="decor-icon-sidebar scroll-wisdom cursor-help" onclick="alert('');"></a> --}}
        <a class="decor-icon-sidebar scroll-wisdom cursor-help" onclick="createModal('alert', '{{ $info }}')"></a>
    @endisset
</div>
