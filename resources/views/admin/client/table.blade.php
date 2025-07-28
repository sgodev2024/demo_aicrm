<table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
    aria-describedby="basic-datatables_info">
    <thead>
        <tr>
            <th style="width: 3% !important; text-align: center;"><input type="checkbox" id="check-all"></th>
            <th style="width: 5% !important;">STT</th>
            <th style="width: 30% !important;">Tên khách hàng</th>
            {{-- <th style="width: 12% !important;">Nhóm khách hàng</th> --}}
            <th style="width: 12% !important;">Số điện thoại</th>
            <th style="width: 10% !important;">Email</th>
            <th style="width: 10% !important;">Địa chỉ</th>
            <th style="width: 20% !important; text-align: center;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if ($clients && $clients->count() > 0)
            @foreach ($clients as $key => $value)
                @if (is_object($value))
                    <tr>
                        <td style="text-align: center;"><input type="checkbox" class="product-checkbox" value="{{ $value->id }}"></td>
                        <td>{{ ($clients->currentPage() - 1) * $clients->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $value->name ?? '' }}</td>
                        {{-- <td>{{ $value->clientgroup->name ?? '' }}</td> --}}
                        <td>{{ $value->phone ?? '' }}</td>
                        <td>{{ $value->email ?? '' }}</td>
                        <td>{{ $value->address ?? '' }}</td>
                        <td style="text-align: center;">
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.client.detail', ['id' => $value->id]) }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $value->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">
                    <div class="">
                        Chưa có khách hàng
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>
