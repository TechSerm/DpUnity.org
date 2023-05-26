<style>
    .category {
        border-radius: 10px;
        margin: 0px 12px 12px 0px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
    }

    .categoryImg {
        height: auto;
        width: 100%;
        border-radius: 10px;
    }

    @media only screen and (min-width: 768px) {
        .categoryImg {
            height: 130px;
        }
    }

    .categoryText {
        color: #474145;
        font-size: 14px;
        font-weight: 700;
        left: 15%;
        margin-bottom: 0;
        position: absolute;
        top: 45%;
        -webkit-transform: translate(-15%, -50%);
        transform: translate(-15%, -50%);
        width: 50%;

    }
</style>

@php
    $categoryColor = ['#F7E5D7', '#F8F9E9', '#D6CBCD', '#F7F7F7', '#F9EDF1', '#FFFFFF', '#E4EEDB'];
@endphp
<div class="row no-gutters categoryList">
    @foreach ($categories as $key => $category)
        @php
            $totalProducts = $category
                ->products()
                ->where(['status' => 'publish'])
                ->count();
        @endphp
        @if ($totalProducts > 0)
            <div class="col-md-3 col-sm-6 col-lg-3 col-6">
                <div class="category" style="background: {{ $categoryColor[$key % count($categoryColor)] }}">
                    <a href="{{ route('store.categories.show', $category) }}">
                        <div style="">
                            <img src="{{ $category->image }}" class="categoryImg" alt="">
                            <p style="" class="categoryText">{{ $category->name }}
                            </p>
                        </div>
                </div>
                </a>

            </div>
        @endif
    @endforeach
</div>
