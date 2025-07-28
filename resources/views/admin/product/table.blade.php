<!-- resources/views/admin/product/table.blade.php -->
<table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
    aria-describedby="basic-datatables_info">
    <thead>
        <tr role="row">
            <th style="width: 5%"><input type="checkbox" id="check-all"></th>
            <th style="width: 5%">STT</th>
            <th style="width: 20%">Tên sản phẩm</th>
            <th style="width: 15%">Thương hiệu</th>
            <th style="width: 10%">Số lượng</th>
            <th style="width: 15%">Giá nhập</th>
            <th style="width: 15%">Giá bán</th>
            <th style="width: 15%; text-align: center">Hành động</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($product as $key => $value)
            <tr id="product-{{ $value->id }}">
                <td><input type="checkbox" class="product-checkbox" value="{{ $value->id }}"></td> <!-- Checkbox item -->
                <td>{{ ($product->currentPage() - 1) * $product->perPage() + $loop->index + 1 }}</td>
                <td>{{ $value->name ?? '' }}</td>
                <td>{{ $value->brands->name ?? '' }}</td>
                
                <td>{{ $value->quantity ?? '0' }}</td>
                <td>{{ number_format($value->price) ?? '' }} đ</td>
                <td>{{ number_format($value->priceBuy) ?? '' }} đ</td>
                <td align="center">
                    <a class="btn btn-warning" href="{{ route('admin.product.edit', ['id' => $value->id]) }}">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <button class="btn btn-danger btn-delete" data-id="{{ $value->id }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
{{-- <div id="pagination">
    {{ $product->links('vendor.pagination.custom') }}
</div> --}}
