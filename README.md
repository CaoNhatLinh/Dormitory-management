<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Quản lý kí túc xá sử dụng Laravel
## Danh mục:
- [Tính năng](#các-tính-năng)
- [Hướng dẫn sử dụng](#cách-sử-dụng)
- [Document và sql](#các-tệp-đính-kèm)
## Các tính năng:
- Đăng nhập, đăng ký,Quên mật khẩu,đổi mật khẩu 
- Trang profile( sửa thông tin nhân viên, thông tin tài khoản)
- Thống kê(phòng,hợp đồng, thiết bị,sinh viên,doanh thu,nhân viên,sinh viên công nợ).
- Quản lý phòng, loại phòng
- Quản lý Hợp đồng ( tạo, hủy, đổi phòng )
- Quản lý sinh viên
- Hóa đơn điện nước
- Thanh toán hoá đơn
- Quản lý nhân viên, chức vụ
- Quản lý user, quyền truy cập
- Quản lý thiết bị, loại thiết bị
- Quản lý cho thuê thiết bị
#### Trang import file excel:
> * Import điện nước các phòng: [Go to page](http://dormitory-management.great-site.net/bill/room/createExcelView)
> * Import file trang thiết bị: [Go to page](http://dormitory-management.great-site.net/device/createExcelView)
#### 1 số danh sách hỗ trợ in pdf và export ra file excel.
#### Trang thanh toán : invoice
 1. Lựa chọn phòng muốn thanh toán
 2. Chọn thanh toán cho( tiền phòng, tiền điện nước, tiền thuê thiết bị), nếu là tiền phòng,chọn thêm sinh viên.
 3. Xem thông tin hoá đơn và thanh toán hoặc cancel.(nếu không có hiện không có gì để thanh toán).
đối với thanh toán cho thuê thiết bị :'thanh toán và tiếp tục thuê';'thanh toán và ngừng thuê'.

#### Trang thuê thiết bị: device rental
- Link truy cập: http://dormitory-management.great-site.net/device/devicerental/createDeviceRental
- Trang sẽ hiển thị lên danh sách thiết bị và mỗi dòng thiết bị có 1 nút thuê(rent) khi thuê thì thiết bị sẽ xuất hiện ở bảng
thiết bị cho thuê bên dưới có thể tăng giảm số lượng, chọn phòng và sau đó bấm nút thuê lớn tất cả thiết bị chọn sẽ được cho thuê thành công

## Các tệp đính kèm
> [!IMPORTANT]
> 1. **Document** : [tải ở đây](https://docs.google.com/document/d/1MfUaTIyQZ3ribX7NiKZ9P1vUbonbiaqj/edit?usp=sharing&ouid=116426256626098687419&rtpof=true&sd=true)
> 2. **cơ sở dữ liệu**: [tải ở đây](https://drive.google.com/file/d/1EKKkcgVFz83pQ6310cjf0R0rZcDErVyH/view?usp=sharing)


Cảm ơn đã sử dụng dự án!

