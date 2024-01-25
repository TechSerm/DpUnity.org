<style>
    .category {
        border-radius: 5px;
        padding: 10px 15px;
        border: 1px solid #eeeeee;
        display: inline-block;
        background: #f8f8f8;
        margin: 0px 12px 12px 0px;
        border: 1px solid #16a085;
        
    }
    .category:hover{
        background: #f5f5f5;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.01)
    }

    .category a {
        text-decoration: none;
        font-weight: bold;
        color: #000000;
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

        <div class="category">
            <a href="{{ route('store.categories.show', $category) }}">
                {{ $category->name }} ({{ bnConvert()->number($totalProducts) }})
            </a>
        </div>
    @endforeach
</div>

@push('scripts')
    <script></script>
@endpush
