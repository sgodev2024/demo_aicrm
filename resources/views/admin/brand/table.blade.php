<table class="table table-hover">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all"></th>
            <th>ID</th>
            <th>Tên thương hiệu</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($brand as $key => $item)
            <tr>
                <td><input type="checkbox" class="product-checkbox" value="{{ $item->id }}"></td> <!-- Checkbox item -->
                <td>{{ ($brand->currentPage() - 1) * $brand->perPage() + $loop->index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->created_at->format('d/m/Y') ?? '' }}</td>
                <td>
                    <a href="{{ route('admin.brand.edit', $item->id) }}" class="btn btn-warning btn-sm"> <i class="fa-solid fa-pen"></i></a>
                    <button type="button" data-id="{{ $item->id }}"
                        class="btn btn-danger btn-sm btn-delete"> <i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Không có dữ liệu</td>
            </tr>
        @endforelse
    </tbody>
</table>
