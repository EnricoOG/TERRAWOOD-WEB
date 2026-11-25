{{--
    Pagination bergaya TERRAWOOD.
    Pemakaian: {{ $products->links('vendor.pagination.terrawood') }}
--}}
@include('partials.i18n')
@if ($paginator->hasPages())

    <nav class="tw-pagination" role="navigation" aria-label="{{ t3('Navigasi halaman', 'Page navigation', '分页导航') }}">
        <ul>

            {{-- Halaman sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="is-disabled" aria-disabled="true">
                    <span aria-label="{{ t3('Halaman sebelumnya', 'Previous page', '上一页') }}">‹</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ t3('Halaman sebelumnya', 'Previous page', '上一页') }}">‹</a>
                </li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="is-dots" aria-hidden="true">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())
                            <li class="is-active" aria-current="page">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" aria-label="{{ t3('Ke halaman ' . $page, 'Go to page ' . $page, '前往第 ' . $page . ' 页') }}">{{ $page }}</a>
                            </li>
                        @endif

                    @endforeach
                @endif

            @endforeach

            {{-- Halaman berikutnya --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ t3('Halaman berikutnya', 'Next page', '下一页') }}">›</a>
                </li>
            @else
                <li class="is-disabled" aria-disabled="true">
                    <span aria-label="{{ t3('Halaman berikutnya', 'Next page', '下一页') }}">›</span>
                </li>
            @endif

        </ul>
    </nav>

    @once
    @push('styles')
    <style>
        .tw-pagination {
            display: flex;
            justify-content: center;
        }

        .tw-pagination ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tw-pagination li a,
        .tw-pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 12px;
            border: 1.5px solid #E3DDCF;
            border-radius: 999px;
            background: #fff;
            color: #082744;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            transition:
                background-color .25s cubic-bezier(.22, .61, .36, 1),
                border-color .25s cubic-bezier(.22, .61, .36, 1),
                color .25s cubic-bezier(.22, .61, .36, 1),
                transform .25s cubic-bezier(.22, .61, .36, 1);
        }

        .tw-pagination li a:active {
            transform: scale(.94);
        }

        @media (hover: hover) {
            .tw-pagination li a:hover {
                border-color: #F5A623;
                background: #FFF9F0;
            }
        }

        .tw-pagination li a:focus-visible {
            outline: 2px solid #F5A623;
            outline-offset: 3px;
        }

        .tw-pagination .is-active span {
            border-color: #082744;
            background: #082744;
            color: #fff;
        }

        .tw-pagination .is-disabled span {
            opacity: .4;
        }

        .tw-pagination .is-dots span {
            min-width: auto;
            padding: 0 4px;
            border-color: transparent;
            background: transparent;
        }

        @media (max-width: 430px) {
            .tw-pagination ul {
                gap: 6px;
            }

            .tw-pagination li a,
            .tw-pagination li span {
                min-width: 38px;
                height: 38px;
                padding: 0 10px;
                font-size: 13px;
            }
        }
    </style>
    @endpush
    @endonce

@endif