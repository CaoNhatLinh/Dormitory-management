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

    const deviceRentCount = {};

    document.querySelectorAll('.rent-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const deviceId = this.getAttribute('data-device-id');
            const deviceRow = this.closest('tr');
            const deviceName = deviceRow.querySelector('td:nth-child(2)').innerText;
            const quantityAvailable = parseInt(deviceRow.querySelector('td:nth-child(3)').innerText);
            const deviceQuantityRented = parseInt(deviceRow.querySelector('td:nth-child(6)').innerText);
            const remainingQuantity = quantityAvailable - deviceQuantityRented;

            if (!deviceRentCount[deviceId]) {
                deviceRentCount[deviceId] = 0;
            }

            if (deviceRentCount[deviceId] >= remainingQuantity) {
                alert('Thiết bị đã hết hàng');
                return;
            }

            const originalPrice = parseInt(deviceRow.querySelector('td:nth-child(4)').innerText.replace(/[^0-9]/g, ''));
            const salePrice = Math.ceil(originalPrice * 0.5);
            const cartBody = document.getElementById('cartBody');
            let existingRow = cartBody.querySelector(`tr[data-device-id="${deviceId}"]`);

            if (existingRow) {
                const quantityInput = existingRow.querySelector('.quantity-input');
                let quantity = parseInt(quantityInput.value) + 1;
                if (quantity <= remainingQuantity) {
                    quantityInput.value = quantity;
                    updateTotalPrice(existingRow, salePrice);
                } else {
                    alert('Thiết bị đã hết hàng');
                    return;
                }
            } else {
                const newRow = `
                    <tr data-device-id="${deviceId}">
                        <td>${deviceName}</td>
                        <td class="rental-quantity">
                            <input type="hidden" name="device_id[]" value="${deviceId}">
                            <input type="hidden" name="device_name[]" value="${deviceName}">
                            <input type="hidden" name="quantity_available[]" value="${quantityAvailable}">
                            <input type="hidden" name="original_price[]" value="${originalPrice}">
                            <input type="number" class="form-control quantity-input" name="rental_quantity[]" value="1" min="1" max="${remainingQuantity}">
                        </td>
                        <td class="sale-price">${salePrice.toLocaleString('vi-VN')} VNĐ</td>
                        <td class="total-price">${salePrice.toLocaleString('vi-VN')} VNĐ</td>
                        <td>
                            <button class="btn btn-danger remove-btn">Xóa</button>
                        </td>
                    </tr>`;
                cartBody.insertAdjacentHTML('beforeend', newRow);

                const newRowElement = cartBody.querySelector(`tr[data-device-id="${deviceId}"]`);
                const removeButton = newRowElement.querySelector('.remove-btn');
                removeButton.addEventListener('click', function() {
                    deviceRentCount[deviceId]--;
                    this.closest('tr').remove();
                    updateTotalAmount();
                });

                const quantityInput = newRowElement.querySelector('.quantity-input');
                quantityInput.addEventListener('change', function() {
                    const quantity = parseInt(this.value);
                    if (quantity < 1) {
                        this.value = 1;
                    } else if (quantity > remainingQuantity) {
                        this.value = remainingQuantity;
                        alert('Thiết bị đã hết hàng');
                    }
                    updateTotalPrice(newRowElement, salePrice);
                });
            }

            deviceRentCount[deviceId]++;
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
            const totalPrice = parseInt(row.querySelector('.total-price').innerText.replace(/[^0-9]/g, ''));
            totalAmount += totalPrice;
        });
        document.getElementById('totalAmount').innerText = totalAmount.toLocaleString('vi-VN') + ' VNĐ';
        document.getElementById('totalAmountInput').value = totalAmount;
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
            const salePrice = parseInt(row.querySelector('.sale-price').innerText.replace(/[^0-9]/g, ''));
            updateTotalPrice(row, salePrice);
        });
    });
    
    document.getElementById('rentButton').addEventListener('click', function(event) {
        event.preventDefault();
        const roomSelect = document.getElementById('roomSelect');
        const selectedRoomId = roomSelect.value;
        document.getElementById('room_id').value = selectedRoomId;
        const cartBody = document.getElementById('cartBody');
        if (cartBody.children.length === 0) {
            alert('Vui lòng chọn ít nhất một thiết bị.');
        } else {
            document.getElementById('rentalForm').submit();
        }
    });
});