@props(['item'])

<div class="{{ $item->isActive() ? '!grid bg-gray-100 dark:bg-gray-950' : '' }} hidden min-w-[180px] ltr:pl-10 rtl:pr-10 pb-2 rounded-b-lg z-[100] overflow-hidden group-[.sidebar-collapsed]/container:!hidden group-[.sidebar-collapsed]/container:fixed group-[.sidebar-collapsed]/container:ltr:!left-[70px] group-[.sidebar-collapsed]/container:rtl:!right-[70px] group-[.sidebar-collapsed]/container:p-[0] group-[.sidebar-collapsed]/container:bg-white dark:group-[.sidebar-collapsed]/container:bg-gray-900 group-[.sidebar-collapsed]/container:border group-[.sidebar-collapsed]/container:ltr:rounded-r-lg group-[.sidebar-collapsed]/container:rtl:rounded-l-lg group-[.sidebar-collapsed]/container:border-gray-300 group-[.sidebar-collapsed]/container:dark:border-gray-800 group-[.sidebar-collapsed]/container:rounded-none group-[.sidebar-collapsed]/container:ltr:shadow-[34px_10px_14px_rgba(0,0,0,0.01),19px_6px_12px_rgba(0,0,0,0.03),9px_3px_9px_rgba(0,0,0,0.04),2px_1px_5px_rgba(0,0,0,0.05),0px_0px_0px_rgba(0,0,0,0.05)] group-[.sidebar-collapsed]/container:rtl:shadow-[-34px_10px_14px_rgba(0,0,0,0.01),-19px_6px_12px_rgba(0,0,0,0.03),-9px_3px_9px_rgba(0,0,0,0.04),-2px_1px_5px_rgba(0,0,0,0.05),-0px_0px_0px_rgba(0,0,0,0.05)] group-[.sidebar-collapsed]/container:group-hover/item:!grid group-[.inactive]/item:hidden group-[.inactive]/item:fixed group-[.inactive]/item:ltr:left-[270px] group-[.inactive]/item:rtl:right-[270px] group-[.inactive]/item:p-[0] group-[.inactive]/item:bg-white dark:group-[.inactive]/item:bg-gray-900 group-[.inactive]/item:border group-[.inactive]/item:ltr:rounded-r-lg group-[.inactive]/item:rtl:rounded-l-lg group-[.inactive]/item:border-gray-300 group-[.inactive]/item:dark:border-gray-800 group-[.inactive]/item:rounded-none group-[.inactive]/item:ltr:shadow-[34px_10px_14px_rgba(0,0,0,0.01),19px_6px_12px_rgba(0,0,0,0.03),9px_3px_9px_rgba(0,0,0,0.04),2px_1px_5px_rgba(0,0,0,0.05),0px_0px_0px_rgba(0,0,0,0.05)] group-[.inactive]/item:rtl:shadow-[-34px_10px_14px_rgba(0,0,0,0.01),-19px_6px_12px_rgba(0,0,0,0.03),-9px_3px_9px_rgba(0,0,0,0.04),-2px_1px_5px_rgba(0,0,0,0.05),-0px_0px_0px_rgba(0,0,0,0.05)] group-[.inactive]/item:group-hover/item:!grid">
    @foreach ($item->items() as $child)
        <a
            href="{{ $child->url() }}" {!! $child->isBlank() ? 'target="_blank"' : '' !!}
            class="text-sm text-{{ $child->isActive() ? 'blue':'gray' }}-600 dark:text-{{ $child->isActive() ? 'blue':'gray' }}-300 whitespace-nowrap py-1 group-[.sidebar-collapsed]/container:px-5 group-[.sidebar-collapsed]/container:py-2.5 group-[.inactive]/item:px-5 group-[.inactive]/item:py-2.5 hover:text-blue-600 dark:hover:bg-gray-950"
        >
            {{ $child->label() }}
        </a>
    @endforeach
</div>