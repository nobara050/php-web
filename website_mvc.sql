-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2024 lúc 01:29 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `website_mvc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `adminEmail` varchar(150) NOT NULL,
  `adminUser` varchar(255) NOT NULL,
  `adminPass` varchar(255) NOT NULL,
  `level` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminId`, `adminName`, `adminEmail`, `adminUser`, `adminPass`, `level`) VALUES
(4, 'Nguyễn Tiến Đạt', 'nguyentiendat050@gmail.com', 'admin', '1', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brandId` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brandId`, `brandName`) VALUES
(10, 'Acer'),
(8, 'Asus'),
(5, 'Dell'),
(4, 'Lenovo'),
(9, 'Logitech'),
(3, 'MSI'),
(7, 'Victus');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cartId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `sId` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `price` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catId` int(11) NOT NULL,
  `catName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`catId`, `catName`) VALUES
(16, 'Bàn phím'),
(5, 'Case'),
(12, 'Chuột'),
(3, 'CPU'),
(1, 'Laptop'),
(10, 'Loa'),
(2, 'Main'),
(11, 'Màn hình'),
(6, 'Nguồn'),
(8, 'Ổ cứng'),
(9, 'Ram'),
(7, 'Tản'),
(4, 'VGA');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `name`, `address`, `city`, `country`, `phone`, `email`, `password`) VALUES
(3, 'Nguyễn Tiến Đạt', '157 ấp Tân Thới 1 xã Tân Hiệp huyện Hóc Môn', 'TP. Hồ Chí Minh', 'Vietnam', '0374242682', 'nguyentiendat050@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(5, 'admin test web', '', '', '', '0374242682', '22520226@gm.uit.edu.vn', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_measure`
--

CREATE TABLE `tbl_measure` (
  `measureId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `measureName` varchar(255) NOT NULL,
  `measureValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_measure`
--

INSERT INTO `tbl_measure` (`measureId`, `productId`, `measureName`, `measureValue`) VALUES
(65, 12, 'DPI', '4000'),
(66, 12, 'Trọng lượng', '74g'),
(67, 12, 'Cách kết nối', 'Bluetooth'),
(71, 10, 'CPU', 'i5'),
(72, 10, 'RAM', '16GB'),
(73, 10, 'SSD', '556GB'),
(74, 11, 'DPI', '36.000'),
(75, 11, 'Trọng lượng', '75g'),
(76, 9, 'CPU', 'i5'),
(77, 9, 'RAM', '16GB'),
(78, 9, 'SSD', '556GB'),
(79, 14, 'CPU', 'AMD R5'),
(80, 14, 'RAM', '8GB'),
(81, 14, 'SSD', '512GB'),
(82, 15, 'CPU', 'i3'),
(83, 15, 'RAM', '8GB'),
(84, 15, 'SSD', '512GB'),
(91, 13, 'Chipset', 'Radeon RX 6500 XT'),
(92, 13, 'Nhân xử lý', '1024'),
(93, 13, 'Dung lượng', '4GB');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `oderId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `shippingAddress` varchar(255) NOT NULL,
  `paymentMethod` varchar(255) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL DEFAULT 'Pending',
  `totalAmount` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `notes` varchar(255) DEFAULT NULL,
  `receiverName` varchar(255) DEFAULT NULL,
  `receiverPhone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `orderDetailId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitPrice` varchar(255) NOT NULL,
  `totalPrice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`orderDetailId`, `orderId`, `productId`, `quantity`, `unitPrice`, `totalPrice`) VALUES
(1, 1, 15, 1, '10490000', '10490000'),
(2, 2, 13, 3, '3790000', '11370000'),
(3, 3, 11, 2, '2490000', '4980000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `productId` int(11) NOT NULL,
  `productName` tinytext NOT NULL,
  `catId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `product_desc` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`productId`, `productName`, `catId`, `brandId`, `product_desc`, `price`, `image`, `type`) VALUES
(9, 'Máy tính Victus', 1, 7, 'Chip Intel Core i5 12450H series H hiệu năng cao tích hợp cùng GPU NVIDIA GeForce RTX 2050 4 GB, laptop HP Victus cho người dùng thoả thích chiến các tựa Esport yêu thích như FO4, LOL, CS:GO,... một cách trơn tru. Hơn nữa, phần cứng với hiệu suất vận hành tối ưu hỗ trợ làm tốt những công việc đồ hoạ, thiết kế hình ảnh, edit video,...\r\n<br>\r\n<br>\r\nThao tác đa nhiệm trên các phần mềm đồ hoạ hay các tựa game cũng mượt mà hơn với RAM 16 GB có hỗ trợ nâng cấp lên tận 32 GB hạn chế tình trạng giật lag và phản hồi nhanh chóng mọi tác vụ. Thêm vào đó, ổ cứng SSD 512 GB NVMe PCIe Gen 4.0 khởi động nhanh mọi phần mềm chỉ trong vài giây, cung cấp dung lượng vừa đủ cho việc lưu trữ của người dùng.\r\n<br>\r\n<br>\r\nLaptop HP được thiết kế với tông màu đen cá tính, chi tiết tối giản cùng logo hãng in chìm ở mặt A của máy cũng làm nổi bật hơn nét thanh lịch, cao cấp đặc trưng của dòng máy và khác xa những mẫu máy chiến game khác. Thiết bị có khối lượng tổng thể 2.29 kg, không quá nặng để bạn có thể bỏ gọn trong balo và mang theo mình mọi lúc.\r\n<br>\r\n<br>\r\nLaptop có đèn nền bàn phím để dễ dàng thao tác phím hơn ngay cả trong bóng tối. Đa dạng các cổng giao tiếp được trang bị như USB Type-C 3.2, Jack tai nghe 3.5 mm, USB 3.2, HDMI, LAN (RJ45) và khe SD.', '16190000', 'beac4450af.png', 1),
(10, 'Máy tính Asus Vivobook', 1, 8, '<form>\r\n    <p>\r\n        Laptop Asus Vivobook 15 OLED A1505ZA i5 12500H (MA415W) không chỉ ghi điểm bởi thiết kế hiện đại mà còn chinh phục người dùng với màn hình OLED sắc nét, sống động cùng hiệu năng mạnh mẽ, đáp ứng mọi nhu cầu học tập, văn phòng và giải trí.\r\n    </p>\r\n    \r\n    <p>\r\n        • Được trang bị bộ xử lý Intel Core i5 - 12500H nên chiếc laptop Asus Vivobook này có hiệu năng mạnh mẽ, giúp bạn xử lý mượt mà mọi tác vụ từ cơ bản đến nâng cao như lập trình, thiết kế hình ảnh, render video ngắn,... trên các ứng dụng của nhà Adobe.\r\n    </p>\r\n    \r\n    <p>\r\n        • Laptop Asus sở hữu card đồ họa tích hợp Intel Iris Xe Graphics giúp bạn giải trí với những tựa game thông dụng trên thị trường hiện nay như LOL, Dota 2,... mượt mà ở mức cài đặt trung bình. Khả năng xử lý đồ họa mạnh mẽ cũng hỗ trợ bạn trong công việc sáng tạo nội dung một cách hiệu quả.\r\n    </p>\r\n    \r\n    <p>\r\n        • Được trang bị RAM 16 GB, Asus Vivobook cho phép bạn mở nhiều ứng dụng cùng lúc mà không lo bị giật lag hay đơ máy. Bạn có thể vừa nghe nhạc trên YouTube, vừa mở nhiều tab trình duyệt web để tra cứu tài liệu, vừa sử dụng Photoshop để chỉnh sửa ảnh mà vẫn đảm bảo hiệu suất mượt mà.\r\n    </p>\r\n    \r\n    <p>\r\n        • Asus Vivobook được trang bị ổ cứng SSD 512 GB, mang đến cho bạn không gian lưu trữ rộng lớn, giúp bạn thoải mái lưu trữ mọi dữ liệu mà không cần lo lắng về việc hết dung lượng. Với 512 GB bạn có thể tải về tài liệu học tập, văn phòng, hình ảnh, video cho đến các ứng dụng mà không cần phải dùng đến các bộ lưu trữ ngoài.\r\n    </p>\r\n    \r\n    <p>\r\n        • Màn hình bảo vệ mắt - EYE CARE tự động điều chỉnh độ sáng và nhiệt độ màu của màn hình phù hợp với môi trường xung quanh, giúp giảm thiểu sự mỏi mắt khi sử dụng laptop trong thời gian dài. Công nghệ Low Blue Light giúp lọc bớt ánh sáng xanh có hại từ màn hình, bảo vệ mắt bạn khỏi các tác hại như mỏi mắt, khô mắt, rối loạn giấc ngủ và thoái hóa điểm vàng.\r\n    </p>\r\n    \r\n    <p>\r\n        • Với tông màu bạc chủ đạo, chiếc laptop này mang đến vẻ ngoài tinh tế, sang trọng phù hợp với những ai yêu thích phong cách tối giản. Mặc dù vỏ máy được chế tác từ nhựa, nhưng laptop vẫn đạt chuẩn quân đội MIL STD 810H, đảm bảo độ bền bỉ, chịu va đập tốt, bạn có thể an tâm sử dụng trong mọi điều kiện.\r\n    </p>\r\n    \r\n    <p>\r\n        • Với khối lượng chỉ 1.7 kg và độ dày 19.9 mm, bạn có thể dễ dàng mang theo chiếc laptop học tập - văn phòng này mọi lúc mọi nơi. Với các cổng kết nối như: USB Type-C, USB 2.0, Jack tai nghe 3.5 mm, USB 3.2 và HDMI, bạn có thể dễ dàng kết nối laptop với nhiều thiết bị ngoại vi khác nhau, phục vụ cho công việc, học tập và giải trí.\r\n    </p>\r\n</form>\r\n', '13490000', '757e0a02d7.jpg', 0),
(11, 'Chuột gaming ASUS ROG Gladius III ', 12, 8, 'Đánh giá chi tiết chuột Gaming ASUS ROG Gladius II Core\r\nGladius II Core là một phần trong của hệ sinh thái ROG của Asus. Đây là một mẫu chuột máy tính đa năng, dễ cầm, dễ làm quen, phù hợp với nhiều kiểm cầm và nhiều dòng game khác nhau. Đặc biệt, nếu bạn đã là fan Asus mà lại còn thích LED RGB thì chắc chắn mẫu chuột này sẽ cực kỳ đáng mua.\r\n</br>\r\n</br>\r\nThiết kế đẹp mắt\r\nMang trên mình thương hiệu ROG đầy tự hào của Asus, Gladius II Core được chăm chút rất kỹ về mặt thiết kế. Nó uyển chuyển với thiết kế tổng thể mềm mại nhưng cũng cực kỳ mạnh mẽ với những chi tiết xẻ rãnh trên hông và mũi chuột. Thiết kế chuột này rất đồng điệu với phong cách thường thấy của các dòng sản phẩm mang thương hiệu ROG. Dây cáp chuột có thể tháo rời giúp bạn quấn dây gọn gàng để mang chuột đến mọi nơi.\r\n</br>\r\n</br>\r\nĐộ bền vượt trội\r\nSwitch chuột được sử dụng trên Gladius II Core là loại có độ bền lên đến 50 triệu lượt nhất của Omron giúp bạn thoải mái chơi game, tạm biệt nỗi lo về double click. Thân chuột cũng được hòa thiện chắc chắn cho bạn cảm giác tự tin khi sử dụng. Hứa hẹn đây sẽ là một trong những dòng chuột gaming dưới 1 triệu rất đáng trải nghiệm.', '2490000', 'effd5f0bc5.jpg', 1),
(12, 'Chuột Bluetooth Silent Logitech M240', 12, 9, '    <h2>Chuột Bluetooth Silent Logitech M240</h2>\r\n    <p>\r\n        Với kiểu dáng gọn gàng, gam màu đẹp mắt, kích thước vừa vặn tay cầm, kết nối ổn định cùng độ nhạy khá cao, \r\n        hứa hẹn mang đến cho bạn những trải nghiệm tuyệt vời.\r\n    </p>\r\n    <ul>\r\n        <li>\r\n            <strong>Màu sắc thanh lịch:</strong> Khối lượng siêu gọn nhẹ, không chiếm quá nhiều diện tích không gian, \r\n            tiện lợi bỏ vào balo hay túi xách mang theo bất cứ đâu.\r\n        </li>\r\n        <li>\r\n            <strong>Thiết kế sắc sảo:</strong> Chuột với đường nét sắc sảo đến từng chi tiết đem đến cho người dùng cảm giác êm tay \r\n            trong quá trình sử dụng, hạn chế mỏi tay khi dùng trong thời gian dài.\r\n        </li>\r\n        <li>\r\n            <strong>Tốc độ di chuyển cao:</strong> Trang bị tốc độ di chuyển khá nhanh và phản hồi cao nhờ độ phân giải lên đến 4000 DPI. \r\n            Bạn có thể điều chỉnh mức DPI phù hợp cho từng loại tác vụ, tối ưu trải nghiệm sử dụng.\r\n        </li>\r\n        <li>\r\n            <strong>Kết nối dễ dàng:</strong> Bạn có thể dễ dàng kết nối với các thiết bị thông qua Bluetooth trong vòng 10 m, \r\n            đường truyền ổn định và mượt mà.\r\n        </li>\r\n        <li>\r\n            <strong>Pin tiện lợi:</strong> Chuột Logitech sử dụng viên pin AA giúp bạn có thể yên tâm dùng trong thời gian khá lâu mà không lo gián đoạn, \r\n            dễ dàng thay thế khi hết pin.\r\n        </li>\r\n    </ul>', '320000', '01be65bf1e.jpg', 0),
(13, 'Card màn hình ASUS Dual Radeon RX 6500', 4, 8, '', '3790000', '7f1ecef431.png', 1),
(14, 'Laptop Gaming Acer Nitro 5 ', 1, 10, 'Đánh giá chi tiết laptop gaming Acer Nitro 5 AN515-45 R6EV\r\nAcer vừa ra mắt phiên bản mới nhất của dòng máy gaming Nitro 5 - Nitro 5 AN515-45 R6EV được trang bị bộ vi xử lý AMD Ryzen 5 5600H, card đồ họa Geforce GTX 1650 4GB và tốc độ làm mới 144Hz cho hiệu năng xử lí mạnh mẽ cùng với hỗ trợ bàn phím RGB cá tính giúp mang lại trải nghiệm chơi game tốt nhất.\r\n<br>\r\n<br>\r\nCông nghệ dẫn đầu\r\nNitro 5 AN515-45 tích hợp những “vũ khí” mới nhất. Với sự kết hợp từ CPU AMD Ryzen 5 5600H và VGA NVIDIA GeForce GTX 1650, AN515-45 sẽ cho hiệu năng xử lý mạnh mẽ để xử lý tốt các công việc đồ họa đơn giản trên các phần mềm chuyên dụng, tốc độ xử lý thông tin cũng tương đối nhanh và mượt mà.', '13990000', '5b03ecc2f5.png', 1),
(15, 'Laptop Lenovo V14 G4', 1, 4, '   <h2>Đánh giá chi tiết Laptop Lenovo V14 G4 IRU 83A0000TVN</h2>\r\n    <p>\r\n        Lenovo V14 G4 IRU 83A0000TVN là dòng laptop văn phòng giá rẻ hướng đến sinh viên, dân văn phòng và bất kỳ ai tìm kiếm \r\n        một thiết bị nhẹ và di động cho các tác vụ hàng ngày. \r\n    </p>', '10490000', '1e2c5dfced.jpg', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brandId`),
  ADD UNIQUE KEY `brandName` (`brandName`);

--
-- Chỉ mục cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cartId`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catId`),
  ADD UNIQUE KEY `catName` (`catName`);

--
-- Chỉ mục cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_measure`
--
ALTER TABLE `tbl_measure`
  ADD PRIMARY KEY (`measureId`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`oderId`);

--
-- Chỉ mục cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`orderDetailId`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`productId`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_measure`
--
ALTER TABLE `tbl_measure`
  MODIFY `measureId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `oderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `orderDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
