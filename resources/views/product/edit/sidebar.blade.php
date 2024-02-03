<div class="card">
    <div class="card-header">
        Product Edit Option
    </div>
    <div class="card-body">
        <a  class="btn btn-secondary" style="width: 100%" href="{{route('products.edit', request()->route()->parameters())}}">General</a>
        <a  class="btn btn-primary active mt-1" style="width: 100%" href="">Media</a>
        <a  class="btn btn-secondary mt-1" style="width: 100%" href="">Stock and Price</a>
    </div>
</div>