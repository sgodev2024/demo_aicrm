@extends('Themes.layout_staff.app')

@section('content')
    <style>
        body {
            background: #f5f7fd;
        }

        .search-wrapper {
            position: relative;
        }

        .search-popup {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1050;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .1);
            border-radius: .25rem;
            margin-top: .25rem;
            max-height: 320px;
            overflow: auto;
            display: none;
            /* show via JS */
        }

        .product-row {
            cursor: pointer;
        }

        .product-row:hover {
            background: #f6f9ff;
        }

        .product-thumb {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: .5rem;
        }

        .sticky-summary {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px dashed #e5e7eb;
        }

        .table> :not(caption)>*>* {
            vertical-align: middle;
        }

        .badge-stock {
            font-weight: 500;
        }

        .cart-empty {
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }

        .cart-row {
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
        }

        .cart-thumb {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 4px;
        }

        .cart-info {
            flex: 1;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-subtotal {
            min-width: 100px;
            text-align: right;
        }

        .add-customer-btn {
            font-size: 1.5rem;
            color: #0d6efd;
            cursor: pointer;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .add-customer-btn:hover {
            color: #0a58ca;
            /* xanh đậm hơn */
            transform: scale(1.2);
            /* hơi phóng to khi hover */
        }

        @media (max-width: 576px) {
            .product-thumb {
                width: 40px;
                height: 40px;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- LEFT 9 cols -->
            <div class="col-lg-9">
                <!-- Section: Sản phẩm + search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Tìm & chọn sản phẩm</h5>
                            <span class="text-muted small">Nhập tên, mã hoặc từ khóa…</span>
                        </div>

                        <div class="search-wrapper">
                            <input id="productSearch" type="text" class="form-control" placeholder="Tìm kiếm sản phẩm…"
                                autocomplete="off" />
                            <div id="productPopup" class="search-popup">
                                <!-- Kết quả sản phẩm sẽ render ở đây -->
                                <div id="productList" class="list-group list-group-flush"></div>
                            </div>
                        </div>

                        <div class="mt-3 small text-muted">Gợi ý sẽ xuất hiện khi bạn nhập — bấm vào dòng sản phẩm để thêm
                            vào giỏ.</div>
                    </div>
                </div>

                <!-- Section: Giỏ hàng / tính tiền -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Giỏ hàng</h5>
                            <button id="clearCartBtn" class="btn btn-outline-danger btn-sm">Xóa giỏ</button>
                        </div>

                        <div id="cartBody" class="cart-body"></div>
                        <div id="cartEmptyRow" class="cart-empty text-muted p-3">
                            Chưa có sản phẩm nào. Tìm và chọn ở ô phía trên.
                        </div>

                        <!-- Summary -->
                        <div class="sticky-summary p-3 rounded-bottom">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label mb-1">Khuyến mãi</label>
                                    <div class="input-group">
                                        <input id="discountInput" type="number" class="form-control" min="0"
                                            step="1000" placeholder="Số tiền hoặc %" />
                                        <select id="discountType" class="form-select" style="max-width:120px">
                                            <option value="amount">đ</option>
                                            <option value="percent">%</option>
                                        </select>
                                    </div>
                                    <div class="form-text">Để trống nếu không áp dụng.</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row text-end">
                                        <div class="col-6 col-md-6">
                                            <div class="fw-medium">Tạm tính</div>
                                            <div class="fw-medium">Giảm giá</div>
                                            <div class="fw-bold mt-2">Tổng cuối</div>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <div id="subtotal" class="">0 đ</div>
                                            <div id="discountValue" class="">-0 đ</div>
                                            <div id="grandTotal" class="fw-bold">0 đ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT 3 cols -->
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Khách hàng</h5>
                        <i class="fa-solid fa-circle-plus add-customer-btn" role="button" data-bs-toggle="modal"
                            data-bs-target="#addCustomerModal"></i>
                    </div>

                    <div class="card-body">

                        <div class="mb-2 position-relative border-bottom pb-3">
                            <input id="customerSearch" type="text" class="form-control" placeholder="Tìm khách hàng…"
                                autocomplete="off" />
                            <div id="customerPopup" class="search-popup" style="max-height: 240px;">
                                <div id="customerList" class="list-group list-group-flush"></div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Họ tên</label>
                                <input id="custName" type="text" class="form-control" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input id="custEmail" type="email" class="form-control" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">SĐT</label>
                                <input id="custPhone" type="tel" class="form-control" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Địa chỉ</label>
                                <textarea id="custAddress" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select id="paymentMethod" class="form-select">
                                    <option value="cash">Tiền mặt</option>
                                    <option value="transfer">Chuyển khoản</option>
                                    <option value="cod">Công nợ</option>
                                </select>
                            </div>
                            <input type="hidden" id="custId">
                            <div class="col-12 d-grid">
                                <button class="btn btn-success" id="saveOrderBtn">Lưu đơn</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Ghi chú</h6>
                        <textarea id="orderNote" class="form-control" rows="3" placeholder="Nhập ghi chú cho đơn hàng…"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm khách hàng -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerLabel">Thêm khách hàng mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea class="form-control" name="address" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" form="addCustomerForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hóa Đơn Thanh Toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="invoice-container">

                        <!-- Header -->
                        <div class="text-center invoice-header mb-4">
                            <h2 class="fw-bold text-uppercase">HÓA ĐƠN THANH TOÁN</h2>
                            <h5 class="mt-2">Siêu Thị Thực Phẩm - CH01</h5>
                        </div>

                        <!-- Company Info -->
                        <div class="row mb-3 text-center">
                            <div class="col-sm-4"><strong>Địa chỉ:</strong> Hà Nội</div>
                            <div class="col-sm-4"><strong>Điện thoại:</strong> 0981185620</div>
                            <div class="col-sm-4"><strong>Email:</strong> admin@gmail.com</div>
                        </div>

                        <hr>

                        <!-- Customer Info -->
                        <div class="mb-4">
                            <h6 class="fw-bold">Thông Tin Khách Hàng</h6>
                            <div class="mb-2"><strong>Ngày tạo:</strong> 20/08/2025</div>
                            <div class="mb-2"><strong>Tên khách:</strong> Thảo</div>
                            <div class="mb-2"><strong>SĐT:</strong> 0982172377</div>
                            <div class="mb-2"><strong>Thu ngân:</strong> AICRM</div>
                        </div>

                        <!-- Product Table -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="text-start">Điện thoại Samsung Galaxy S25 Edge 5G 12GB/256GB</td>
                                    <td>1</td>
                                    <td>30,000,000</td>
                                    <td>30,000,000</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Total -->
                        <div class="text-end mt-3">
                            <p><strong>Tổng cộng:</strong> 30,000,000 VND</p>
                            <p><strong>Tổng tiền phải trả:</strong> 30,000,000 VND <br> <em>ba mươi triệu đồng</em></p>
                        </div>

                        <!-- QR Section -->
                        <div class="qr-section text-center my-4">
                            <p>Cảm ơn quý khách!</p>
                            <img src="https://img.vietqr.io/image/MBBANK-1080128122002-compact.png?amount=30000000&addInfo=ThanhToanDonHang123"
                                alt="QR Code" width="180">
                            <p class="mt-2 mb-0"><strong>Ngân hàng TMCP Quân đội:</strong> 1080128122002</p>
                            <p class="mb-0">Ngô Quang Thắng</p>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-dark">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(function() {
            // --------- Helpers ---------
            const money = n => (n || 0).toLocaleString('vi-VN') + ' đ';
            const qs = (s, el = document) => el.querySelector(s);
            const qsa = (s, el = document) => [...el.querySelectorAll(s)];

            function debounce(fn, delay = 500) {
                let timer;
                return function(...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn.apply(this, args), delay);
                };
            }

            // --------- Product Search ---------
            const productSearch = qs('#productSearch');
            const productPopup = qs('#productPopup');
            const productList = qs('#productList');
            let isCallApiProducts = true;
            let isCallApiClients = true;

            let searchTimer = null;
            productSearch.addEventListener('input', debounce((e) => {
                fetchProducts(e.target.value.trim());
            }, 300));

            productSearch.addEventListener('focus', async () => {
                isCallApiProducts && await fetchProducts()

                productPopup.style.display = 'block';
            });

            document.addEventListener('click', (e) => {
                if (!productPopup.contains(e.target) && e.target !== productSearch) {
                    productPopup.style.display = 'none';
                }
            });

            function renderProductResults(products) {

                productList.innerHTML = '';

                if (products.length === 0) {
                    productList.innerHTML =
                        '<div class="list-group-item text-center text-muted">Không tìm thấy sản phẩm</div>';
                    return;
                }

                products.forEach(p => {
                    let image = "{{ config('app.url') }}/" +
                        `storage/${p.images[0].image_path}`;

                    const row = document.createElement('button');
                    row.type = 'button';
                    row.className = 'list-group-item list-group-item-action product-row';
                    row.innerHTML = `
                    <div class="d-flex align-items-center gap-3">
                        <img class="product-thumb" src="${image}" alt="${p.name}" />
                        <div class="flex-grow-1">
                        <div class="fw-semibold">${p.name}</div>
                        <div class="small text-muted">${money(p.priceBuy)}</div>
                        </div>
                        <div class="text-end">
                        <span class="badge border badge-stock text-dark">Tồn: ${p.quantity}</span>
                        </div>
                    </div>`;

                    row.addEventListener('click', () => {
                        addToCart(p);
                        productPopup.style.display = 'none';
                        productSearch.value = '';
                    });
                    productList.appendChild(row);
                });
            }

            // --------- Cart Logic ---------
            const cart = new Map(); // key: productId -> {product, qty}
            const cartBody = qs('#cartBody');
            const cartEmptyRow = qs('#cartEmptyRow');

            function addToCart(product) {
                const item = cart.get(product.id) || {
                    product,
                    qty: 0
                };
                item.qty = Math.min(item.qty + 1, product.quantity);
                cart.set(product.id, item);
                renderCart();
            }

            function removeFromCart(id) {
                cart.delete(id);
                renderCart();
            }

            function updateQty(id, qty) {

                const item = cart.get(id);
                if (!item) return;
                const q = Math.max(1, Math.min(Number(qty) || 1, item.product.quantity));
                item.qty = q;
                cart.set(id, item);
                renderCartTotals();
            }

            function renderCart() {

                cartBody.innerHTML = '';
                if (cart.size === 0) {
                    cartEmptyRow.style.display = '';
                } else {
                    cartEmptyRow.style.display = 'none';


                    for (const [id, {
                            product,
                            qty
                        }] of cart.entries()) {
                        let image = `/storage/${ product.images[0]?.image_path}`;

                        const row = document.createElement('div');
                        row.className = 'cart-row';
                        row.dataset.rowId = id;
                        row.innerHTML = `
                        <img class="cart-thumb" src="${image}" alt="${product.name}">
                        <div class="cart-info">
                        <div class="fw-semibold">${product.name}</div>
                        <div class="small text-muted">Giá: ${money(product.price)}</div>
                        <div class="small text-muted">Tồn kho: ${product.quantity}</div>
                        </div>
                        <div class="cart-actions">
                        <input type="number" min="1" max="${product.stock}" value="${qty}"
                            class="form-control form-control-sm text-center qty-input" style="width: 80px" />
                        <button class="btn btn-sm btn-outline-danger remove-btn">&times;</button>
                        </div>
                    `;
                        qs('.qty-input', row).addEventListener('input', (e) => updateQty(product.id, e.target
                            .value));
                        qs('.remove-btn', row).addEventListener('click', () => removeFromCart(product.id));
                        cartBody.appendChild(row);
                    }
                }
                renderCartTotals();
            }


            // Totals
            const discountInput = qs('#discountInput');
            const discountType = qs('#discountType');
            const subtotalEl = qs('#subtotal');
            const discountValueEl = qs('#discountValue');
            const grandTotalEl = qs('#grandTotal');

            discountInput.addEventListener('input', renderCartTotals);
            discountType.addEventListener('change', renderCartTotals);

            function calcSubtotal() {
                let sum = 0;
                for (const {
                        product,
                        qty
                    }
                    of cart.values()) {

                    sum += product.priceBuy * qty;
                }
                return sum;
            }

            function renderCartTotals() {
                const sub = calcSubtotal();
                console.log(sub);

                let discount = Number(discountInput.value) || 0;
                if (discountType.value === 'percent') {
                    discount = Math.min(100, Math.max(0, discount));
                    discount = Math.round(sub * discount / 100);
                } else {
                    discount = Math.min(discount, sub);
                }
                const grand = Math.max(0, sub - discount);
                subtotalEl.textContent = money(sub);
                discountValueEl.textContent = '-' + money(discount);
                grandTotalEl.textContent = money(grand);
            }

            // Clear cart
            qs('#clearCartBtn').addEventListener('click', () => {
                cart.clear();
                renderCart();
            });

            // --------- Customer search & autofill ---------
            const customerSearch = qs('#customerSearch');
            const customerPopup = qs('#customerPopup');
            const customerList = qs('#customerList');

            customerSearch.addEventListener('input', debounce((e) => {
                fetchClients(e.target.value.trim());
            }, 300));

            customerSearch.addEventListener('focus', () => {
                isCallApiClients && fetchClients();
                customerPopup.style.display = 'block';
            });

            document.addEventListener('click', (e) => {
                if (!customerPopup.contains(e.target) && e.target !== customerSearch) {
                    customerPopup.style.display = 'none';
                }
            });

            function renderCustomerResults(clients) {

                customerList.innerHTML = '';

                if (clients.length === 0) {
                    customerList.innerHTML =
                        '<div class="list-group-item text-center text-muted">Không tìm thấy khách hàng</div>';
                    return;
                }

                clients.forEach(c => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <div>
                        <div class="fw-semibold">${c.name}</div>
                        <div class="small text-muted">${c.email}</div>
                        </div>
                        <div class="text-nowrap small">${c.phone}</div>
                    </div>`;
                    item.addEventListener('click', () => fillCustomer(c));
                    customerList.appendChild(item);
                });
            }

            function fillCustomer(c) {
                qs('#custName').value = c.name;
                qs('#custEmail').value = c.email;
                qs('#custPhone').value = c.phone;
                qs('#custAddress').value = c.address;
                customerPopup.style.display = 'none';
                customerSearch.value = '';
            }

            // Save order (demo)
            qs('#saveOrderBtn').addEventListener('click', () => {
                // Validate: giỏ hàng phải có ít nhất 1 sản phẩm
                if (cart.size === 0) {
                    Toast.fire({
                        icon: "error",
                        title: "Giỏ hàng đang trống! Vui lòng thêm ít nhất 1 sản phẩm!"
                    });
                    return;
                }

                // Validate: thông tin khách hàng
                const name = qs('#custName').value.trim();
                const phone = qs('#custPhone').value.trim();
                const email = qs('#custEmail').value.trim();

                if (!name) {
                    Toast.fire({
                        icon: "error",
                        title: "Vui lòng nhập họ tên khách hàng!"
                    });
                    qs('#custName').focus();
                    return;
                }

                if (!email) {
                    Toast.fire({
                        icon: "error",
                        title: "Vui lòng nhập email khách hàng!"
                    });
                    qs('#custEmail').focus();
                    return;
                }

                if (!phone) {
                    Toast.fire({
                        icon: "error",
                        title: "Vui lòng nhập số điện thoại khách hàng!"
                    });
                    qs('#custPhone').focus();
                    return;
                }

                // Tạo dữ liệu order
                const order = {
                    items: [...cart.values()].map(({
                        product,
                        qty
                    }) => ({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        qty
                    })),
                    subtotal: calcSubtotal(),
                    discountType: discountType.value,
                    discountInput: Number(discountInput.value) || 0,
                    grand: (function() {
                        const sub = calcSubtotal();
                        let d = Number(discountInput.value) || 0;
                        if (discountType.value === 'percent') {
                            d = Math.round(sub * Math.min(100, Math.max(0, d)) / 100);
                        } else {
                            d = Math.min(d, sub);
                        }
                        return sub - d;
                    })(),
                    customer: {
                        id: qs('#custId').value || null,
                        name,
                        email: qs('#custEmail').value.trim(),
                        phone,
                        address: qs('#custAddress').value.trim(),
                        payment: qs('#paymentMethod').value,
                        note: qs('#orderNote')?.value || ''
                    }
                };

                // console.log('ORDER DATA (demo):', order);
                // alert('Đã lưu đơn (demo). Xem dữ liệu trong console của trình duyệt.');
                $('#invoiceModal').modal('show')
            });

            function fetchProducts(searchText) {
                $.ajax({
                    url: '/ban-hang/product',
                    method: 'GET',
                    data: {
                        searchText
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: (res) => {
                        isCallApiProducts = false
                        renderProductResults(res)
                    },
                    error: (xhr) => {
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại sau!')
                    }
                });
            }

            const fetchClients = (searchText) => {
                $.ajax({
                    url: '/ban-hang/get-clients',
                    method: 'GET',
                    data: {
                        searchText
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: (res) => {

                        isCallApiClients = false
                        renderCustomerResults(res)
                    },
                    error: (xhr) => {
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại sau!')
                    }
                });
            }

            $('#addCustomerForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serializeArray();

                $.ajax({
                    url: '/ban-hang/clients/add',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: (res) => {

                        const {
                            data,
                            message
                        } = res

                        $('#custName').val(data.name)
                        $('#custEmail').val(data.email)
                        $('#custPhone').val(data.phone)
                        $('#custAddress').val(data.address)
                        $('#custId').val(data.id)

                        $('#addCustomerModal').modal('hide');
                        $('#addCustomerForm')[0].reset();

                    },
                    error: (xhr) => {
                        Toast.fire({
                            icon: "error",
                            title: xhr.responseJSON.message ||
                                'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
                        });
                    }
                })

            })
        })
    </script>
@endpush
