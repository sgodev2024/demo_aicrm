<table id="basic-datatables" class="display table table-striped table-hover" role="grid">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all"></th>
            <th>Mã kho hàng</th>
            <th>Tên kho hàng</th>
            <th>Địa điểm</th>
            <th></th>
        </tr>
    </thead>
    @if ($storages->count() > 0)
        <tbody>
            @foreach ($storages as $key => $value)
                <tr id="category-{{ $value->id }}">
                    <td><input type="checkbox" class="product-checkbox" value="{{ $value->id }}"></td> <!-- Checkbox item -->
                    <td>{{ ($storages->currentPage() - 1) * $storages->perPage() + $loop->index + 1 }}</td>
                    <td><a style="color: black; font-weight: bold"
                        href="{{ route('admin.storage.products', ['id' => $value->id]) }}">
                        {{ $value->name }}</a></td>
                    <td>{{ $value->location }}</td>
                    <td style="text-align:center">
                        <a class="btn btn-warning" href="{{ route('admin.storage.detail', ['id' => $value->id]) }}"><i
                                class="fa-solid fa-pen"></i></a>
                        <button class="btn btn-danger btn-delete" data-id="{{ $value->id }}"><i
                                class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @else
        <tbody>
            <tr>
                <td class="text-center" colspan="4">Không tìm thấy kho hàng</td>
            </tr>
        </tbody>
    @endif
</table>
