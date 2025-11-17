

@if($page_count>1)
<div class="col-12 pb-1">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-3">

            {{-- Previous Button --}}
            @if($page > 0)
                <li class="page-item">
                    <a class="page-link" href="{{url('/'.$link.'/'.$page-1)}}"  aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">{{__('front.previous')}}</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">{{__('front.previous')}}</span>
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @for($i = 0; $i < $page_count; $i++)
                <li class="page-item @if($i == $page) active @endif">
                    <a class="page-link"  href="{{url('/'.$link.'/'.$i)}}" >{{ $i + 1 }}</a>
                </li>
            @endfor

            {{-- Next Button --}}
            @if($page + 1 < $page_count)
                <li class="page-item">
                    <a class="page-link"  href="{{url('/'.$link.'/'.$page+1)}}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">{{__('front.next')}}</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">{{__('front.next')}}</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>

@endif