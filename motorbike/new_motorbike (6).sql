-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 07:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_motorbike`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_img` int(11) NOT NULL,
  `date` date NOT NULL,
  `count` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `date`, `customer_id`) VALUES
(25, 'Khiem', 'khiem@gmail.com', 'I would like to know more details about the engine of the BMW 1000rr', '2024-10-10 07:16:30', 13),
(26, 'khiem', 'khiem@gmail.com', 'goood', '2024-10-17 08:49:10', 13),
(27, 'Khiem', 'khiem@gmail.com', 'I want to buy a cheaper motorbike', '2024-10-24 07:10:22', 13),
(28, 'Khiem', 'khiem@gmail.com', 'I want to buy a cheaper motor', '2024-10-31 10:59:17', 13);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `email`, `pass`, `phone`, `address`, `receipt_id`, `role`, `profile_image`) VALUES
(5, 'Huynh Hoang Khiem', 'khiemhhgcc210280@fpt.edu.vn', '$2y$10$0pd2gdJFmvVEQ0W3oCAW0eePNN2pED54RicVJ/jTR7fO/Zf.y357C', 123456789, 'Hau Giang', 0, 'admin', '0'),
(13, 'khiêm', 'khiem@gmail.com', '$2y$10$ureqi6ciU4Df/nHWNvytWuJd44ssiYe0iy77.ag6ePvAbY8iPxCOO', 123456789, 'Hau Giang', 0, 'customer', 'Hoàng Khieem1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `feedback_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `content`, `product_id`, `customer_id`, `order_id`, `feedback_date`) VALUES
(15, 'Good', 3, 13, 141, '2024-10-10'),
(16, 'That\'s good', 4, 13, 139, '2024-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment` text NOT NULL,
  `order_date` date NOT NULL,
  `quantity` int(100) NOT NULL,
  `customer_name` text NOT NULL,
  `order_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `product_id`, `payment`, `order_date`, `quantity`, `customer_name`, `order_status`) VALUES
(138, 13, 8, 'Cash on Delivery', '2024-10-10', 1, 'khiêm', 'Cancelled'),
(139, 13, 4, 'Credit by card', '2024-10-10', 1, 'khiêm', 'Completed'),
(140, 13, 9, 'Cash on Delivery', '2024-10-10', 1, 'khiêm', 'Cancelled'),
(141, 13, 3, 'Cash on Delivery', '2024-10-10', 1, 'khiêm', 'Completed'),
(142, 13, 4, 'Cash on Delivery', '2024-10-15', 1, 'khiêm', 'Pending'),
(143, 13, 8, 'Cash on Delivery', '2024-10-21', 1, 'khiêm', 'Pending'),
(144, 13, 11, 'Credit by card', '2024-10-31', 1, 'khiêm', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `producer`
--

CREATE TABLE `producer` (
  `producer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producer`
--

INSERT INTO `producer` (`producer_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `producer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_video_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_type_id`, `product_description`, `product_price`, `product_img`, `producer_id`, `quantity`, `product_video_url`) VALUES
(1, 'BMW S1000 RR 2023 WHITE', 1, 'The 2023 BMW S1000 RR in white is a high-performance sportbike renowned for its striking design and advanced technology. It features a powerful 999cc inline-four engine, delivering impressive acceleration and top speeds. The bike boasts advanced electronic rider aids, including dynamic traction control and multiple riding modes, ensuring a thrilling yet controlled riding experience. Its aerodynamic white bodywork, combined with a lightweight chassis, enhances both its aggressive look and handling capabilities. Ideal for track enthusiasts and performance-oriented riders, the S1000 RR blends cutting-edge engineering with sleek aesthetics.', 1000000, 'BMW S 1000 RR, 2023.jpg', 1, 0, 'https://www.youtube.com/watch?v=8w6ckBy-nPQ'),
(2, 'BMW S1000 RR 2023 RED', 1, 'The 2023 BMW S1000 RR in white is a high-performance sportbike renowned for its striking design and advanced technology. It features a powerful 999cc inline-four engine, delivering impressive acceleration and top speeds. The bike boasts advanced electronic rider aids, including dynamic traction control and multiple riding modes, ensuring a thrilling yet controlled riding experience. Its aerodynamic white bodywork, combined with a lightweight chassis, enhances both its aggressive look and handling capabilities. Ideal for track enthusiasts and performance-oriented riders, the S1000 RR blends cutting-edge engineering with sleek aesthetics.', 100000, 'bmw red2.jpg', 1, 6, 'https://www.youtube.com/watch?v=spt25NGebdE'),
(3, 'KTM Super Duke 2021', 2, 'The 2021 KTM Super Duke is a high-performance naked bike known for its aggressive styling and powerful performance. Equipped with a 1301cc V-twin engine, it delivers exhilarating power and torque, making it a standout on both city streets and open roads. The bike features a robust chassis, advanced suspension, and top-notch electronic rider aids, including traction control and multiple riding modes, ensuring a dynamic and customizable riding experience. With its distinctive design, including sharp lines and a bold color scheme, the Super Duke combines style with performance, making it a popular choice for riders seeking excitement and versatility.', 1500000, 'ktm-1290-super-duke-rr-2021-5k-3840x2160-5100.jpg', 1, 8, 'https://www.youtube.com/watch?v=6h1e9oulMd8'),
(4, 'Kawasaki Ninja zx 10r 2021', 3, 'The 2021 Kawasaki Ninja ZX-10R is a premium sportbike designed for both track enthusiasts and road riders. It features a 998cc inline-four engine, delivering exceptional power and acceleration. The ZX-10R comes equipped with advanced electronics, including a sophisticated traction control system, multiple riding modes, and cornering ABS, all aimed at enhancing performance and safety. Its aerodynamic design, including a new bodywork and aggressive front fairing, improves stability and reduces drag. With its sharp handling, responsive suspension, and cutting-edge technology, the ZX-10R is built for riders seeking high performance and precision.', 200000, 'kawasaki-ninja-zx-10r-sports-bikes-2021-3840x2160-3433.jpg', 1, 6, 'https://www.youtube.com/watch?v=_GKSozQWF4Q'),
(5, 'Aprilia sr 660 2021', 4, 'The 2021 Aprilia RS 660 is a sleek and sporty middleweight motorcycle known for its blend of performance and agility. It features a 659cc parallel-twin engine, delivering a balanced mix of power and smoothness. The RS 660 comes with advanced electronics, including multiple riding modes, traction control, and cornering ABS, providing a dynamic and customizable riding experience. Its lightweight chassis and aerodynamic design contribute to its sharp handling and high-speed stability. With a distinctive and modern design, the RS 660 combines Italian style with cutting-edge technology, making it a popular choice for riders seeking both excitement and everyday usability.', 1500000, 'aprilia-rs-660-sports-bikes-2021-5k-3840x2160-3019.jpg', 1, 7, 'https://www.youtube.com/watch?v=0ybQUEqtm8A'),
(6, 'Aprilia srv4 ', 4, 'The Aprilia RSV4 is a renowned superbike celebrated for its exceptional performance and advanced technology. Known for its powerful 999cc V4 engine, the RSV4 delivers impressive horsepower and torque, making it a top choice for track enthusiasts and sportbike aficionados. The bike features a sophisticated electronics package, including traction control, multiple riding modes, and cornering ABS, which enhances both performance and safety. Its aerodynamic design, advanced suspension, and lightweight chassis ensure precise handling and stability. The RSV4 combines Italian craftsmanship with cutting-edge engineering, offering a thrilling riding experience on both track and road.', 200000, 'aprilia-rsv4-3840x2160-11195.jpg', 1, 2, 'https://www.youtube.com/watch?v=Wt7zN-qPhTU'),
(7, 'BMW s1000rr Onexox', 1, 'The BMW S1000RR Onexox is a special edition of the standard S1000RR, designed to commemorate the Onexox BMW Racing Team\'s involvement in motorsports. This edition features the same high-performance attributes as the standard S1000RR, including its powerful 999cc inline-four engine and advanced electronics. However, it stands out with distinctive livery inspired by the Onexox racing team, often incorporating unique graphics and color schemes. The Onexox edition maintains the S1000RR\'s reputation for cutting-edge technology, including dynamic traction control and multiple riding modes, while celebrating its racing heritage with a visually striking appearance.', 1600000, 'bmw-s1000rr-onexox-tkkr-racing-bikes-5k-2022-3840x2160-7487.jpg', 1, 9, 'https://www.youtube.com/watch?v=zj8Bcn_aCzc'),
(8, 'Ducati Superleggera V4 2020', 5, 'The 2020 Ducati Superleggera V4 is an ultra-exclusive, high-performance superbike that represents the pinnacle of Ducati\'s engineering. Featuring a 998cc V4 engine, it delivers an astonishing amount of power, pushing the limits of performance. The Superleggera V4 is notable for its extensive use of lightweight materials, including carbon fiber and titanium, which contribute to its low weight and exceptional handling.', 2500000, 'ducati-superleggera-v4-2020-superbikes-2560x1706-1575.jpg', 1, 8, 'https://www.youtube.com/watch?v=DsaiPzqSKyk'),
(9, 'Ducati Streetfighter V2 2022', 5, 'The 2022 Ducati Streetfighter V2 is a dynamic and aggressive naked bike that combines Ducati\'s racing heritage with everyday usability. It features a 955cc Superquadro V-twin engine, delivering robust power and torque for thrilling performance on both city streets and open roads. The Streetfighter V2 comes with advanced electronics, including traction control, multiple riding modes, and cornering ABS, ensuring a versatile and controlled riding experience.', 2200000, 'ducati-streetfighter-v2-sports-bikes-2022-5k-8k-3840x2160-8359.jpg', 1, 5, 'https://www.youtube.com/watch?v=6Uvp8mAE3fo'),
(10, 'Ducati Super Sport 950 2021', 5, 'The 2021 Ducati SuperSport 950 is a versatile sportbike designed to offer a blend of performance, comfort, and everyday usability. It features a 937cc L-twin engine, delivering a balanced mix of power and torque for an engaging riding experience. The SuperSport 950 comes with a range of advanced electronics, including traction control, multiple riding modes, and cornering ABS, to enhance both performance and safety.', 2200000, 'ducati-supersport-950-sports-bikes-2021-5k-8k-3840x2160-3380.jpg', 1, 2, 'https://www.youtube.com/watch?v=5GBeAgbQO5U'),
(11, 'Yamaha YZF R1 2022', 6, 'The 2022 Yamaha YZF-R1 is a high-performance superbike known for its cutting-edge technology and race-inspired design. It features a 998cc inline-four engine derived from Yamaha\'s MotoGP technology, delivering exceptional power and acceleration. The bike is equipped with advanced electronics, including a sophisticated traction control system, quick shifter, multiple riding modes, and cornering ABS, providing both thrilling performance and enhanced safety.', 200000, 'yamaha-yzf-r1-sports-bikes-2022-3840x2160-8225.jpg', 1, 2, 'https://www.youtube.com/watch?v=iciYXaQ5BA4'),
(12, 'BMW s1000rr ', 1, 'The 2023 BMW S1000 RR in white is a high-performance sportbike renowned for its striking design and advanced technology. It features a powerful 999cc inline-four engine, delivering impressive acceleration and top speeds. The bike boasts advanced electronic rider aids, including dynamic traction control and multiple riding modes, ensuring a thrilling yet controlled riding experience. Its aerodynamic white bodywork, combined with a lightweight chassis, enhances both its aggressive look and handling capabilities. Ideal for track enthusiasts and performance-oriented riders, the S1000 RR blends cutting-edge engineering with sleek aesthetics.', 200000, 'bmw-s1000rr-sports-bikes-5k-3840x2160-6353.jpg', 1, 2, 'https://www.youtube.com/watch?v=Tz5LZq_AMvs'),
(31, 'vinfast', 1, 'abc', 123, 'desktop-157033.jpg', 1, 10, 'https://www.youtube.com/watch?v=6h1e9oulMd8');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL,
  `product_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type_name`) VALUES
(1, 'BMW'),
(2, 'KTM'),
(3, 'Kawasaki'),
(4, 'Aprilia '),
(5, 'Ducati '),
(6, 'Yamaha ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_ibfk_1` (`customer_id`);

--
-- Indexes for table `producer`
--
ALTER TABLE `producer`
  ADD PRIMARY KEY (`producer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type_id` (`product_type_id`),
  ADD KEY `producer_id` (`producer_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `producer`
--
ALTER TABLE `producer`
  MODIFY `producer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`producer_id`) REFERENCES `producer` (`producer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
