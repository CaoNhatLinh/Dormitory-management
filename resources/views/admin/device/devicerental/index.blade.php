    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Danh sách thiết bị</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="deviceTable"
                                class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                                <thead>
                                    <tr class="title">
                                        <th>Device ID</th>
                                        <th>Device Name</th>
                                        <th>Quantity</th>
                                        <th>Original Price</th>
                                        <th>Device Type</th>
                                        <th>Rental Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['devices'] as $device)
                                    <tr>
                                        <td>{{ $device->device_id }}</td>
                                        <td>{{ $device->device_name }}</td>
                                        <td>{{ $device->quantity }}</td>
                                        <td>{{ number_format($device->original_price, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ $device->deviceType->device_type_name }}</td>
                                        <td>ddddđ</td>
                                        <td>
                                            <a class="text-size-lg me-2 rent-btn"
                                                data-device-id="{{ $device->device_id }}" href="#">
                                                <img style="width:24px;height:24px;margin-bottom:8px"
                                                    src="{{ asset('images/rent.png') }}" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thiết bị cho thuê</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="cartTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Device Name</th>
                                        <th>Quantity</th>
                                        <th>Sale Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cartBody">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                        <td id="totalAmount">0 VNĐ</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="form-inline-end">
                                Chọn phòng: <select id="roomSelect" class="form-control me-2"></select>
                                <button id="rentButton" class="btn btn-primary">Cho thuê</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/rooms')
        .then(response => response.json())
        .then(data => {
            const rooms = data.rooms;
            const roomSelect = document.getElementById('roomSelect');
            rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.room_id;
                option.textContent = room.room_name;
                roomSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi khi lấy phòng:', error));

    document.querySelectorAll('.rent-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const deviceId = this.getAttribute('data-device-id');
            const deviceRow = this.closest('tr');
            const deviceName = deviceRow.querySelector('td:nth-child(2)').innerText;
            const quantityAvailable = parseInt(deviceRow.querySelector('td:nth-child(3)')
                .innerText); // Số lượng tồn kho
            const originalPrice = parseInt(deviceRow.querySelector('td:nth-child(4)').innerText
                .replace(/[^0-9]/g, '')); // Giá gốc
            const salePrice = Math.ceil(originalPrice * 0.5); // Giá bán (hơn 10% giá gốc)
            const cartBody = document.getElementById('cartBody');
            let existingRow = cartBody.querySelector(`tr[data-device-id="${deviceId}"]`);

            if (existingRow) {
                const quantityInput = existingRow.querySelector('.quantity-input');
                let quantity = parseInt(quantityInput.value) + 1;
                if (quantity <= quantityAvailable) {
                    quantityInput.value = quantity;
                    updateTotalPrice(existingRow, salePrice);
                } else {
                    alert('Thiết bị đã hết hàng');
                }
            } else {
                const newRow = `
                        <tr data-device-id="${deviceId}">
                            <td>${deviceName}</td>
                            <td class="rental-quantity">
                                <input type="number" class="form-control quantity-input" value="1" min="1" max="${quantityAvailable}">
                            </td>
                            <td class="sale-price">${salePrice.toLocaleString('vi-VN')} VNĐ</td>
                            <td class="total-price">${salePrice.toLocaleString('vi-VN')} VNĐ</td>
                            <td>
                                <button class="btn btn-danger remove-btn">Xóa</button>
                            </td>
                        </tr>`;
                cartBody.insertAdjacentHTML('beforeend', newRow);

                const newRowElement = cartBody.querySelector(
                    `tr[data-device-id="${deviceId}"]`);
                const removeButton = newRowElement.querySelector('.remove-btn');
                removeButton.addEventListener('click', function() {
                    this.closest('tr').remove();
                    updateTotalAmount();
                });

                const quantityInput = newRowElement.querySelector('.quantity-input');
                quantityInput.addEventListener('change', function() {
                    const quantity = parseInt(this.value);
                    if (quantity < 1) {
                        this.value = 1;
                    } else if (quantity > quantityAvailable) {
                        this.value = quantityAvailable;
                        alert('Thiết bị đã hết hàng');
                    }
                    updateTotalPrice(newRowElement, salePrice);
                });
            }

            updateTotalAmount();
        });
    });

    function updateTotalPrice(row, salePrice) {
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const totalPrice = quantity * salePrice;
        row.querySelector('.total-price').innerText = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
        updateTotalAmount();
    }

    function updateTotalAmount() {
        const cartBody = document.getElementById('cartBody');
        let totalAmount = 0;
        cartBody.querySelectorAll('tr').forEach(row => {
            const totalPrice = parseInt(row.querySelector('.total-price').innerText.replace(/[^0-9]/g,
                ''));
            totalAmount += totalPrice;
        });
        document.getElementById('totalAmount').innerText = totalAmount.toLocaleString('vi-VN') + ' VNĐ';
    }

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const quantity = parseInt(this.value);
            const maxQuantity = parseInt(this.getAttribute('max'));
            if (quantity < 1) {
                this.value = 1;
            } else if (quantity > maxQuantity) {
                this.value = maxQuantity;
                alert('Thiết bị đã hết hàng');
            }
            const row = this.closest('tr');
            const salePrice = parseInt(row.querySelector('.sale-price').innerText.replace(
                /[^0-9]/g, ''));
            updateTotalPrice(row, salePrice);
        });
    });
});
</script>