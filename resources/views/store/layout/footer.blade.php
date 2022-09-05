<footer class="mt-auto fixedFooter">
    <style>
        .fixedFooter {
            position: fixed;
            top: 95%;
            background: #000000;
            width: 100%;
            color: #ffffff;
            padding: 5px 20px 5px 20px;
        }
    </style>
    @if ($totalCart > 0)
        {{$totalCart}} Menu Search
    @else
         Menu Search
    @endif
    <a href="/cart">Cart</a>

</footer>