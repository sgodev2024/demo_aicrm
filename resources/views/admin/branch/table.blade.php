<table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
    aria-describedby="basic-datatables_info">
    <thead>
        <tr role="row">
            <th style="width: 10px;"><input type="checkbox"  id="check-all"></th>
            <th class="" tabindex="0" style="width: 10px;" aria-controls="basic-datatables" rowspan="1" colspan="1" >STT </th>
            <th class="" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                style="width: 150.375px;">Tên chi nhánh </th>
            <th class="" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                style="width: 120.2656px;"> Hoạt động
            </th>
        </tr>
    </thead>

    <tbody>
        @if ($user->count())
            @foreach ($user as $key => $item)
                <tr>
                    <td><input type="checkbox" class="product-checkbox" value="{{ $item->id }}"></td> <!-- Checkbox item -->
                    <td>{{ ($user->currentPage() - 1) * $user->perPage() + $loop->index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->status_text  }}</td>
                    
                    <td style="display: flex;">
                        <a style="margin-right: 20px" class="btn btn-warning"
                            href="{{ route('admin.branch.edit', ['id' => $item->id]) }}"> <i class="fa-solid fa-pen"></i></a>
                        <button class="btn btn-danger btn-delete" data-id="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">
                    <div class="">
                        Không có chi nhánh
                    </div>
                </td>
            </tr>
        @endif
    </tbody>

</table>
