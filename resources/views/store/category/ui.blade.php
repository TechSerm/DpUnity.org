<style>
    .category {
        border-radius: 5px;
        padding: 10px 15px;
        border: 1px solid #eeeeee;
        display: inline-block;
        margin: 0px 12px 12px 0px;
        
    }
    .category:hover{
        
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.01)
    }
    .category a{
        text-decoration: none;
    }

    

</style>

@php
    $categoryColor = ['#FDEBDD', '#FCFDEA', '#F7EDF3', '#F1F3DC', '#F9EDF1', '#FFF9E7', '#E4EEDB', '#E4EDEE'];
@endphp

<div class="categoryListt">
    @foreach ($categories as $key => $category)
        @php
            $totalProducts = $category->products->count();
        @endphp

        <div class="category theme-bg">
            <a href="{{ route('store.categories.show', $category) }}">
                {{ $category->name }} ({{ bnConvert()->number($totalProducts) }})
            </a>
        </div>
    @endforeach
</div>

@push('scripts')
    <script></script>
@endpush
