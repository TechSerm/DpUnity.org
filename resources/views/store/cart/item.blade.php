<tr style="{{ $totalQuantity <= 0 ? 'display: none' : '' }}">
    <td>{{ $item->id }}</td>
    <td><img src="{{ $item->image }}" height="50px" alt=""></td>
    <td>{{ $item->name }}</td>
    <td>
        <button style="padding: 5px" wire:click="increment" class="btn btn-sm btn-primary">+</button>
        {{ convertBanglaNumber($totalQuantity) }}
        <button style="padding: 5px;" wire:click="decrement" class="btn btn-sm btn-danger">-</button>
    </td>
    <td>{{ $item->price }}</td>
    <td>{{ $totalPrice }}</td>
</tr>
