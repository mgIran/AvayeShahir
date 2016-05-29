/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : shahir

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2016-05-29 14:35:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('24', 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'admin@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('27', 'admin2', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'sa@sda.sad', '2');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'مدیر', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'ناظر', 'validator');

-- ----------------------------
-- Table structure for ym_classes
-- ----------------------------
DROP TABLE IF EXISTS `ym_classes`;
CREATE TABLE `ym_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `summary` text COLLATE utf8_persian_ci COMMENT 'توضیحات',
  `capacity` int(5) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'شهریه',
  `startSignupDate` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع ثبت نام',
  `endSignupDate` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان ثبت نام',
  `startClassDate` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع کلاس',
  `endClassDate` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان کلاس',
  `category_id` int(10) unsigned NOT NULL COMMENT 'گروه',
  `course_id` int(10) unsigned NOT NULL COMMENT 'دوره',
  `teacher_id` int(10) unsigned NOT NULL COMMENT 'استاد',
  `order` int(10) unsigned NOT NULL,
  `sessions` varchar(3) COLLATE utf8_persian_ci DEFAULT NULL,
  `startClassTime` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  `endClassTime` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  `classDays` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `ym_classes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_class_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_classes_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `ym_courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_classes
-- ----------------------------
INSERT INTO `ym_classes` VALUES ('5', 'ترم زوج', '', '3', '350000', '1464307400', '1465155000', '1465327800', '1465759800', '33', '18', '35', '1', '10', '10:30', '5.30', 'شنبه');
INSERT INTO `ym_classes` VALUES ('6', 'asd', '', '25', '500000', '1465155000', '1466278200', '1465155000', '1466019000', '34', '15', '35', '2', '', '', '', '');

-- ----------------------------
-- Table structure for ym_class_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_class_categories`;
CREATE TABLE `ym_class_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  `course_id` int(11) unsigned DEFAULT NULL,
  `summary` text,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `ym_class_categories_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `ym_courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_class_categories
-- ----------------------------
INSERT INTO `ym_class_categories` VALUES ('20', 'ریدینگ', '13', '', '9');
INSERT INTO `ym_class_categories` VALUES ('21', 'اسپیکینگ', '13', '', '7');
INSERT INTO `ym_class_categories` VALUES ('22', 'رایتینگ', '13', '', '3');
INSERT INTO `ym_class_categories` VALUES ('23', 'لیسنینگ ', '13', '', '15');
INSERT INTO `ym_class_categories` VALUES ('24', 'در مورد دوره تافل موسسه آوای شهیر ', '13', '<p dir=\"RTL\" style=\"text-align:justify\">دوره های آموزش تافل که قرار است در موسسه پردیس آوای شهیر برگزار شود با دوره هایی که در دانشگاه شریف برگزار میکنم تفاوت هایی دارد که قابل تامل اند. اول اینکه،&nbsp;در این دوره ها، تخفیف های ویژه ای&nbsp;برای&nbsp;دانشجویان عزیز در نظر گرفته شده &ndash; که بخشی از آن در سایت نت برگ ارائه خواهد شد &ndash; که &nbsp;شرایط ثبت نام را برای آنها ایده آل میکند. دوم اینکه، برعکس اکثر موسسات، دو نمونه از رایتینگ های هر داوطلب به طور رایگان در طول ترم تصحیح میگردد که تاثیر به سزایی در نمره تافل آنها خواهد داشت. سوم اینکه در انتهای هر دوره، بنا به نیاز زبان آموزان، یک گارکاه چند ساعته برگزار خواهد شد که در آن صرفا نمونه رایتینگ هر یک از داوطلبین بررسی شده ونکات کلیدی و نهایی به آنها آموخته میشود. با برگزاری این دوره ها، امیدواریم که بتوانیم سهم کوچکی در بالا بردن سطح علمی دانشجویان عزیزمان داشته باشیم و راه را برای پیشرفت های آتی آنها هموار سازیم.</p>\r\n\r\n<p dir=\"RTL\" style=\"text-align:justify\">با آرزوی بهروزی همه عزیزان</p>\r\n\r\n<p dir=\"RTL\" style=\"text-align:justify\">مدیریت موسسه پردیس آوای شهیر</p>\r\n\r\n<p style=\"text-align:justify\"><span dir=\"RTL\">امیر خادم المله</span></p>\r\n', '1');
INSERT INTO `ym_class_categories` VALUES ('26', 'مطالبی در مورد امتحان تافل آی بی تی', '13', '<p>دانستن این مطالب برای هر داوطلب امتحان تافل ضروری است.</p>\r\n', '4');
INSERT INTO `ym_class_categories` VALUES ('27', 'رئوس‌ مطالب و برنامه مطالعه همه مهارت های تافل', '13', '<p>لطفا این برنامه رو نسبت به سطحی که دارید دنبال کنید. قرار نیست همه موارد را مطالعه کنید.</p>\r\n', '10');
INSERT INTO `ym_class_categories` VALUES ('28', 'آیلتس جنرال', '15', '', '13');
INSERT INTO `ym_class_categories` VALUES ('29', 'آیلتس آکادمیک', '15', '', '12');
INSERT INTO `ym_class_categories` VALUES ('30', 'واژگان تافل', '13', '<p>برای ترتیب خواندن واژگان لطفا به فایل &quot;رئوس&zwnj; مطالب و برنامه مطالعه همه مهارت های تافل&quot; مراجعه کنید.</p>\r\n', '6');
INSERT INTO `ym_class_categories` VALUES ('31', 'منابع بخش دستور زبان (گرامر)', '18', '<p style=\"text-align:justify\">با خواندن و انجام دادن تمرینات داده شده در هر جزوه و انجام دادن&nbsp;تست های مکمل، در امتحان تافل دکتری که در ایران برگزار میگردد،&nbsp;میتوانید نمره بسیار خوبی بگیرید.</p>\r\n', '14');
INSERT INTO `ym_class_categories` VALUES ('32', 'فایل های ویدیوئی، PDF، و  Word در مورد قسمت های مختلف امتحان جی آر ای', '16', '<p style=\"text-align:justify\">کتاب ها و منابعی که برای امتحان جی آر ای ارائه شده اند بسیاراند، ولی با خواندن این منابع گلچین شده میتوانید نمره دلخواهتان را بگیرید.</p>\r\n\r\n<p>با آرزوی موفقیت شما</p>\r\n\r\n<p>امیر خادم: مدیر موسسه پردیس آوای شهیر</p>\r\n', '11');
INSERT INTO `ym_class_categories` VALUES ('33', 'منابع لغت برای امتحان تافل دکتری', '18', '', '8');
INSERT INTO `ym_class_categories` VALUES ('34', 'واژگان آیلتس آکادمیک', '15', '<p dir=\"RTL\">برای ترتیب خواندن واژگان لطفا به فایل &quot;رئوس&zwnj; مطالب و برنامه مطالعه همه مهارت های آیلتس&quot; مراجعه کنید<span dir=\"LTR\">.</span></p>\r\n', '2');
INSERT INTO `ym_class_categories` VALUES ('38', 'من', '13', '', '5');

-- ----------------------------
-- Table structure for ym_class_category_files
-- ----------------------------
DROP TABLE IF EXISTS `ym_class_category_files`;
CREATE TABLE `ym_class_category_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `path` varchar(500) COLLATE utf8_persian_ci NOT NULL COMMENT 'فایل',
  `summary` text COLLATE utf8_persian_ci,
  `file_type` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نوع فایل',
  `category_id` int(10) unsigned NOT NULL COMMENT 'گروه',
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_class_category_files_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_class_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_class_category_files
-- ----------------------------
INSERT INTO `ym_class_category_files` VALUES ('11', 'جدیدترین سوالات بخش اسپیکینگ تافل', 'xQNvA1460892549.docx', null, 'docx', '21', '1');
INSERT INTO `ym_class_category_files` VALUES ('12', 'واژه‌ نامه‌ کتاب TOEFL Writing Success 4th Edition نوشته امیر خادم', 'YRwSg1460892914.docx', 'از آنجا که واژگان بکار رفته در کتاب سخت ولی کاربردی هستند، اصرار دارم که برای درک بهتر واژگان و کاربرد آنها حتما و حتما از این واژه نامه استفاده کنید.', 'docx', '22', '5');
INSERT INTO `ym_class_category_files` VALUES ('14', 'ضرب المثل ها و نقل قول های دسته بندی شده از بزرگان', 'ZU8sy1460893007.docx', 'خواندن این ضرب المثل ها بسیار جذابه و به رایتینگ شما کمک زیادی میکند.', 'docx', '22', '11');
INSERT INTO `ym_class_category_files` VALUES ('16', 'جدیدترین سوالات بخش رایتینگ تافل آی بی تی', '7yQQA1460893395.doc', 'در کتاب TOEFL WRITING SUCCESS 4th Edition تلاش شد که موضوعات جدید همراه با نمومه ارائه گردد اما بسیاری از موضوعات داخل این فایل جدیدتر هستند. بنابراین، خواندن آنها ضروری است.', 'doc', '22', '8');
INSERT INTO `ym_class_category_files` VALUES ('17', '29 مقوله دسته بندی شده رایتینگ تافل', 'IejkV1460893427.docx', '', 'docx', '22', '15');
INSERT INTO `ym_class_category_files` VALUES ('19', 'روش نمره دهی به رایتینگ تافل', 'syBtS1460893505.pdf', '', 'pdf', '22', '2');
INSERT INTO `ym_class_category_files` VALUES ('20', 'فایل نصب Babylon ', 'IuyxR1460893556.rar', '', 'rar', '22', '13');
INSERT INTO `ym_class_category_files` VALUES ('21', 'فایل کرک Babylon ', 'lMF6i1460893624.rar', '', 'rar', '22', '14');
INSERT INTO `ym_class_category_files` VALUES ('22', 'روش نصب Babylon ', 'BKYAV1460893671.docx', '', 'docx', '22', '12');
INSERT INTO `ym_class_category_files` VALUES ('26', 'مهاجرت پرندگان', 'CaHew1460894069.docx', '', 'docx', '23', '20');
INSERT INTO `ym_class_category_files` VALUES ('27', 'سلول ها (ياخته های) گلا يلى', 'S8TSy1460894094.docx', '', 'docx', '23', '19');
INSERT INTO `ym_class_category_files` VALUES ('28', 'گل رافلیزیا', 'fGk2d1460894119.docx', '', 'docx', '23', '22');
INSERT INTO `ym_class_category_files` VALUES ('29', 'موسیقی رگ تایم', 'f4GOY1460894144.docx', '', 'docx', '23', '23');
INSERT INTO `ym_class_category_files` VALUES ('30', 'ویلیام وردز ورث', 'GfRNh1460894172.docx', '', 'docx', '23', '21');
INSERT INTO `ym_class_category_files` VALUES ('31', 'کتاب TOEFL WRITING SUCCESS 4th Edition نوشته امیر خادم', 'X6rq41460894322.jpg', 'این کتاب که برای زبان آموزان سطوح متوسطه به بالا نوشته شده منبعی عالی برای کسانی است که قصد شرکت در امتحان هایی مثل آیلتس، جی آر ای، جی ام ای تی، و تافل را دارند. این کتاب شامل 165 نمونه از رایتینگ های دانشجویانم و 4 نمونه از رایتینگ های نویسنده می باشد که کلمات و عبارت های بسیار پرکاربردی در آنها به کار رفته. لازم به ذکر است که نوشتن این نمونه ها ساعت ها وقت گرفته و بعدها این دانشجویان زمان نوشتن خود را کاهش داده اند. بنابراین، شما هم باید دقیقا همین کار را بکنید تا سطح رایتینگ شما آرام آرام بهبود پیدا کند. در ضمن، تمرین های زیادی در خصوص paraphrasing، synthesizing، و note-taking  نیز در کتاب آمده که مهارتهای زبانی شما را برای امتحان تافل بالا میبرد. اگر این کتاب را آنطور که در مقدمه اش آمده مطالعه کنید، نمره بسیار خوبی در امتحان خواهید گرفت. با آرزوی موفقیت شما در آزمون تافل. امیر خادم.', 'jpg', '22', '3');
INSERT INTO `ym_class_category_files` VALUES ('32', 'کلمات ضروری که در محیط دانشگاه استفاده میشوند', 'W0rGc1460988080.pdf', null, 'pdf', '21', '24');
INSERT INTO `ym_class_category_files` VALUES ('34', 'ایده هایی نسبتا خوب برای اسپیکینگ و رایتینگ', 'MsYZ51460990376.pdf', null, 'pdf', '21', '25');
INSERT INTO `ym_class_category_files` VALUES ('35', 'روش نمره دهی به اسپیکینگ تافل', 'xm77m1460990688.pdf', null, 'pdf', '21', '26');
INSERT INTO `ym_class_category_files` VALUES ('36', 'بخش هایی از کتاب TOEFL Writing Success نوشته امیر خادم', 'SCceG1460993103.pdf', '', 'pdf', '22', '4');
INSERT INTO `ym_class_category_files` VALUES ('37', 'جزوه گرامر Pre-TOEFL  نوشته امیر خادم ', 'BSUIU1461592019.pdf', 'این جزوه و جزوه گرامر تافل حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '22', '6');
INSERT INTO `ym_class_category_files` VALUES ('38', 'جزوه گرامر TOEFL Writing Pamphlet Compiled by Amir Khadem  ', 'z8ipQ1461591931.pdf', 'این جزوه و Pre-TOEFL Writing Pamphlet حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '22', '7');
INSERT INTO `ym_class_category_files` VALUES ('40', 'در مورد لیسنینگ های  تکراری', 'Rap0d1461063559.docx', 'دوستان عزیز:\r\nاز شش تا متن listening  که در سایت آمده، سه تا از آنها قطعا در همه امتحانهای تافل می آید و نمره هم دارد. لطفا به حرف دوستانتان در این خصوص توجه نکنید.\r\nموفق باشید.\r\nامیر خادم\r\n', 'docx', '23', '17');
INSERT INTO `ym_class_category_files` VALUES ('41', 'دانشجویی که کارت دانشجویی اش را گم کرده', 'xPlHk1461063769.docx', '', 'docx', '23', '18');
INSERT INTO `ym_class_category_files` VALUES ('42', 'نمره 0 تا 30 در لیسنینگ بر اساس تعداد جواب درست', 'X7o871461064766.pdf', '', 'pdf', '23', '16');
INSERT INTO `ym_class_category_files` VALUES ('43', '	نمره 0 تا 30 در خواندن بر اساس تعداد جواب درست', 'vWDgT1461065034.pdf', '', 'pdf', '20', '27');
INSERT INTO `ym_class_category_files` VALUES ('44', 'طریقه دریافت امتحان آزمایشی از سایت ETS؟', 'DpvEK1461068332.pdf', 'کسانی که در آزمون تافل ثبت نام کرده اند میتوانند یک تست رایگان دریافت کنند.', 'pdf', '26', '28');
INSERT INTO `ym_class_category_files` VALUES ('45', 'یک نمونه کارنامه صادر شده توسط ETS ', 'vlBZh1461068638.pdf', '', 'pdf', '26', '29');
INSERT INTO `ym_class_category_files` VALUES ('46', 'لغات مهارت خواندن', 'fuyhZ1461069329.docx', 'این لغات توسط یکی از داوطلبین جمع آوری شده که خواندن آن مفیده هر چند ممکنه خطاهایی هم داشته باشه. در آینده نزدیک فایل های خیلی بهتری آپلود خواهد شد.', 'docx', '20', '30');
INSERT INTO `ym_class_category_files` VALUES ('47', 'اصطلاحات ضروری انگلیسی از سطح مقدماتی تا پیشرفته', 'wFRpP1461069458.pdf', 'کتاب اصطلاحات ضروری انگلیسی از سطح مقدماتی تا پیشرفته یک منبع عالی برای یادگیری اصطلاحات است که به مهارت های لیسنینگ، اسپیکینگ، و رایتنگ کمک زیادی میکند.', 'pdf', '20', '31');
INSERT INTO `ym_class_category_files` VALUES ('49', 'رئوس‌ مطالب و برنامه مطالعه همه مهارت های تافل', 'nNyvw1461167798.pdf', 'در این فایل، که ثمره سالها تدریس تافل در دانشگاه شریف و امیرکبیر است، رئوس‌ مطالب و برنامه مطالعه همه مهارت های تافل را با جزئیاتش هر مهارت توضیح دادم که تا الان همه کسانی که این برنامه را دنبال کرده اند، صرف نظر از سطحی که داشتند، نمرات فوق العاده ای در امتحان تافل گرفته اند. امیدوارم شما نفر بعدی باشید.\r\nامیر خادم\r\n', 'pdf', '27', '32');
INSERT INTO `ym_class_category_files` VALUES ('50', 'زیباترین نقل قول  های دنیا', 'unrKf1461227526.pdf', 'خواندن این نقل قول ها میتواند ایده های خلاقانه زیادی به شما بدهد وکاربرد آنها در هر امتحانی تاثیر زیادی در نمره شما خواهد داشت.', 'pdf', '22', '9');
INSERT INTO `ym_class_category_files` VALUES ('51', 'ضرب المثل هاي انگليسي با ترجمه فارسي', '963H81461311340.pdf', 'خواندن این ضرب المثل ها بسیار جذابه و به رایتینگ شما کمک زیادی میکند.', 'pdf', '22', '10');
INSERT INTO `ym_class_category_files` VALUES ('53', 'جزوه گرامر Pre-IELTS (امیر خادم)   ', 'AvDtd1461520772.pdf', 'این جزوه و جزوه رایتینگ آیلتس حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '29', '33');
INSERT INTO `ym_class_category_files` VALUES ('55', 'جزوه گرامر Pre-TOEFL (امیر خادم) ', 'aiMFy1461594287.pdf', 'این جزوه و جزوه گرامر تافل دکتری حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحان تافل دکتری که در ایران برگزار میشود بیرون بیایند. امیدواریم نفرات بعدی شما باشید. ', 'pdf', '31', '34');
INSERT INTO `ym_class_category_files` VALUES ('56', 'جزوه گرامر PhD TOEFL نوشته امیر خادم ', 'OmrPO1461594064.pdf', 'این جزوه و جزوه Pre-TOEFL حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحان تافل دکتری که در ایران برگزار میشود بیرون بیایند. امیدواریم نفرات بعدی شما باشید.', 'pdf', '31', '35');
INSERT INTO `ym_class_category_files` VALUES ('57', 'جزوه گرامر Pre-IELTS (امیر خادم)  ', 'XXZ3C1461592056.pdf', 'این جزوه و جزوه گرامر آیلتس حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '28', '36');
INSERT INTO `ym_class_category_files` VALUES ('59', 'جزوه گرامر  IELTS Writing (امیر خادم)', 'U5q151461593467.pdf', 'این جزوه و جزوه Pre-IELTS حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '29', '37');
INSERT INTO `ym_class_category_files` VALUES ('60', 'جزوه گرامر General IELTS Writing (امیر خادم)', 'FgmNR1461593637.pdf', 'این جزوه و Pre-IELTS Grammar Pamphlet حدود 15 سال است که توسط اینجانب، امیر خادم، در موسسات و دانشگاه های زیادی مثل دانشگاه صنعتی شریف تدریس شده و افراد بسیاری تا کنون توانسته اند با کمک آنها سربلند از امتحانهای تافل، آیلتس، تافل دکتری، جی آر ای، و جی ام ای تی بیرون بیایند. امیدواریم نفرات بعدی شما باشید. امیر خادم.', 'pdf', '28', '38');

-- ----------------------------
-- Table structure for ym_class_category_file_links
-- ----------------------------
DROP TABLE IF EXISTS `ym_class_category_file_links`;
CREATE TABLE `ym_class_category_file_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `summary` text COLLATE utf8_persian_ci,
  `link` varchar(500) COLLATE utf8_persian_ci NOT NULL COMMENT 'لینک فایل',
  `file_type` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نوع فایل',
  `category_id` int(10) unsigned NOT NULL COMMENT 'گروه',
  `order` int(10) unsigned NOT NULL,
  `link_size` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_class_category_file_links_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_class_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_class_category_file_links
-- ----------------------------
INSERT INTO `ym_class_category_file_links` VALUES ('20', 'ویدیوی ETS درباره رایتینگ اول تافل (Integrated)', 'این ویدیو را خود سایت ETS  ارائه کرده و دیدن آن درک خوبی از این نوع رایتینگ به شما میده، اما برای درک بهتر و خواندن نمونه های خوب این نوع رایتینگ به کتاب TOEFL Writing Success  رجوع کنید. ', 'https://www.ets.org/s/toefl/flash/18690_insideTOEFL-Writing-Q1.html', 'flv', '22', '7', null);
INSERT INTO `ym_class_category_file_links` VALUES ('21', 'ویدیوی ETS درباره رایتینگ دوم تافل  (Independent)', 'دیدن این ویدیو که خود سایت ETS  ارائه کرده درک خوبی از این نوع رایتینگ به شما میدهد، اما برای درک بهتر و خواندن نمونه های خوب این نوع رایتینگ به کتاب TOEFL Writing Success  رجوع کنید. ', 'https://www.ets.org/s/toefl/flash/18690_inside-toefl-video.html', 'flv', '22', '8', null);
INSERT INTO `ym_class_category_file_links` VALUES ('22', 'سوال 1 و 2 اسپیکینگ ', 'این ویدیو را سایت ETS  ارائه کرده که کلیاتی را در خصوص سوال 1 و 2 اسپیکینگ توضیح میدهد. اما برای درک بهتر و تمرین بیشتر به کتاب هایی که معرفی کرده ایم  رجوع کنید.', 'https://www.ets.org/s/toefl/flash/18690_insideTOEFL-Speaking-Q1-2.html', 'flv', '21', '3', null);
INSERT INTO `ym_class_category_file_links` VALUES ('23', 'سوالات اسپیکینگ 3 و 5', 'این ویدیو ازسایت ETS  است که کلیاتی را در خصوص سوال 3 و 5 اسپیکینگ ارائه میدهد. اما برای درک بهتر و تمرین بیشتر به کتاب هایی که معرفی کرده ایم  رجوع کنید.', 'https://www.ets.org/s/toefl/flash/18690_insideTOEFL-Speaking-Q3.html', 'flv', '21', '4', null);
INSERT INTO `ym_class_category_file_links` VALUES ('24', 'سوالات 4 و 6 اسپیکینگ', 'این ویدیو ازسایت ETS  است که کلیاتی را در خصوص سوال 4 و 6 اسپیکینگ ارائه میدهد. اما برای درک بهتر و تمرین بیشتر به کتاب هایی که معرفی کرده ایم  رجوع کنید.', 'https://www.ets.org/s/toefl/flash/18690_insideTOEFL-Speaking-Q4.html', 'flv', '21', '5', null);
INSERT INTO `ym_class_category_file_links` VALUES ('25', 'آشنایی با روند امتحان', 'این ویدیو ازسایت ETS  است که کلیاتی را در خصوص آشنایی با روند امتحان ارائه میکند که برای متقاضیان امتحان تافل بسیار مفید است.', 'https://www.ets.org/s/toefl/flash/15571_toefl_prometric.html', 'flv', '26', '19', null);
INSERT INTO `ym_class_category_file_links` VALUES ('26', 'چرا امتحان تافل', 'این ویدیو ازسایت ETS  نشان میدهد که چه کشورهایی تافل را قبول میکنن.', 'https://www.ets.org/s/toefl/flash/TOEFL_Passport_video.html', 'flv', '26', '20', null);
INSERT INTO `ym_class_category_file_links` VALUES ('27', 'کتاب یادگیری مهارت اسپیکینگ (سطح مقدماتی)', 'این کتاب و دو کتاب بعدی این مجموعه برای یادگیری مهارت اسپیکینک تافل آی بی تی بسیار فوق العاده هستند.', 'https://dl.dropboxusercontent.com/u/91531245/Building_Speaking.rar', 'rar', '21', '6', null);
INSERT INTO `ym_class_category_file_links` VALUES ('28', 'کتاب یادگیری مهارت اسپیکینگ (سطح متوسط)', 'این کتاب و دو کتاب دیگر این مجموعه برای یادگیری مهارت اسپیکینک تافل آی بی تی بسیار فوق العاده هستند.', 'https://dl.dropboxusercontent.com/u/91531245/Developing%20Speaking%20Intermediate.rar', 'rar', '21', '1', null);
INSERT INTO `ym_class_category_file_links` VALUES ('29', 'کتاب یادگیری مهارت اسپیکینگ (سطح پیشرفته)', 'این کتاب و دو کتاب قبلی این مجموعه برای یادگیری مهارت اسپیکینک تافل آی بی تی بسیار فوق العاده هستند.', 'https://dl.dropboxusercontent.com/u/91531245/Mastering%20Speaking%20for%20TOEFL%20iBT.rar', 'rar', '21', '2', null);
INSERT INTO `ym_class_category_file_links` VALUES ('31', 'نرم افزار یادگیری تایپ سریع', 'این نرم افزار به شما کمک میکند که در مدت کوتاهی تایپ سریع را بیاموزید.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTOWxYQmtTT1pwbE0', 'rar', '22', '9', null);
INSERT INTO `ym_class_category_file_links` VALUES ('32', '4000 واژه ضروری زبان انگلیسی جلد 1', 'این کتاب که اولین کتاب از یک مجموعه شش جلدی است منبع فوق العاده ای برای یادگیری واژگان انگلیسی است. همه واژه ها، معانی، و مثالها با لهجه آمریکایی خوانده میشوند و داستانی در انتهای هر درس دارد که این واژگان در آن بکار رفته که فرصت یادگیری لغات به صورت صحیح را به شما می دهد.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTS1JWRFNfV2NLN2s', 'rar', '30', '21', null);
INSERT INTO `ym_class_category_file_links` VALUES ('34', '4000 واژه ضروری زبان انگلیسی جلد 2', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTcGh4RlJjVmhUQkU', 'rar', '30', '22', null);
INSERT INTO `ym_class_category_file_links` VALUES ('35', '4000 واژه ضروری زبان انگلیسی جلد 3', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTQzFHb1FtREFrMjg', 'rar', '30', '23', null);
INSERT INTO `ym_class_category_file_links` VALUES ('36', '4000 واژه ضروری زبان انگلیسی جلد 4', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTZE1aNDk4OUtIYjg', 'rar', '30', '24', null);
INSERT INTO `ym_class_category_file_links` VALUES ('37', '4000 واژه ضروری زبان انگلیسی جلد 5', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTQVJCakhqVmRRc2s', 'rar', '30', '26', null);
INSERT INTO `ym_class_category_file_links` VALUES ('38', '4000 واژه ضروری زبان انگلیسی جلد 6', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTYnoyYWJHeF9qV0k', 'rar', '30', '25', null);
INSERT INTO `ym_class_category_file_links` VALUES ('39', 'کتاب دلتا (پی دی اف)', 'کتاب دلتا منبع بسیار خوبی است برای یادگیری مهارت ریدینگ و لیسنینگ ولی به هیچ عنوان کافی نیست. شما باید منابع دیگری که در \"رئوس‌ مطالب و برنامه مطالعه همه مهارت های تافل\" آمده مطالعه کنید تا در این مهارتها به تسلط کافی برسید.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTMGl0b3hNZVBfQms', 'rar', '20', '12', null);
INSERT INTO `ym_class_category_file_links` VALUES ('40', 'کتاب دلتا (پی دی اف)', 'کتاب دلتا منبع بسیار خوبی است برای یادگیری مهارت ریدینگ و لیسنینگ ولی به هیچ عنوان کافی نیست. شما باید منابع دیگری که در \"رئوس‌ مطالب و برنامه مطالعه همه مهارت های تافل\" آمده مطالعه کنید تا در این مهارتها به تسلط کافی برسید.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTMGl0b3hNZVBfQms', 'rar', '23', '17', null);
INSERT INTO `ym_class_category_file_links` VALUES ('41', 'فایل صوتی کتاب TOEFL Writing Success نوشته امیر خادم', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTT1Yyc2VWeWlqam8', 'rar', '22', '10', null);
INSERT INTO `ym_class_category_file_links` VALUES ('42', 'فایل صوتی کتاب دلتا', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTVHkwc05oeFZ3a2M', 'rar', '23', '18', null);
INSERT INTO `ym_class_category_file_links` VALUES ('43', '1. مقدمه ای بر GRE Analytical Writing (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTd3QtN2tUdzEyc2c', 'rar', '32', '30', null);
INSERT INTO `ym_class_category_file_links` VALUES ('44', '2. طریقه پاراگراف بندی در رایتینگ جی آر ای (فیلم)', '', 'https://drive.google.com/open?id=https://drive.google.com/open?id=0B8V9PkAm4QfTUERPSW1LckJsQmc', 'rar', '32', '31', null);
INSERT INTO `ym_class_category_file_links` VALUES ('45', '10. نمونه رایتنگ Argument (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTYThtSDZrazlJS0k', 'rar', '32', '39', null);
INSERT INTO `ym_class_category_file_links` VALUES ('46', '3. نکته هایی در مورد رایتینگ جی آر ای (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTMG43akxEUzJDdGM', 'rar', '32', '32', null);
INSERT INTO `ym_class_category_file_links` VALUES ('47', '4. مدیریت زمان در امتحان جی آر ای (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTSHNkbDNpVW5JRjg', 'rar', '32', '33', null);
INSERT INTO `ym_class_category_file_links` VALUES ('48', '5. مقدمه ای بر GRE Issue Task (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTMTlMRkZKTnc3QW8', 'rar', '32', '34', null);
INSERT INTO `ym_class_category_file_links` VALUES ('49', '6. نمونه رایتینگ Issue Task (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTZ3VqTnRfTFM4YTQ', 'rar', '32', '35', null);
INSERT INTO `ym_class_category_file_links` VALUES ('50', '7. مقدمه ای بر  GRE Argumnet Task (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTOGJCTzdzQXJvckk', 'rar', '32', '36', null);
INSERT INTO `ym_class_category_file_links` VALUES ('51', '8. روش پیدا کردن  اشتباهات منطقی رایتینگ Argument  (فیلم)', '', 'https://drive.google.com/open?id=https://drive.google.com/open?id=0B8V9PkAm4QfTVFRmNV96dGM4VVU', 'rar', '32', '37', null);
INSERT INTO `ym_class_category_file_links` VALUES ('52', '9. طریقه پیدا کردن و نوشتن اشتباهات منطقی رایتینگ Argument (فیلم)', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTZ1RKQm03NEtZOE0', 'rar', '32', '38', null);
INSERT INTO `ym_class_category_file_links` VALUES ('53', 'مقدمه ای بر  GRE Analytical Writing  (پی دی اف)', 'این پی دی اف 29 صفحه ای به طور موجز ولی کاربردی رایتینگ جی آر ای رو آموزش میده و در 3 صفحه آخر روش نمره دهی به هر دو رایتینگ را بسیار عالی توضیح داده.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTTk5LaVU1RGNEbDA', 'pdf', '32', '29', null);
INSERT INTO `ym_class_category_file_links` VALUES ('54', 'سوالات رایتینگ GRE بخش Argument ', 'این فایل شامل تمامی سوالات  رایتینگ GRE بخش Argument میباشد که حتما باید قبل از امتحان خوانده شود.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTbi1ObUNTc3lZRU0', 'pdf', '32', '42', null);
INSERT INTO `ym_class_category_file_links` VALUES ('55', 'سوالات رایتینگ GRE بخش Issue ', 'این فایل شامل تمامی سوالات  رایتینگ GRE بخش Issue میباشد که حتما باید قبل از امتحان خوانده شود.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTUXhPWUMySGNoNXc', 'pdf', '32', '43', null);
INSERT INTO `ym_class_category_file_links` VALUES ('56', 'کتاب کلمات ضروری برای امتحان تافل', 'این کتاب منبع خوبی برای امتحان تافل دکتری که در ایران برگزار میشه میباشد ولی برای تافل آی بی تی بهتره کتاب های دیگه ای که در سایت معرفی شده اند را بخوانید.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTYUxEQzFqWGVKNVU', 'pdf', '33', '46', null);
INSERT INTO `ym_class_category_file_links` VALUES ('57', 'پاسخ به سوالات رایتینگ جی آر ای', 'این کتاب نمونه رایتینگ های بسیار خوبی برای امتحان جی آر ای دارد که ایده های خیلی خوبی به داوطلبین این امتحان میدهد.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTN3pIZ1BtZW9uNGs', 'pdf', '32', '40', null);
INSERT INTO `ym_class_category_file_links` VALUES ('58', 'راهنمای امتحان جی آر ای توسط ETS (پی دی اف)', 'این کتاب که نسخه های جدید آن نیز منتشر شده منبع بسیار خوبی برای همه مهارت های امتحان جی آر ای است.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTaGUzVTRHQk1mSXc', 'pdf', '32', '28', null);
INSERT INTO `ym_class_category_file_links` VALUES ('59', 'کتاب جی آر ای Barron\'s', 'این کتاب نیز منبع بسیار خوبی برای همه مهارت های امتحان جی آر ای است.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTSkxKY1JjNHA2cms', 'pdf', '32', '41', null);
INSERT INTO `ym_class_category_file_links` VALUES ('60', 'کتاب لغت Verbal Advantage (پی دی اف)', 'این کتاب مرجع فوق العاده ای است برای تقویت واژگان جی آر ای که فایل صوتی آن نیز عالی است. ', 'https://drive.google.com/open?id=0B8V9PkAm4QfTRWRLV2h0Z0JGbUE', 'pdf', '32', '44', null);
INSERT INTO `ym_class_category_file_links` VALUES ('61', 'فایل های صوتی کتاب Verbal Advantage ', '', 'https://drive.google.com/open?id=0B8V9PkAm4QfTdFhlUmJabkhybTg', 'rar', '32', '45', null);
INSERT INTO `ym_class_category_file_links` VALUES ('62', 'کتاب اصطلاحات ضروری انگلیسی از سطح مقدماتی تا پیشرفته ', 'کتاب اصطلاحات ضروری انگلیسی که 3 سطح مبتدی، متوسط، و پیشرفته دارد برای هر 4 مهارت تافل ضروری است.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTZk9qRUZQTHhqbUU', 'pdf', '30', '27', null);
INSERT INTO `ym_class_category_file_links` VALUES ('64', 'کتاب اصطلاحات ضروری انگلیسی از سطح مقدماتی تا پیشرفته ', 'کتاب اصطلاحات ضروری انگلیسی از سطح مقدماتی تا پیشرفته یک منبع عالی برای یادگیری اصطلاحات است که به مهارت های لیسنینگ، اسپیکینگ، و رایتنگ کمک زیادی میکند.', 'https://drive.google.com/open?id=0B8V9PkAm4QfTZk9qRUZQTHhqbUU', 'pdf', '34', '47', null);
INSERT INTO `ym_class_category_file_links` VALUES ('65', 'ویدیوی آموزش تلفظ انگلیسی ', 'این فایل ویدئویی به زیبایی طریقه تلفظ لغات انگلیسی را آموزش میدهد که مهارتهای لیستنینگ و اسپیکینگ شما را تقویت میکند.', 'https://dl.dropboxusercontent.com/u/91531245/American%20Accent%20Video%20Training%20Program%20%28Pronunciation%20Workshop%29%201.rar', 'rar', '23', '13', null);
INSERT INTO `ym_class_category_file_links` VALUES ('66', 'آموزش تلفظ  انگلیسی', 'این کتاب یکی از بهترین منابع آموزش تلفظ کلمات، عبارت ها، و در نهایت جمله ها است. مطالعه کل کتاب عالی است، اما اگر محدودیت زمانی دارید، بخش  Reduced Sounds صفحه 57 کتاب را حتما گوش کنید و تکرار کنید که هم برای لیسنینگ و هم برای اسپیکینگ فوق العاده است. ', 'https://drive.google.com/open?id=0B8V9PkAm4QfTWXd3WGxWelRjS0E', 'rar', '23', '14', null);
INSERT INTO `ym_class_category_file_links` VALUES ('67', 'کتاب Just Listening and Speaking', 'این کتاب لهجه بریتانیایی را آموزش میدهد که در آزمون تافل آی بی تی پر بسامد میباشد.', 'https://dl.dropboxusercontent.com/u/91531245/Australian%20Accent%2C%20Just%20Listening%20and%20Speaking.rar', 'rar', '23', '15', null);
INSERT INTO `ym_class_category_file_links` VALUES ('68', 'فایل های صوتی Toefl ESL Pod', 'این فایل ها کل امتحان تافل را با انگلیسی ساده و روان توضیح میدهد و کلمات خیلی کاربردی ای هم در این ضمن تدریس میکند.', 'https://dl.dropboxusercontent.com/u/91531245/Toefl%20ESL%20Pod.rar', 'rar', '23', '16', null);
INSERT INTO `ym_class_category_file_links` VALUES ('69', 'لغتنامه های بابیلون', '', 'https://dl.dropboxusercontent.com/u/91531245/Babylon%20Glossaries.rar', 'rar', '22', '11', null);

-- ----------------------------
-- Table structure for ym_class_tags
-- ----------------------------
DROP TABLE IF EXISTS `ym_class_tags`;
CREATE TABLE `ym_class_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_class_tags
-- ----------------------------

-- ----------------------------
-- Table structure for ym_class_tag_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_class_tag_rel`;
CREATE TABLE `ym_class_tag_rel` (
  `tag_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`class_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `ym_class_tag_rel_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `ym_class_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_class_tag_rel_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `ym_classes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_class_tag_rel
-- ----------------------------

-- ----------------------------
-- Table structure for ym_comments
-- ----------------------------
DROP TABLE IF EXISTS `ym_comments`;
CREATE TABLE `ym_comments` (
  `owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `owner_id` int(12) NOT NULL,
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_comment_id` int(12) DEFAULT NULL,
  `creator_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_email` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_persian_ci,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `owner_name` (`owner_name`,`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('Pages', '2', '44', null, '34', null, null, 'test', '1464501796', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '45', null, '34', null, null, 'سلام خدنمشس سشیبد شسیب شسیلشسیب شسیبشسئیبمنشسیئ بمسی بم مشمسی ب', '1464501842', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '46', '45', '34', null, null, 'شسیلشسیلشسیب', '1464501848', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '47', null, '34', null, null, 'سیلشسل', '1464501853', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '48', null, '34', null, null, 'sdfasdf', '1464502171', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '49', null, '34', null, null, 'sadgsdg', '1464503306', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '50', null, '34', null, null, 'testttttttt', '1464503444', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '51', null, '34', null, null, 'efggasdgfdg', '1464503451', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '52', null, '34', null, null, 'tere', '1464503464', null, '0');
INSERT INTO `ym_comments` VALUES ('Pages', '2', '53', null, '34', null, null, 'asdgsdgsdgasf', '1464503479', null, '0');

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '132');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457538');
INSERT INTO `ym_counter_save` VALUES ('max_count', '18');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1462519800');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '1');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1464516086');

-- ----------------------------
-- Table structure for ym_courses
-- ----------------------------
DROP TABLE IF EXISTS `ym_courses`;
CREATE TABLE `ym_courses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `pic` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'تصویر',
  `summary` text COLLATE utf8_persian_ci NOT NULL COMMENT 'توضیحات',
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_courses
-- ----------------------------
INSERT INTO `ym_courses` VALUES ('13', 'تافل آی بی تی', 'ys60w1461190889.png', '<p>دوره تافل آی بی تی موسسه آوای شهیر زیر نظر&nbsp;امیر خادم،&nbsp;با رویکردی متفاوت از اغلب مراکز دیگر، برگزار میگردد<span dir=\"LTR\">.</span></p>\r\n', '3');
INSERT INTO `ym_courses` VALUES ('15', 'آیلتس', 'VtRG01462256706.jpg', '<p dir=\"RTL\" style=\"text-align:justify\">دوره های آموزش آیلتس&nbsp;موسسه پردیس آوای شهیر نیز مانند دوره های&nbsp;تافل آن&nbsp;تفاوت های چشمگیری&nbsp;دارد با دوره هایی که خود اینجانب، امیر خادم، سابقا برگزار میکردم و دوره هایی که موسسات دیگر برگزار میکنند.&nbsp;اول اینکه در این دوره ها تخفیف های ویژه ای&nbsp;برای&nbsp;دانشجویان عزیز در نظر گرفته شده &ndash; که بخشی از آن در سایت نت برگ ارائه خواهد شد &ndash; که شرایط ثبت نام را برای آنها ایده آل میکند. دوم اینکه، برعکس تمام موسسات، دو نمونه از رایتینگ های هر داوطلب به طور رایگان در طول ترم تصحیح میگردد که تاثیر به سزایی در نمره آیلتس آنها خواهد داشت. سوم اینکه در انتهای هر دوره، بنا به نیاز زبان آموزان، یک گارکاه چند ساعته برگزار خواهد شد که در آن صرفا نمونه رایتینگ هر یک از داوطلبین برسی شده ونکات کلیدی و نهایی به آنها آموخته میشود. با برگزاری این دوره ها، امیدواریم که بتوانیم سهم کوچکی در بالا بردن سطح علمی دانشجویان عزیزمان داشته باشیم و راه را برای پیشرفت های آتی آنها هموار سازیم.</p>\r\n\r\n<p dir=\"RTL\" style=\"text-align:justify\">با آرزوی بهروزی همه عزیزان</p>\r\n\r\n<p dir=\"RTL\">مدیر&nbsp;موسسه پردیس آوای شهیر</p>\r\n\r\n<p><span dir=\"RTL\">امیر خادم المله</span></p>\r\n', '2');
INSERT INTO `ym_courses` VALUES ('16', 'جی آر ای', 'Jrx8T1461469114.jpg', '<p>کتاب ها و منابعی که برای امتحان جی آر ای ارائه شده اند بسیاراند، ولی با خواندن این منابع گلچین شده میتوانید نمره دلخواهتان را بگیرید.</p>\r\n\r\n<p>با آرزوی موفقیت شما</p>\r\n\r\n<p>امیر خادم: مدیر موسسه پردیس آوای شهیر</p>\r\n', '4');
INSERT INTO `ym_courses` VALUES ('17', 'جی ام ای تی (جی مت)', 'pPOIC1462256630.jpg', '<p>این منابع از بهترین منابع امتحان&nbsp;جی ام ای تی (جی مت) هستند که امیدواریم برایتان سودمند باشند.&nbsp;</p>\r\n\r\n<p>امیر خادم</p>\r\n', '5');
INSERT INTO `ym_courses` VALUES ('18', 'تافل دکتری', 'e3OsE1461392230.jpg', '<p>امتحان تافل دکتری، که برای دانشجویان دکتری در ایران برگزار میگردد،&nbsp;همان امتحان تافل پی بی تی است با این تفاوت که بخش رایتینگ ندارد. بنابراین، خواندن این منابع برای یک نمره خوب کافی است.</p>\r\n', '1');

-- ----------------------------
-- Table structure for ym_gallery
-- ----------------------------
DROP TABLE IF EXISTS `ym_gallery`;
CREATE TABLE `ym_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  `desc` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `file_name` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'آدرس فایل',
  `order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_gallery
-- ----------------------------
INSERT INTO `ym_gallery` VALUES ('20', 'سالن کنفرانس', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '9f6gl1463392725.jpg', '1');
INSERT INTO `ym_gallery` VALUES ('21', 'ساختمان اصلی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 'tdXI41463392606.png', '2');

-- ----------------------------
-- Table structure for ym_google_maps
-- ----------------------------
DROP TABLE IF EXISTS `ym_google_maps`;
CREATE TABLE `ym_google_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `map_lat` varchar(30) NOT NULL DEFAULT '34.6327505',
  `map_lng` varchar(30) NOT NULL DEFAULT '50.8644157',
  `map_zoom` varchar(5) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_google_maps
-- ----------------------------
INSERT INTO `ym_google_maps` VALUES ('1', '', '35.72781914695719', '51.41998856328428', '19');

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('2', 'ارتباط با ادمین', null, '4');
INSERT INTO `ym_pages` VALUES ('3', 'تماس با ما', '<p>sadf</p>\r\n', '4');
INSERT INTO `ym_pages` VALUES ('5', 'قوانین و مقررات', '<p dir=\"RTL\"><strong>قوانین و مقررات موسسه آوای شهیر</strong></p>\r\n\r\n<ol>\r\n	<li dir=\"RTL\">رعایت شئونات اسلامی،&nbsp;قوانین، و مقررات جمهوری اسلامی ایران و همچنین مقررات موسسه الزامی میباشد<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">رعایت ادب در فضای مجازی چه در سایت چه در تلگرام الزامی می باشد<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">هیچ یک از اساتید، کارمندان، و مراجعین حق ندارند مسائل سیاسی را در محیط آموزشگاه و یا در فضای سایبری موسسه مطرح کند.</li>\r\n	<li dir=\"RTL\">شهریه به هیچ عنوان مسترد نمی گردد<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">همراه داشتن فیش ثبت نام برای اولین حضور سر کلاس&nbsp;الزامی می باشد<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">تغییر روز و ساعت کلاس امکان پذیر نمی باشد مگر با موافقت کتبی کلیه دانشجویان و استاد و تایید موسسه<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">استفاده از تلفن همراه در طول مدت کلاس ممنوع می باشد<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">توضیحات مندرجه در مورد هر دوره را با دقت مطالعه نموده و متناسب با این توضیحات ثبت نام فرمایید<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">اطلاعیه ها و دستورالعمل هایی که&nbsp;در سایت و یا از طریق تلگرام در اختیارتان قرار میگیرد&nbsp;را بدقت مطالعه فرمایید<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\">آوای شهیر هرگز اطلاعات شما را بصورت تلفنی یا از طریق پیامک درخواست نخواهد کرد. درصورتیکه فردی با این عنوان اطلاعات شما را درخواست نمود، موارد را به مدیریت گزارش فرمایید<span dir=\"LTR\">.</span></li>\r\n	<li dir=\"RTL\"><span dir=\"RTL\">هرگونه مورد نامناسبی</span>&nbsp;<span dir=\"RTL\">در فضای کلاس و موسسه را بلافاصله به مدیریت گزارش فرمایید</span>.</li>\r\n</ol>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('12', 'درباره ما', '<p>موسسه پردیس آوای شهیر یک موسسه علمی-فرهنگی است که در سال 1394 تاسیس شده و که در زمینه های فرهنگی وهنری به طور عام و آموزش زبان انگلیسی به طور خاص فعالیت خود را آغاز کرده و تلاش میکند تا خدماتی نو و خلاقانه را که درخور مردم عزیز ایران است را ارايه کند.<br />\r\nبه امید بهروزی شما<br />\r\nمدیر موسسه آوای شهیر: امیر خادم المله</p>\r\n', '4');
INSERT INTO `ym_pages` VALUES ('13', 'سلام', '<p>سشیکمئبمسشئبئکم سشنمبئکشسمنئی سشنئب کنمشسئ</p>\r\n', '2');
INSERT INTO `ym_pages` VALUES ('14', 'راهنما', '<p>ستیدبمشسکدئیب</p>\r\n', '2');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'قوانین', 'rules', '1');
INSERT INTO `ym_page_categories` VALUES ('2', 'راهنما', 'guide', '1');
INSERT INTO `ym_page_categories` VALUES ('3', 'آزاد', 'free', '1');
INSERT INTO `ym_page_categories` VALUES ('4', 'صفحات اصلی', 'base', '1');

-- ----------------------------
-- Table structure for ym_personnel
-- ----------------------------
DROP TABLE IF EXISTS `ym_personnel`;
CREATE TABLE `ym_personnel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام',
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام خانوادگی',
  `post` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'سمت',
  `avatar` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آواتار',
  `resume` text COLLATE utf8_persian_ci COMMENT 'رزومه',
  `email` varchar(100) COLLATE utf8_persian_ci NOT NULL COMMENT 'پست الکترونیک',
  `social_links` varchar(2000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شبکه های اجتماعی',
  `grade` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'سطح تحصیلات',
  `tell` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL,
  `address` text COLLATE utf8_persian_ci,
  `file` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل رزومه',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_personnel
-- ----------------------------

-- ----------------------------
-- Table structure for ym_places
-- ----------------------------
DROP TABLE IF EXISTS `ym_places`;
CREATE TABLE `ym_places` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `name` varchar(200) NOT NULL COMMENT 'عنوان',
  `town_id` int(10) unsigned NOT NULL COMMENT 'والد',
  PRIMARY KEY (`id`),
  KEY `town_id` (`town_id`),
  CONSTRAINT `ym_places_ibfk_1` FOREIGN KEY (`town_id`) REFERENCES `ym_towns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=444 DEFAULT CHARSET=utf8 COMMENT='شهر ها';

-- ----------------------------
-- Records of ym_places
-- ----------------------------
INSERT INTO `ym_places` VALUES ('1', 'تبریز', '1');
INSERT INTO `ym_places` VALUES ('2', 'كندوان', '1');
INSERT INTO `ym_places` VALUES ('3', 'بندر شرفخانه', '1');
INSERT INTO `ym_places` VALUES ('4', 'مراغه', '1');
INSERT INTO `ym_places` VALUES ('5', ' ', '1');
INSERT INTO `ym_places` VALUES ('6', 'شبستر', '1');
INSERT INTO `ym_places` VALUES ('7', 'مرند', '1');
INSERT INTO `ym_places` VALUES ('8', 'جلفا', '1');
INSERT INTO `ym_places` VALUES ('9', 'سراب', '1');
INSERT INTO `ym_places` VALUES ('10', 'هادیشهر', '1');
INSERT INTO `ym_places` VALUES ('11', 'بناب', '1');
INSERT INTO `ym_places` VALUES ('12', 'كلیبر', '1');
INSERT INTO `ym_places` VALUES ('13', 'تسوج', '1');
INSERT INTO `ym_places` VALUES ('14', 'اهر', '1');
INSERT INTO `ym_places` VALUES ('15', 'هریس', '1');
INSERT INTO `ym_places` VALUES ('16', 'عجبشیر', '1');
INSERT INTO `ym_places` VALUES ('17', 'هشترود', '1');
INSERT INTO `ym_places` VALUES ('18', 'ملكان', '1');
INSERT INTO `ym_places` VALUES ('19', 'بستان آباد', '1');
INSERT INTO `ym_places` VALUES ('20', 'ورزقان', '1');
INSERT INTO `ym_places` VALUES ('21', 'اسكو', '1');
INSERT INTO `ym_places` VALUES ('22', 'آذر شهر', '1');
INSERT INTO `ym_places` VALUES ('23', 'قره آغاج', '1');
INSERT INTO `ym_places` VALUES ('24', 'ممقان', '1');
INSERT INTO `ym_places` VALUES ('25', 'صوفیان', '1');
INSERT INTO `ym_places` VALUES ('26', 'ایلخچی', '1');
INSERT INTO `ym_places` VALUES ('27', 'خسروشهر', '1');
INSERT INTO `ym_places` VALUES ('28', 'باسمنج', '1');
INSERT INTO `ym_places` VALUES ('29', 'سهند', '1');
INSERT INTO `ym_places` VALUES ('30', 'ارومیه', '2');
INSERT INTO `ym_places` VALUES ('31', 'نقده', '2');
INSERT INTO `ym_places` VALUES ('32', 'ماكو', '2');
INSERT INTO `ym_places` VALUES ('33', 'تكاب', '2');
INSERT INTO `ym_places` VALUES ('34', 'خوی', '2');
INSERT INTO `ym_places` VALUES ('35', 'مهاباد', '2');
INSERT INTO `ym_places` VALUES ('36', 'سر دشت', '2');
INSERT INTO `ym_places` VALUES ('37', 'چالدران', '2');
INSERT INTO `ym_places` VALUES ('38', 'بوكان', '2');
INSERT INTO `ym_places` VALUES ('39', 'میاندوآب', '2');
INSERT INTO `ym_places` VALUES ('40', 'سلماس', '2');
INSERT INTO `ym_places` VALUES ('41', 'شاهین دژ', '2');
INSERT INTO `ym_places` VALUES ('42', 'پیرانشهر', '2');
INSERT INTO `ym_places` VALUES ('43', 'سیه چشمه', '2');
INSERT INTO `ym_places` VALUES ('44', 'اشنویه', '2');
INSERT INTO `ym_places` VALUES ('45', 'چایپاره', '2');
INSERT INTO `ym_places` VALUES ('46', 'پلدشت', '2');
INSERT INTO `ym_places` VALUES ('47', 'شوط', '2');
INSERT INTO `ym_places` VALUES ('48', 'اردبیل', '3');
INSERT INTO `ym_places` VALUES ('49', 'سرعین', '3');
INSERT INTO `ym_places` VALUES ('50', 'بیله سوار', '3');
INSERT INTO `ym_places` VALUES ('51', 'پارس آباد', '3');
INSERT INTO `ym_places` VALUES ('52', 'خلخال', '3');
INSERT INTO `ym_places` VALUES ('53', 'مشگین شهر', '3');
INSERT INTO `ym_places` VALUES ('54', 'مغان', '3');
INSERT INTO `ym_places` VALUES ('55', 'نمین', '3');
INSERT INTO `ym_places` VALUES ('56', 'نیر', '3');
INSERT INTO `ym_places` VALUES ('57', 'كوثر', '3');
INSERT INTO `ym_places` VALUES ('58', 'کیوی', '3');
INSERT INTO `ym_places` VALUES ('59', 'گرمی', '3');
INSERT INTO `ym_places` VALUES ('60', 'اصفهان', '4');
INSERT INTO `ym_places` VALUES ('61', 'فریدن', '4');
INSERT INTO `ym_places` VALUES ('62', 'فریدون شهر', '4');
INSERT INTO `ym_places` VALUES ('63', 'فلاورجان', '4');
INSERT INTO `ym_places` VALUES ('64', 'گلپایگان', '4');
INSERT INTO `ym_places` VALUES ('65', 'دهاقان', '4');
INSERT INTO `ym_places` VALUES ('66', 'نطنز', '4');
INSERT INTO `ym_places` VALUES ('67', 'نایین', '4');
INSERT INTO `ym_places` VALUES ('68', 'تیران', '4');
INSERT INTO `ym_places` VALUES ('69', 'كاشان', '4');
INSERT INTO `ym_places` VALUES ('70', 'فولاد شهر', '4');
INSERT INTO `ym_places` VALUES ('71', 'اردستان', '4');
INSERT INTO `ym_places` VALUES ('72', 'سمیرم', '4');
INSERT INTO `ym_places` VALUES ('73', 'درچه', '4');
INSERT INTO `ym_places` VALUES ('74', 'کوهپایه', '4');
INSERT INTO `ym_places` VALUES ('75', 'مباركه', '4');
INSERT INTO `ym_places` VALUES ('76', 'شهرضا', '4');
INSERT INTO `ym_places` VALUES ('77', 'خمینی شهر', '4');
INSERT INTO `ym_places` VALUES ('78', 'شاهین شهر', '4');
INSERT INTO `ym_places` VALUES ('79', 'نجف آباد', '4');
INSERT INTO `ym_places` VALUES ('80', 'دولت آباد', '4');
INSERT INTO `ym_places` VALUES ('81', 'زرین شهر', '4');
INSERT INTO `ym_places` VALUES ('82', 'آران و بیدگل', '4');
INSERT INTO `ym_places` VALUES ('83', 'باغ بهادران', '4');
INSERT INTO `ym_places` VALUES ('84', 'خوانسار', '4');
INSERT INTO `ym_places` VALUES ('85', 'مهردشت', '4');
INSERT INTO `ym_places` VALUES ('86', 'علویجه', '4');
INSERT INTO `ym_places` VALUES ('87', 'عسگران', '4');
INSERT INTO `ym_places` VALUES ('88', 'نهضت آباد', '4');
INSERT INTO `ym_places` VALUES ('89', 'حاجی آباد', '4');
INSERT INTO `ym_places` VALUES ('90', 'تودشک', '4');
INSERT INTO `ym_places` VALUES ('91', 'ورزنه', '4');
INSERT INTO `ym_places` VALUES ('92', 'ایلام', '6');
INSERT INTO `ym_places` VALUES ('93', 'مهران', '6');
INSERT INTO `ym_places` VALUES ('94', 'دهلران', '6');
INSERT INTO `ym_places` VALUES ('95', 'آبدانان', '6');
INSERT INTO `ym_places` VALUES ('96', 'شیروان چرداول', '6');
INSERT INTO `ym_places` VALUES ('97', 'دره شهر', '6');
INSERT INTO `ym_places` VALUES ('98', 'ایوان', '6');
INSERT INTO `ym_places` VALUES ('99', 'سرابله', '6');
INSERT INTO `ym_places` VALUES ('100', 'بوشهر', '7');
INSERT INTO `ym_places` VALUES ('101', 'تنگستان', '7');
INSERT INTO `ym_places` VALUES ('102', 'دشتستان', '7');
INSERT INTO `ym_places` VALUES ('103', 'دیر', '7');
INSERT INTO `ym_places` VALUES ('104', 'دیلم', '7');
INSERT INTO `ym_places` VALUES ('105', 'كنگان', '7');
INSERT INTO `ym_places` VALUES ('106', 'گناوه', '7');
INSERT INTO `ym_places` VALUES ('107', 'ریشهر', '7');
INSERT INTO `ym_places` VALUES ('108', 'دشتی', '7');
INSERT INTO `ym_places` VALUES ('109', 'خورموج', '7');
INSERT INTO `ym_places` VALUES ('110', 'اهرم', '7');
INSERT INTO `ym_places` VALUES ('111', 'برازجان', '7');
INSERT INTO `ym_places` VALUES ('112', 'خارك', '7');
INSERT INTO `ym_places` VALUES ('113', 'جم', '7');
INSERT INTO `ym_places` VALUES ('114', 'کاکی', '7');
INSERT INTO `ym_places` VALUES ('115', 'عسلویه', '7');
INSERT INTO `ym_places` VALUES ('116', 'بردخون', '7');
INSERT INTO `ym_places` VALUES ('117', 'تهران', '8');
INSERT INTO `ym_places` VALUES ('118', 'ورامین', '8');
INSERT INTO `ym_places` VALUES ('119', 'فیروزكوه', '8');
INSERT INTO `ym_places` VALUES ('120', 'ری', '8');
INSERT INTO `ym_places` VALUES ('121', 'دماوند', '8');
INSERT INTO `ym_places` VALUES ('122', 'اسلامشهر', '8');
INSERT INTO `ym_places` VALUES ('123', 'رودهن', '8');
INSERT INTO `ym_places` VALUES ('124', 'لواسان', '8');
INSERT INTO `ym_places` VALUES ('125', 'بومهن', '8');
INSERT INTO `ym_places` VALUES ('126', 'تجریش', '8');
INSERT INTO `ym_places` VALUES ('127', 'فشم', '8');
INSERT INTO `ym_places` VALUES ('128', 'كهریزك', '8');
INSERT INTO `ym_places` VALUES ('129', 'پاكدشت', '8');
INSERT INTO `ym_places` VALUES ('130', 'چهاردانگه', '8');
INSERT INTO `ym_places` VALUES ('131', 'شریف آباد', '8');
INSERT INTO `ym_places` VALUES ('132', 'قرچك', '8');
INSERT INTO `ym_places` VALUES ('133', 'باقرشهر', '8');
INSERT INTO `ym_places` VALUES ('134', 'شهریار', '8');
INSERT INTO `ym_places` VALUES ('135', 'رباط كریم', '8');
INSERT INTO `ym_places` VALUES ('136', 'قدس', '8');
INSERT INTO `ym_places` VALUES ('137', 'ملارد', '8');
INSERT INTO `ym_places` VALUES ('138', 'شهركرد', '9');
INSERT INTO `ym_places` VALUES ('139', 'فارسان', '9');
INSERT INTO `ym_places` VALUES ('140', 'بروجن', '9');
INSERT INTO `ym_places` VALUES ('141', 'چلگرد', '9');
INSERT INTO `ym_places` VALUES ('142', 'اردل', '9');
INSERT INTO `ym_places` VALUES ('143', 'لردگان', '9');
INSERT INTO `ym_places` VALUES ('144', 'سامان', '9');
INSERT INTO `ym_places` VALUES ('145', 'قائن', '10');
INSERT INTO `ym_places` VALUES ('146', 'فردوس', '10');
INSERT INTO `ym_places` VALUES ('147', 'بیرجند', '10');
INSERT INTO `ym_places` VALUES ('148', 'نهبندان', '10');
INSERT INTO `ym_places` VALUES ('149', 'سربیشه', '10');
INSERT INTO `ym_places` VALUES ('150', 'طبس مسینا', '10');
INSERT INTO `ym_places` VALUES ('151', 'قهستان', '10');
INSERT INTO `ym_places` VALUES ('152', 'درمیان', '10');
INSERT INTO `ym_places` VALUES ('153', 'مشهد', '11');
INSERT INTO `ym_places` VALUES ('154', 'نیشابور', '11');
INSERT INTO `ym_places` VALUES ('155', 'سبزوار', '11');
INSERT INTO `ym_places` VALUES ('156', 'كاشمر', '11');
INSERT INTO `ym_places` VALUES ('157', 'گناباد', '11');
INSERT INTO `ym_places` VALUES ('158', 'طبس', '11');
INSERT INTO `ym_places` VALUES ('159', 'تربت حیدریه', '11');
INSERT INTO `ym_places` VALUES ('160', 'خواف', '11');
INSERT INTO `ym_places` VALUES ('161', 'تربت جام', '11');
INSERT INTO `ym_places` VALUES ('162', 'تایباد', '11');
INSERT INTO `ym_places` VALUES ('163', 'قوچان', '11');
INSERT INTO `ym_places` VALUES ('164', 'سرخس', '11');
INSERT INTO `ym_places` VALUES ('165', 'بردسكن', '11');
INSERT INTO `ym_places` VALUES ('166', 'فریمان', '11');
INSERT INTO `ym_places` VALUES ('167', 'چناران', '11');
INSERT INTO `ym_places` VALUES ('168', 'درگز', '11');
INSERT INTO `ym_places` VALUES ('169', 'كلات', '11');
INSERT INTO `ym_places` VALUES ('170', 'طرقبه', '11');
INSERT INTO `ym_places` VALUES ('171', 'سر ولایت', '11');
INSERT INTO `ym_places` VALUES ('172', 'بجنورد', '12');
INSERT INTO `ym_places` VALUES ('173', 'اسفراین', '12');
INSERT INTO `ym_places` VALUES ('174', 'جاجرم', '12');
INSERT INTO `ym_places` VALUES ('175', 'شیروان', '12');
INSERT INTO `ym_places` VALUES ('176', 'آشخانه', '12');
INSERT INTO `ym_places` VALUES ('177', 'گرمه', '12');
INSERT INTO `ym_places` VALUES ('178', 'ساروج', '12');
INSERT INTO `ym_places` VALUES ('179', 'اهواز', '13');
INSERT INTO `ym_places` VALUES ('181', 'شوش', '13');
INSERT INTO `ym_places` VALUES ('182', 'آبادان', '13');
INSERT INTO `ym_places` VALUES ('183', 'خرمشهر', '13');
INSERT INTO `ym_places` VALUES ('184', 'مسجد سلیمان', '13');
INSERT INTO `ym_places` VALUES ('185', 'ایذه', '13');
INSERT INTO `ym_places` VALUES ('186', 'شوشتر', '13');
INSERT INTO `ym_places` VALUES ('187', 'اندیمشك', '13');
INSERT INTO `ym_places` VALUES ('188', 'سوسنگرد', '13');
INSERT INTO `ym_places` VALUES ('189', 'هویزه', '13');
INSERT INTO `ym_places` VALUES ('190', 'دزفول', '13');
INSERT INTO `ym_places` VALUES ('191', 'شادگان', '13');
INSERT INTO `ym_places` VALUES ('192', 'بندر ماهشهر', '13');
INSERT INTO `ym_places` VALUES ('193', 'بندر امام خمینی', '13');
INSERT INTO `ym_places` VALUES ('194', 'امیدیه', '13');
INSERT INTO `ym_places` VALUES ('195', 'بهبهان', '13');
INSERT INTO `ym_places` VALUES ('196', 'رامهرمز', '13');
INSERT INTO `ym_places` VALUES ('197', 'باغ ملك', '13');
INSERT INTO `ym_places` VALUES ('198', 'هندیجان', '13');
INSERT INTO `ym_places` VALUES ('199', 'لالی', '13');
INSERT INTO `ym_places` VALUES ('200', 'رامشیر', '13');
INSERT INTO `ym_places` VALUES ('201', 'حمیدیه', '13');
INSERT INTO `ym_places` VALUES ('202', 'دغاغله', '13');
INSERT INTO `ym_places` VALUES ('203', 'ملاثانی', '13');
INSERT INTO `ym_places` VALUES ('204', 'شادگان', '13');
INSERT INTO `ym_places` VALUES ('205', 'ویسی', '13');
INSERT INTO `ym_places` VALUES ('206', 'زنجان', '14');
INSERT INTO `ym_places` VALUES ('207', 'ابهر', '14');
INSERT INTO `ym_places` VALUES ('208', 'خدابنده', '14');
INSERT INTO `ym_places` VALUES ('209', 'كارم', '14');
INSERT INTO `ym_places` VALUES ('210', 'ماهنشان', '14');
INSERT INTO `ym_places` VALUES ('211', 'خرمدره', '14');
INSERT INTO `ym_places` VALUES ('212', 'ایجرود', '14');
INSERT INTO `ym_places` VALUES ('213', 'زرین آباد', '14');
INSERT INTO `ym_places` VALUES ('214', 'آب بر', '14');
INSERT INTO `ym_places` VALUES ('215', 'قیدار', '14');
INSERT INTO `ym_places` VALUES ('216', 'سمنان', '15');
INSERT INTO `ym_places` VALUES ('217', 'شاهرود', '15');
INSERT INTO `ym_places` VALUES ('218', 'گرمسار', '15');
INSERT INTO `ym_places` VALUES ('219', 'ایوانكی', '15');
INSERT INTO `ym_places` VALUES ('220', 'دامغان', '15');
INSERT INTO `ym_places` VALUES ('221', 'بسطام', '15');
INSERT INTO `ym_places` VALUES ('222', 'زاهدان', '16');
INSERT INTO `ym_places` VALUES ('223', 'چابهار', '16');
INSERT INTO `ym_places` VALUES ('224', 'خاش', '16');
INSERT INTO `ym_places` VALUES ('225', 'سراوان', '16');
INSERT INTO `ym_places` VALUES ('226', 'زابل', '16');
INSERT INTO `ym_places` VALUES ('227', 'سرباز', '16');
INSERT INTO `ym_places` VALUES ('228', 'نیكشهر', '16');
INSERT INTO `ym_places` VALUES ('229', 'ایرانشهر', '16');
INSERT INTO `ym_places` VALUES ('230', 'راسك', '16');
INSERT INTO `ym_places` VALUES ('231', 'میرجاوه', '16');
INSERT INTO `ym_places` VALUES ('232', 'شیراز', '17');
INSERT INTO `ym_places` VALUES ('233', 'اقلید', '17');
INSERT INTO `ym_places` VALUES ('234', 'داراب', '17');
INSERT INTO `ym_places` VALUES ('235', 'فسا', '17');
INSERT INTO `ym_places` VALUES ('236', 'مرودشت', '17');
INSERT INTO `ym_places` VALUES ('237', 'خرم بید', '17');
INSERT INTO `ym_places` VALUES ('238', 'آباده', '17');
INSERT INTO `ym_places` VALUES ('239', 'كازرون', '17');
INSERT INTO `ym_places` VALUES ('240', 'ممسنی', '17');
INSERT INTO `ym_places` VALUES ('241', 'سپیدان', '17');
INSERT INTO `ym_places` VALUES ('242', 'لار', '17');
INSERT INTO `ym_places` VALUES ('243', 'فیروز آباد', '17');
INSERT INTO `ym_places` VALUES ('244', 'جهرم', '17');
INSERT INTO `ym_places` VALUES ('245', 'نی ریز', '17');
INSERT INTO `ym_places` VALUES ('246', 'استهبان', '17');
INSERT INTO `ym_places` VALUES ('247', 'لامرد', '17');
INSERT INTO `ym_places` VALUES ('248', 'مهر', '17');
INSERT INTO `ym_places` VALUES ('249', 'حاجی آباد', '17');
INSERT INTO `ym_places` VALUES ('250', 'نورآباد', '17');
INSERT INTO `ym_places` VALUES ('251', 'اردكان', '17');
INSERT INTO `ym_places` VALUES ('252', 'صفاشهر', '17');
INSERT INTO `ym_places` VALUES ('253', 'ارسنجان', '17');
INSERT INTO `ym_places` VALUES ('254', 'قیروكارزین', '17');
INSERT INTO `ym_places` VALUES ('255', 'سوریان', '17');
INSERT INTO `ym_places` VALUES ('256', 'فراشبند', '17');
INSERT INTO `ym_places` VALUES ('257', 'سروستان', '17');
INSERT INTO `ym_places` VALUES ('258', 'ارژن', '17');
INSERT INTO `ym_places` VALUES ('259', 'گویم', '17');
INSERT INTO `ym_places` VALUES ('260', 'داریون', '17');
INSERT INTO `ym_places` VALUES ('261', 'زرقان', '17');
INSERT INTO `ym_places` VALUES ('262', 'خان زنیان', '17');
INSERT INTO `ym_places` VALUES ('263', 'کوار', '17');
INSERT INTO `ym_places` VALUES ('264', 'ده بید', '17');
INSERT INTO `ym_places` VALUES ('265', 'باب انار/خفر', '17');
INSERT INTO `ym_places` VALUES ('266', 'بوانات', '17');
INSERT INTO `ym_places` VALUES ('267', 'خرامه', '17');
INSERT INTO `ym_places` VALUES ('268', 'خنج', '17');
INSERT INTO `ym_places` VALUES ('269', 'سیاخ دارنگون', '17');
INSERT INTO `ym_places` VALUES ('270', 'قزوین', '18');
INSERT INTO `ym_places` VALUES ('271', 'تاكستان', '18');
INSERT INTO `ym_places` VALUES ('272', 'آبیك', '18');
INSERT INTO `ym_places` VALUES ('273', 'بوئین زهرا', '18');
INSERT INTO `ym_places` VALUES ('274', 'قم', '19');
INSERT INTO `ym_places` VALUES ('275', 'طالقان', '5');
INSERT INTO `ym_places` VALUES ('276', 'نظرآباد', '5');
INSERT INTO `ym_places` VALUES ('277', 'اشتهارد', '5');
INSERT INTO `ym_places` VALUES ('278', 'هشتگرد', '5');
INSERT INTO `ym_places` VALUES ('279', 'كن', '5');
INSERT INTO `ym_places` VALUES ('280', 'آسارا', '5');
INSERT INTO `ym_places` VALUES ('281', 'شهرک گلستان', '5');
INSERT INTO `ym_places` VALUES ('282', 'اندیشه', '5');
INSERT INTO `ym_places` VALUES ('283', 'كرج', '5');
INSERT INTO `ym_places` VALUES ('284', 'نظر آباد', '5');
INSERT INTO `ym_places` VALUES ('285', 'گوهردشت', '5');
INSERT INTO `ym_places` VALUES ('286', 'ماهدشت', '5');
INSERT INTO `ym_places` VALUES ('287', 'مشکین دشت', '5');
INSERT INTO `ym_places` VALUES ('288', 'سنندج', '20');
INSERT INTO `ym_places` VALUES ('289', 'دیواندره', '20');
INSERT INTO `ym_places` VALUES ('290', 'بانه', '20');
INSERT INTO `ym_places` VALUES ('291', 'بیجار', '20');
INSERT INTO `ym_places` VALUES ('292', 'سقز', '20');
INSERT INTO `ym_places` VALUES ('293', 'كامیاران', '20');
INSERT INTO `ym_places` VALUES ('294', 'قروه', '20');
INSERT INTO `ym_places` VALUES ('295', 'مریوان', '20');
INSERT INTO `ym_places` VALUES ('296', 'صلوات آباد', '20');
INSERT INTO `ym_places` VALUES ('297', 'حسن آباد', '20');
INSERT INTO `ym_places` VALUES ('298', 'كرمان', '21');
INSERT INTO `ym_places` VALUES ('299', 'راور', '21');
INSERT INTO `ym_places` VALUES ('300', 'بابك', '21');
INSERT INTO `ym_places` VALUES ('301', 'انار', '21');
INSERT INTO `ym_places` VALUES ('302', 'کوهبنان', '21');
INSERT INTO `ym_places` VALUES ('303', 'رفسنجان', '21');
INSERT INTO `ym_places` VALUES ('304', 'بافت', '21');
INSERT INTO `ym_places` VALUES ('305', 'سیرجان', '21');
INSERT INTO `ym_places` VALUES ('306', 'كهنوج', '21');
INSERT INTO `ym_places` VALUES ('307', 'زرند', '21');
INSERT INTO `ym_places` VALUES ('308', 'بم', '21');
INSERT INTO `ym_places` VALUES ('309', 'جیرفت', '21');
INSERT INTO `ym_places` VALUES ('310', 'بردسیر', '21');
INSERT INTO `ym_places` VALUES ('311', 'كرمانشاه', '22');
INSERT INTO `ym_places` VALUES ('312', 'اسلام آباد غرب', '22');
INSERT INTO `ym_places` VALUES ('313', 'سر پل ذهاب', '22');
INSERT INTO `ym_places` VALUES ('314', 'كنگاور', '22');
INSERT INTO `ym_places` VALUES ('315', 'سنقر', '22');
INSERT INTO `ym_places` VALUES ('316', 'قصر شیرین', '22');
INSERT INTO `ym_places` VALUES ('317', 'گیلان غرب', '22');
INSERT INTO `ym_places` VALUES ('318', 'هرسین', '22');
INSERT INTO `ym_places` VALUES ('319', 'صحنه', '22');
INSERT INTO `ym_places` VALUES ('320', 'پاوه', '22');
INSERT INTO `ym_places` VALUES ('321', 'جوانرود', '22');
INSERT INTO `ym_places` VALUES ('322', 'شاهو', '22');
INSERT INTO `ym_places` VALUES ('323', 'یاسوج', '23');
INSERT INTO `ym_places` VALUES ('324', 'گچساران', '23');
INSERT INTO `ym_places` VALUES ('325', 'دنا', '23');
INSERT INTO `ym_places` VALUES ('326', 'دوگنبدان', '23');
INSERT INTO `ym_places` VALUES ('327', 'سی سخت', '23');
INSERT INTO `ym_places` VALUES ('328', 'دهدشت', '23');
INSERT INTO `ym_places` VALUES ('329', 'لیكك', '23');
INSERT INTO `ym_places` VALUES ('330', 'گرگان', '24');
INSERT INTO `ym_places` VALUES ('331', 'آق قلا', '24');
INSERT INTO `ym_places` VALUES ('332', 'گنبد كاووس', '24');
INSERT INTO `ym_places` VALUES ('333', 'علی آباد كتول', '24');
INSERT INTO `ym_places` VALUES ('334', 'مینو دشت', '24');
INSERT INTO `ym_places` VALUES ('335', 'تركمن', '24');
INSERT INTO `ym_places` VALUES ('336', 'كردكوی', '24');
INSERT INTO `ym_places` VALUES ('337', 'بندر گز', '24');
INSERT INTO `ym_places` VALUES ('338', 'كلاله', '24');
INSERT INTO `ym_places` VALUES ('339', 'آزاد شهر', '24');
INSERT INTO `ym_places` VALUES ('340', 'رامیان', '24');
INSERT INTO `ym_places` VALUES ('341', 'رشت', '25');
INSERT INTO `ym_places` VALUES ('342', 'منجیل', '25');
INSERT INTO `ym_places` VALUES ('343', 'لنگرود', '25');
INSERT INTO `ym_places` VALUES ('344', 'رود سر', '25');
INSERT INTO `ym_places` VALUES ('345', 'تالش', '25');
INSERT INTO `ym_places` VALUES ('346', 'آستارا', '25');
INSERT INTO `ym_places` VALUES ('347', 'ماسوله', '25');
INSERT INTO `ym_places` VALUES ('348', 'آستانه اشرفیه', '25');
INSERT INTO `ym_places` VALUES ('349', 'رودبار', '25');
INSERT INTO `ym_places` VALUES ('350', 'فومن', '25');
INSERT INTO `ym_places` VALUES ('351', 'صومعه سرا', '25');
INSERT INTO `ym_places` VALUES ('352', 'بندرانزلی', '25');
INSERT INTO `ym_places` VALUES ('353', 'كلاچای', '25');
INSERT INTO `ym_places` VALUES ('354', 'هشتپر', '25');
INSERT INTO `ym_places` VALUES ('355', 'رضوان شهر', '25');
INSERT INTO `ym_places` VALUES ('356', 'ماسال', '25');
INSERT INTO `ym_places` VALUES ('357', 'شفت', '25');
INSERT INTO `ym_places` VALUES ('358', 'سیاهكل', '25');
INSERT INTO `ym_places` VALUES ('359', 'املش', '25');
INSERT INTO `ym_places` VALUES ('360', 'لاهیجان', '25');
INSERT INTO `ym_places` VALUES ('361', 'خشک بیجار', '25');
INSERT INTO `ym_places` VALUES ('362', 'خمام', '25');
INSERT INTO `ym_places` VALUES ('363', 'لشت نشا', '25');
INSERT INTO `ym_places` VALUES ('364', 'بندر کیاشهر', '25');
INSERT INTO `ym_places` VALUES ('365', 'خرم آباد', '26');
INSERT INTO `ym_places` VALUES ('366', 'ماهشهر', '26');
INSERT INTO `ym_places` VALUES ('367', 'دزفول', '26');
INSERT INTO `ym_places` VALUES ('368', 'بروجرد', '26');
INSERT INTO `ym_places` VALUES ('369', 'دورود', '26');
INSERT INTO `ym_places` VALUES ('370', 'الیگودرز', '26');
INSERT INTO `ym_places` VALUES ('371', 'ازنا', '26');
INSERT INTO `ym_places` VALUES ('372', 'نور آباد', '26');
INSERT INTO `ym_places` VALUES ('373', 'كوهدشت', '26');
INSERT INTO `ym_places` VALUES ('374', 'الشتر', '26');
INSERT INTO `ym_places` VALUES ('375', 'پلدختر', '26');
INSERT INTO `ym_places` VALUES ('376', 'ساری', '27');
INSERT INTO `ym_places` VALUES ('377', 'آمل', '27');
INSERT INTO `ym_places` VALUES ('378', 'بابل', '27');
INSERT INTO `ym_places` VALUES ('379', 'بابلسر', '27');
INSERT INTO `ym_places` VALUES ('380', 'بهشهر', '27');
INSERT INTO `ym_places` VALUES ('381', 'تنكابن', '27');
INSERT INTO `ym_places` VALUES ('382', 'جویبار', '27');
INSERT INTO `ym_places` VALUES ('383', 'چالوس', '27');
INSERT INTO `ym_places` VALUES ('384', 'رامسر', '27');
INSERT INTO `ym_places` VALUES ('385', 'سواد كوه', '27');
INSERT INTO `ym_places` VALUES ('386', 'قائم شهر', '27');
INSERT INTO `ym_places` VALUES ('387', 'نكا', '27');
INSERT INTO `ym_places` VALUES ('388', 'نور', '27');
INSERT INTO `ym_places` VALUES ('389', 'بلده', '27');
INSERT INTO `ym_places` VALUES ('390', 'نوشهر', '27');
INSERT INTO `ym_places` VALUES ('391', 'پل سفید', '27');
INSERT INTO `ym_places` VALUES ('392', 'محمود آباد', '27');
INSERT INTO `ym_places` VALUES ('393', 'فریدون كنار', '27');
INSERT INTO `ym_places` VALUES ('394', 'اراك', '28');
INSERT INTO `ym_places` VALUES ('395', 'آشتیان', '28');
INSERT INTO `ym_places` VALUES ('396', 'تفرش', '28');
INSERT INTO `ym_places` VALUES ('397', 'خمین', '28');
INSERT INTO `ym_places` VALUES ('398', 'دلیجان', '28');
INSERT INTO `ym_places` VALUES ('399', 'ساوه', '28');
INSERT INTO `ym_places` VALUES ('400', 'سربند', '28');
INSERT INTO `ym_places` VALUES ('401', 'محلات', '28');
INSERT INTO `ym_places` VALUES ('402', 'شازند', '28');
INSERT INTO `ym_places` VALUES ('403', 'بندرعباس', '29');
INSERT INTO `ym_places` VALUES ('404', 'قشم', '29');
INSERT INTO `ym_places` VALUES ('405', 'كیش', '29');
INSERT INTO `ym_places` VALUES ('406', 'بندر لنگه', '29');
INSERT INTO `ym_places` VALUES ('407', 'بستك', '29');
INSERT INTO `ym_places` VALUES ('408', 'حاجی آباد', '29');
INSERT INTO `ym_places` VALUES ('409', 'دهبارز', '29');
INSERT INTO `ym_places` VALUES ('410', 'انگهران', '29');
INSERT INTO `ym_places` VALUES ('411', 'میناب', '29');
INSERT INTO `ym_places` VALUES ('412', 'ابوموسی', '29');
INSERT INTO `ym_places` VALUES ('413', 'بندر جاسك', '29');
INSERT INTO `ym_places` VALUES ('414', 'تنب بزرگ', '29');
INSERT INTO `ym_places` VALUES ('415', 'بندر خمیر', '29');
INSERT INTO `ym_places` VALUES ('416', 'پارسیان', '29');
INSERT INTO `ym_places` VALUES ('417', 'قشم', '29');
INSERT INTO `ym_places` VALUES ('418', 'همدان', '30');
INSERT INTO `ym_places` VALUES ('419', 'ملایر', '30');
INSERT INTO `ym_places` VALUES ('420', 'تویسركان', '30');
INSERT INTO `ym_places` VALUES ('421', 'نهاوند', '30');
INSERT INTO `ym_places` VALUES ('422', 'كبودر اهنگ', '30');
INSERT INTO `ym_places` VALUES ('423', 'رزن', '30');
INSERT INTO `ym_places` VALUES ('424', 'اسدآباد', '30');
INSERT INTO `ym_places` VALUES ('425', 'بهار', '30');
INSERT INTO `ym_places` VALUES ('426', 'یزد', '31');
INSERT INTO `ym_places` VALUES ('427', 'تفت', '31');
INSERT INTO `ym_places` VALUES ('428', 'اردكان', '31');
INSERT INTO `ym_places` VALUES ('429', 'ابركوه', '31');
INSERT INTO `ym_places` VALUES ('430', 'میبد', '31');
INSERT INTO `ym_places` VALUES ('431', 'طبس', '31');
INSERT INTO `ym_places` VALUES ('432', 'بافق', '31');
INSERT INTO `ym_places` VALUES ('433', 'مهریز', '31');
INSERT INTO `ym_places` VALUES ('434', 'اشكذر', '31');
INSERT INTO `ym_places` VALUES ('435', 'هرات', '31');
INSERT INTO `ym_places` VALUES ('436', 'خضرآباد', '31');
INSERT INTO `ym_places` VALUES ('437', 'شاهدیه', '31');
INSERT INTO `ym_places` VALUES ('438', 'حمیدیه شهر', '31');
INSERT INTO `ym_places` VALUES ('439', 'سید میرزا', '31');
INSERT INTO `ym_places` VALUES ('440', 'زارچ', '31');
INSERT INTO `ym_places` VALUES ('441', 'دستجرد', '19');
INSERT INTO `ym_places` VALUES ('442', 'کهک', '19');
INSERT INTO `ym_places` VALUES ('443', 'خلجستان', '19');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'موسسه علمی فرهنگی پردیس آوای شهیر');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', ' آوای شهیر');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', '');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'موسسه پردیس آوای شهیر یک موسسه علمی-فرهنگی است که در سال 1394 تاسیس شده و که در زمینه های فرهنگی وهنری به طور عام و آموزش زبان انگلیسی به طور خاص فعالیت خود را آغاز کرده و تلاش میکند تا خدماتی نو و خلاقانه را که درخور مردم عزیز ایران است را ارايه کند.\r\n\r\nبه امید بهروزی شما\r\n \r\nمدیر موسسه آوای شهیر: امیر خادم المله\r\n');
INSERT INTO `ym_site_setting` VALUES ('5', 'message', 'پیام وبسایت', '');
INSERT INTO `ym_site_setting` VALUES ('6', 'message_en', 'پیام انگلیسی وبسایت', '');
INSERT INTO `ym_site_setting` VALUES ('7', 'message_state', 'وضعیت نمایش پیام', '1');

-- ----------------------------
-- Table structure for ym_teacher_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_teacher_details`;
CREATE TABLE `ym_teacher_details` (
  `user_id` int(10) unsigned NOT NULL,
  `avatar` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آواتار',
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `family` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی',
  `grade` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'سطح تحصیلات',
  `resume` text COLLATE utf8_persian_ci COMMENT 'روزمه',
  `social_links` varchar(2000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'لینک های اجتماعی',
  `tell` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شماره تماس',
  `address` text COLLATE utf8_persian_ci COMMENT 'آدرس',
  `file` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل رزومه',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ym_teacher_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_teacher_details
-- ----------------------------
INSERT INTO `ym_teacher_details` VALUES ('35', 'f4ypH1464409597.png', 'علی', 'غفاریان', 'کارشناسی ارشد زبان انگلیسی', '', '[{\"value\":\"http:\\/\\/facebook.com\\/ali\"},{\"value\":\"http:\\/\\/www.twitter.com\\/me\"}]', '09125383080', '', '3jpgJ1464409694.pdf');

-- ----------------------------
-- Table structure for ym_towns
-- ----------------------------
DROP TABLE IF EXISTS `ym_towns`;
CREATE TABLE `ym_towns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `name` varchar(100) NOT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='استان ها';

-- ----------------------------
-- Records of ym_towns
-- ----------------------------
INSERT INTO `ym_towns` VALUES ('1', 'آذربايجان شرقی');
INSERT INTO `ym_towns` VALUES ('2', 'آذربايجان غربی');
INSERT INTO `ym_towns` VALUES ('3', 'اردبيل');
INSERT INTO `ym_towns` VALUES ('4', 'اصفهان');
INSERT INTO `ym_towns` VALUES ('5', 'البرز');
INSERT INTO `ym_towns` VALUES ('6', 'ايلام');
INSERT INTO `ym_towns` VALUES ('7', 'بوشهر');
INSERT INTO `ym_towns` VALUES ('8', 'تهران');
INSERT INTO `ym_towns` VALUES ('9', 'چهارمحال بختياری');
INSERT INTO `ym_towns` VALUES ('10', 'خراسان جنوبی');
INSERT INTO `ym_towns` VALUES ('11', 'خراسان رضوی');
INSERT INTO `ym_towns` VALUES ('12', 'خراسان شمالی');
INSERT INTO `ym_towns` VALUES ('13', 'خوزستان');
INSERT INTO `ym_towns` VALUES ('14', 'زنجان');
INSERT INTO `ym_towns` VALUES ('15', 'سمنان');
INSERT INTO `ym_towns` VALUES ('16', 'سيستان و بلوچستان');
INSERT INTO `ym_towns` VALUES ('17', 'فارس');
INSERT INTO `ym_towns` VALUES ('18', 'قزوين');
INSERT INTO `ym_towns` VALUES ('19', 'قم');
INSERT INTO `ym_towns` VALUES ('20', 'كردستان');
INSERT INTO `ym_towns` VALUES ('21', 'كرمان');
INSERT INTO `ym_towns` VALUES ('22', 'كرمانشاه');
INSERT INTO `ym_towns` VALUES ('23', 'كهكيلويه و بويراحمد');
INSERT INTO `ym_towns` VALUES ('24', 'گلستان');
INSERT INTO `ym_towns` VALUES ('25', 'گيلان');
INSERT INTO `ym_towns` VALUES ('26', 'لرستان');
INSERT INTO `ym_towns` VALUES ('27', 'مازندران');
INSERT INTO `ym_towns` VALUES ('28', 'مركزی');
INSERT INTO `ym_towns` VALUES ('29', 'هرمزگان');
INSERT INTO `ym_towns` VALUES ('30', 'همدان');
INSERT INTO `ym_towns` VALUES ('31', 'يزد');

-- ----------------------------
-- Table structure for ym_translations
-- ----------------------------
DROP TABLE IF EXISTS `ym_translations`;
CREATE TABLE `ym_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `attribute` varchar(100) NOT NULL,
  `lang` varchar(6) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute` (`attribute`),
  KEY `table_name` (`table_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1763 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_translations
-- ----------------------------
INSERT INTO `ym_translations` VALUES ('59', 'ym_pages', '5', 'title', 'en', 'Terms and Privacy');
INSERT INTO `ym_translations` VALUES ('60', 'ym_pages', '5', 'summary', 'en', '<p dir=\"ltr\" style=\"text-align: justify;\">Terms and Policies of Avaye Shahir Institute:</p>\r\n\r\n<ol>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Observing Islamic principles &ndash; such as Islamic hijab &ndash; as we as the rules set by Avaye Shahir Institute is mandatory.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Observing netiquette (Net etiquette) on the cyber space whether on our site or on our Telegram channel is obligatory.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">No one - including the teachers, employees, and the clients - is supposed to talk politics in the Institute or on the cyber space provided by the Institute.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Under no circumstances is the tuition fee refunded.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Having enrollment bill is necessary for your first presence in the class.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">It is not possible to change the time and the day of the classes unless the teacher and the institute agree to do so and all other classmates agree with it in writing.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Using mobile phones throughout the time of the class is prohibited.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Before enrolling for a course, read the announcements carefully and then enroll.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Please follow the announcements and the news sent to you by means of the site or Telegram channel.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Avaye Shahir Institute never asks you to provide your personal information on the phone or through text messages. Please inform the management if such a case happens.</li>\r\n	<li dir=\"ltr\" style=\"text-align: justify;\">Please inform the management about any irregularities in the class or in the Institute.</li>\r\n</ol>\r\n');
INSERT INTO `ym_translations` VALUES ('61', 'ym_pages', '3', 'title', 'en', 'Contact Us');
INSERT INTO `ym_translations` VALUES ('62', 'ym_pages', '3', 'summary', 'en', '<p>asdg</p>\r\n');
INSERT INTO `ym_translations` VALUES ('63', 'ym_pages', '2', 'title', 'en', 'About Us');
INSERT INTO `ym_translations` VALUES ('64', 'ym_pages', '2', 'summary', 'en', '<p dir=\"ltr\" style=\"text-align:justify\">Avaye Shahir Cultural &amp; Educational Institute was established in 1394 and&nbsp;is active in such fields as arts, science, and&nbsp;culture in general and different languages in particular. Avaye Shahir tries to offer some&nbsp;innovative and new&nbsp;services that our dear people deserve.</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Wish you all the best</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Manager of Avaye Shahir Institute: Amir Khademolmelleh</p>\r\n');
INSERT INTO `ym_translations` VALUES ('65', 'ym_pages', '12', 'title', 'en', 'About Us - index page');
INSERT INTO `ym_translations` VALUES ('66', 'ym_pages', '12', 'summary', 'en', '<p dir=\"ltr\">Avaye Shahir Cultural &amp; Educational Institute was established in 1394 and is active in such fields as arts, science, and culture in general and different languages in particular. Avaye Shahir tries to offer some innovative and new services that our dear people deserve.<br />\r\nWish you all the best<br />\r\nManager of Avaye Shahir Institute: Amir Khademolmelleh</p>\r\n');
INSERT INTO `ym_translations` VALUES ('71', '{{class_categories}}', '20', 'title', 'en', 'Reading');
INSERT INTO `ym_translations` VALUES ('72', '{{class_categories}}', '20', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('73', '{{class_categories}}', '21', 'title', 'en', 'Speaking');
INSERT INTO `ym_translations` VALUES ('74', '{{class_categories}}', '21', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('75', '{{class_category_files}}', '11', 'title', 'en', 'The most Recent Speaking Questions Offered in TOEFL');
INSERT INTO `ym_translations` VALUES ('76', '{{class_categories}}', '22', 'title', 'en', 'Writing');
INSERT INTO `ym_translations` VALUES ('77', '{{class_categories}}', '22', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('89', '{{class_categories}}', '23', 'title', 'en', 'Listening');
INSERT INTO `ym_translations` VALUES ('90', '{{class_categories}}', '23', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('105', '{{teacher_details}}', '32', 'name', 'en', 'Alireza');
INSERT INTO `ym_translations` VALUES ('106', '{{teacher_details}}', '32', 'family', 'en', 'Ghaffarian');
INSERT INTO `ym_translations` VALUES ('107', '{{teacher_details}}', '32', 'grade', 'en', 'M.A. in Translation Studies');
INSERT INTO `ym_translations` VALUES ('108', '{{teacher_details}}', '32', 'resume', 'en', '');
INSERT INTO `ym_translations` VALUES ('109', '{{teacher_details}}', '32', 'address', 'en', '');
INSERT INTO `ym_translations` VALUES ('122', '{{class_category_files}}', '32', 'title', 'en', 'Vocabularies Used in Campus Conversations');
INSERT INTO `ym_translations` VALUES ('124', '{{class_category_files}}', '34', 'title', 'en', 'Some Good Ideas for Speaking and Writing');
INSERT INTO `ym_translations` VALUES ('125', '{{class_category_files}}', '35', 'title', 'en', 'How Your Writing Is Scored');
INSERT INTO `ym_translations` VALUES ('131', '{{class_category_files}}', '39', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('132', '{{class_category_files}}', '39', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('143', '{{teacher_details}}', '33', 'name', 'en', 'Amir');
INSERT INTO `ym_translations` VALUES ('144', '{{teacher_details}}', '33', 'family', 'en', 'Khademolmelleh');
INSERT INTO `ym_translations` VALUES ('145', '{{teacher_details}}', '33', 'grade', 'en', 'M.A. in Translation Studies');
INSERT INTO `ym_translations` VALUES ('146', '{{teacher_details}}', '33', 'resume', 'en', '<p dir=\"ltr\" style=\"text-align:justify\">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amir Khademolmelleh</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Date of birth:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jan. 6<sup>th</sup>, 1970</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Nationality:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Iranian</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Profession:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;University Instructor and Freelance Translator</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Marital Status:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Married</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Language:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Persian, English</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Address: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No. 3, Zanbagh 12<sup>th</sup> Street, Razakan, Karaj</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Telephone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0912-2341201</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"mailto:khadem@sharif.edu\">khadem@sharif.edu</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href=\"mailto:khadem8234@yahoo.com\">khadem8234@yahoo.com</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href=\"mailto:amir8234@yahoo.com\">amir8234@yahoo.com</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"mailto:amirkhadem8234@gmail.com\">amirkhadem8234@gmail.com</a></p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Education:</strong></p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">2004 &ndash; 2007&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allameh Tabataba&#39;i University</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M.A.Translation Studies</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1995 &ndash; 1999&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; University of Kashan</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Kashan, Isfahan, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B.A English &lt;&gt; Farsi / Persian Translation</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1994 &ndash; 1997&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Shahid Rajaee University</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Associate Diploma in Auto mechanics</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1989 &ndash; 1994&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Motahari Technical School</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Diploma in Auto mechanics</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Job Experiences:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Manager of Pardise Avaye Shahir Institute</li>\r\n	<li style=\"text-align:justify\">Holding 4 Workshops on Writing Research Papers: Sharif University of Technology</li>\r\n	<li style=\"text-align:justify\">Experience of teaching General English, TOEFL iBT, PhD TOEFL, and PBT TOEFL for 9 years at Sharif University of Technology</li>\r\n	<li style=\"text-align:justify\">Experience of teaching TOEFL iBT for 4 years at Amirkabir University</li>\r\n	<li style=\"text-align:justify\">Experience of teaching PhD TOEFL at Tehran University</li>\r\n	<li style=\"text-align:justify\">Experience of teaching Translation at Elmi-Karbordi University for 5 years</li>\r\n	<li style=\"text-align:justify\">Experience of teaching TOEFL, IELTS, and Conversation at Academic Center for Education, Culture, and Research, Allameh Tabatabaei, for 5 years</li>\r\n	<li style=\"text-align:justify\">Experience of teaching English at such English institutes as Sokhan, Shokooh, and Peyman at different levels ranging from basic to advanced courses for 5 years</li>\r\n	<li style=\"text-align:justify\">Translation of articles for such magazines as Cinema and Farabi</li>\r\n	<li style=\"text-align:justify\">Interpreter of Professor Eghbal in a seminar held in Soureh Pictures Company</li>\r\n	<li style=\"text-align:justify\">Translator trainer in Academic Center for Education, Culture, and Research, Allameh Tabatabaei for 5 years</li>\r\n	<li style=\"text-align:justify\">Edition of articles for ISI Journals for 12 years</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Summary of Qualifications:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Proficiency in computer skills and Microsoft Word</li>\r\n	<li style=\"text-align:justify\">Skillful in internet-related activities: search engines, emails, and websites, to name but a few</li>\r\n	<li style=\"text-align:justify\">Ability to work effectively as part of a team within the Education Service</li>\r\n	<li style=\"text-align:justify\">Able to work under pressure and remain calm in stressful situations</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Publications:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2011), TOEFL Writing Success: Integrated and Independent. Tehran: Nask Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2012), TOEFL Writing Success 2<sup>nd</sup> Edition. Tehran: Nask Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2013), TOEFL Writing Success 3<sup>rd</sup> Edition. Tehran: Jangal Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2015), TOEFL Writing Success 4<sup>th</sup> Edition. Tehran: Jangal Publications.</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Compiled Pamphlets:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Pamphlet for Translation English &lt;&gt; Farsi / Persian</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL iBT Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL PBT</li>\r\n	<li style=\"text-align:justify\">Pamphlet for Phd TOEFL</li>\r\n	<li style=\"text-align:justify\">Pamphlet for General IELTS Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for Academic IELTS Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL Reading</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Hobbies:</strong></p>\r\n\r\n<ul>\r\n	<li dir=\"ltr\" style=\"text-align:justify\">Sports: Soccer, chess, table tennis, swimming</li>\r\n	<li dir=\"ltr\" style=\"text-align:justify\">Leisure: Reading novels, listening to music, watching movies</li>\r\n</ul>\r\n');
INSERT INTO `ym_translations` VALUES ('147', '{{teacher_details}}', '33', 'address', 'en', '');
INSERT INTO `ym_translations` VALUES ('154', '{{class_category_files}}', '43', 'title', 'en', 'Reading Score from 0 to 30 Based on the Questions Answered');
INSERT INTO `ym_translations` VALUES ('155', '{{class_category_files}}', '43', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('162', '{{class_category_files}}', '46', 'title', 'en', 'Reading Vocab Word');
INSERT INTO `ym_translations` VALUES ('163', '{{class_category_files}}', '46', 'summary', 'en', 'These words are extracted by one of the test takers, which can be of help for others, although there exist some minor errors in it. In the near future, a much better file will be uploaded.');
INSERT INTO `ym_translations` VALUES ('164', '{{class_category_files}}', '47', 'title', 'en', 'Essential English Idioms: Elementary, Intermediate, and Advanced');
INSERT INTO `ym_translations` VALUES ('165', '{{class_category_files}}', '47', 'summary', 'en', 'This book is a great source for those who want to improve their Listening, Speaking, and Writing abilities.');
INSERT INTO `ym_translations` VALUES ('176', '{{courses}}', '13', 'title', 'en', 'TOEFL iBT');
INSERT INTO `ym_translations` VALUES ('177', '{{courses}}', '13', 'summary', 'en', '<p dir=\"ltr\">The TOEFL iBT course will be held under my supervision with a different approach from other institutes.</p>\r\n\r\n<p dir=\"ltr\">Amir Khadem: Manager of Avaye Shahir Institute</p>\r\n');
INSERT INTO `ym_translations` VALUES ('189', '{{teacher_details}}', '34', 'name', 'en', 'Hamid');
INSERT INTO `ym_translations` VALUES ('190', '{{teacher_details}}', '34', 'family', 'en', 'Shahiri');
INSERT INTO `ym_translations` VALUES ('191', '{{teacher_details}}', '34', 'grade', 'en', 'M.A. in Dramatic Literature');
INSERT INTO `ym_translations` VALUES ('192', '{{teacher_details}}', '34', 'resume', 'en', '<p dir=\"ltr\" style=\"text-align:justify\">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amir Khademolmelleh</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Date of birth:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jan. 6<sup>th</sup>, 1970</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Nationality:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Iranian</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Profession:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;University Instructor and Freelance Translator</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Marital Status:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Married</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Language:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Persian, English</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Address: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No. 3, Zanbagh 12<sup>th</sup> Street, Razakan, Karaj</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Telephone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0912-2341201</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"mailto:khadem@sharif.edu\">khadem@sharif.edu</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href=\"mailto:khadem8234@yahoo.com\">khadem8234@yahoo.com</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href=\"mailto:amir8234@yahoo.com\">amir8234@yahoo.com</a>;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"mailto:amirkhadem8234@gmail.com\">amirkhadem8234@gmail.com</a></p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Education:</strong></p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">2004 &ndash; 2007&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allameh Tabataba&#39;i University</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M.A.Translation Studies</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1995 &ndash; 1999&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; University of Kashan</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Kashan, Isfahan, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B.A English &lt;&gt; Farsi / Persian Translation</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1994 &ndash; 1997&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Shahid Rajaee University</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Associate Diploma in Auto mechanics</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">1989 &ndash; 1994&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Motahari Technical School</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[Tehran, Iran]</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Diploma in Auto mechanics</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Job Experiences:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Manager of Pardise Avaye Shahir Institute</li>\r\n	<li style=\"text-align:justify\">Holding 4 Workshops on Writing Research Papers: Sharif University of Technology</li>\r\n	<li style=\"text-align:justify\">Experience of teaching General English, TOEFL iBT, PhD TOEFL, and PBT TOEFL for 9 years at Sharif University of Technology</li>\r\n	<li style=\"text-align:justify\">Experience of teaching TOEFL iBT for 4 years at Amirkabir University</li>\r\n	<li style=\"text-align:justify\">Experience of teaching PhD TOEFL at Tehran University</li>\r\n	<li style=\"text-align:justify\">Experience of teaching Translation at Elmi-Karbordi University for 5 years</li>\r\n	<li style=\"text-align:justify\">Experience of teaching TOEFL, IELTS, and Conversation at Academic Center for Education, Culture, and Research, Allameh Tabatabaei, for 5 years</li>\r\n	<li style=\"text-align:justify\">Experience of teaching English at such English institutes as Sokhan, Shokooh, and Peyman at different levels ranging from basic to advanced courses for 5 years</li>\r\n	<li style=\"text-align:justify\">Translation of articles for such magazines as Cinema and Farabi</li>\r\n	<li style=\"text-align:justify\">Interpreter of Professor Eghbal in a seminar held in Soureh Pictures Company</li>\r\n	<li style=\"text-align:justify\">Translator trainer in Academic Center for Education, Culture, and Research, Allameh Tabatabaei for 5 years</li>\r\n	<li style=\"text-align:justify\">Edition of articles for ISI Journals for 12 years</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Summary of Qualifications:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Proficiency in computer skills and Microsoft Word</li>\r\n	<li style=\"text-align:justify\">Skillful in internet-related activities: search engines, emails, and websites, to name but a few</li>\r\n	<li style=\"text-align:justify\">Ability to work effectively as part of a team within the Education Service</li>\r\n	<li style=\"text-align:justify\">Able to work under pressure and remain calm in stressful situations</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Publications:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2011), TOEFL Writing Success: Integrated and Independent. Tehran: Nask Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2012), TOEFL Writing Success 2<sup>nd</sup> Edition. Tehran: Nask Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2013), TOEFL Writing Success 3<sup>rd</sup> Edition. Tehran: Jangal Publications.</li>\r\n	<li style=\"text-align:justify\">Khademolmelle, A. (2015), TOEFL Writing Success 4<sup>th</sup> Edition. Tehran: Jangal Publications.</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Compiled Pamphlets:</strong></p>\r\n\r\n<ul dir=\"ltr\">\r\n	<li style=\"text-align:justify\">Pamphlet for Translation English &lt;&gt; Farsi / Persian</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL iBT Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL PBT</li>\r\n	<li style=\"text-align:justify\">Pamphlet for Phd TOEFL</li>\r\n	<li style=\"text-align:justify\">Pamphlet for General IELTS Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for Academic IELTS Writing</li>\r\n	<li style=\"text-align:justify\">Pamphlet for TOEFL Reading</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\"><strong>Hobbies:</strong></p>\r\n\r\n<ul>\r\n	<li dir=\"ltr\" style=\"text-align:justify\">Sports: Soccer, chess, table tennis, swimming</li>\r\n	<li dir=\"ltr\" style=\"text-align:justify\">Leisure: Reading novels, listening to music, watching movies</li>\r\n</ul>\r\n');
INSERT INTO `ym_translations` VALUES ('193', '{{teacher_details}}', '34', 'address', 'en', '');
INSERT INTO `ym_translations` VALUES ('200', '{{courses}}', '17', 'title', 'en', 'GMAT');
INSERT INTO `ym_translations` VALUES ('201', '{{courses}}', '17', 'summary', 'en', '<p dir=\"ltr\">These sourses are some of the best ones available to test takers, which I hope are of help for you.</p>\r\n\r\n<p dir=\"ltr\">Amir Khadem</p>\r\n');
INSERT INTO `ym_translations` VALUES ('206', '{{courses}}', '18', 'title', 'en', 'PhD TOEFL');
INSERT INTO `ym_translations` VALUES ('207', '{{courses}}', '18', 'summary', 'en', '<p dir=\"ltr\">The exam PhD TOEFL, which is commonly held in Iran for PhD students, is the very PBT TOEFL&nbsp;(Paper-based TOEFL) with no writing section. Thus, studying these sourses will help you get a high score in this exam.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('210', '{{class_categories}}', '30', 'title', 'en', 'TOEFL Vocabulary Sources');
INSERT INTO `ym_translations` VALUES ('211', '{{class_categories}}', '30', 'summary', 'en', '<p dir=\"ltr\">In order for you to study the vocabulary sources in order, please refer to &quot;TOEFL iBT Syllabus for All Skills&quot;.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('238', '{{class_category_file_links}}', '22', 'title', 'en', 'Speaking Questions 1 & 2');
INSERT INTO `ym_translations` VALUES ('239', '{{class_category_file_links}}', '22', 'summary', 'en', 'This video from the ETS site provides you with a general understanding of the Speaking Tasks 1 & 2. Nevertheless, it is better for you to read quite a few speaking samples and practice a great deal through the books we have introduced in the site.');
INSERT INTO `ym_translations` VALUES ('240', '{{class_category_file_links}}', '23', 'title', 'en', 'Speaking Questions 3 & 5');
INSERT INTO `ym_translations` VALUES ('241', '{{class_category_file_links}}', '23', 'summary', 'en', 'This video from the ETS Site provides you with a general understanding of the Speaking Tasks 3 & 5. Nonetheless, you\'d better read quite a few speaking samples and practice a great deal through the books we have introduced in this very site.');
INSERT INTO `ym_translations` VALUES ('242', '{{class_category_file_links}}', '24', 'title', 'en', 'Speaking Questions Task 4 & 6');
INSERT INTO `ym_translations` VALUES ('243', '{{class_category_file_links}}', '24', 'summary', 'en', 'This video from the ETS Site provides you with a general understanding of the Speaking Tasks 4 & 6. Still, you\'d better read quite a few speaking samples and practice a great deal through the books we have introduced in this very site.');
INSERT INTO `ym_translations` VALUES ('246', '{{courses}}', '16', 'title', 'en', 'GRE ');
INSERT INTO `ym_translations` VALUES ('247', '{{courses}}', '16', 'summary', 'en', '<p dir=\"ltr\">There are many references for different modules of GRE, but the ones introduced here are good enough for a decent score.&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Good Luck&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Amir Khadem: Manager of Avaye Shahir Institute.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('254', '{{class_category_file_links}}', '27', 'title', 'en', 'Building Speaking for Beginners');
INSERT INTO `ym_translations` VALUES ('255', '{{class_category_file_links}}', '27', 'summary', 'en', 'This book and the other two books of this series are great sources for the Speaking Skill of TOEFL iBT.');
INSERT INTO `ym_translations` VALUES ('258', '{{classes}}', '1', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('259', '{{classes}}', '1', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('260', '{{class_category_file_links}}', '29', 'title', 'en', 'Mastering Speaking for TOEFL iBT');
INSERT INTO `ym_translations` VALUES ('261', '{{class_category_file_links}}', '29', 'summary', 'en', 'This book and the previous two books of this series are great sources for the Speaking Skill of TOEFL iBT.');
INSERT INTO `ym_translations` VALUES ('262', '{{class_category_file_links}}', '28', 'title', 'en', 'Developing Speaking for the Intermediate Level');
INSERT INTO `ym_translations` VALUES ('263', '{{class_category_file_links}}', '28', 'summary', 'en', 'This book and the other two books of this series are great sources for the Speaking Skill of TOEFL iBT.');
INSERT INTO `ym_translations` VALUES ('340', '{{class_category_file_links}}', '34', 'title', 'en', '4000 Essential English Words Book 2');
INSERT INTO `ym_translations` VALUES ('341', '{{class_category_file_links}}', '34', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('342', '{{class_category_file_links}}', '35', 'title', 'en', '4000 Essential English Words Book 3');
INSERT INTO `ym_translations` VALUES ('343', '{{class_category_file_links}}', '35', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('344', '{{class_category_file_links}}', '36', 'title', 'en', '4000 Essential English Words Book 4');
INSERT INTO `ym_translations` VALUES ('345', '{{class_category_file_links}}', '36', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('346', '{{class_category_file_links}}', '37', 'title', 'en', '4000 Essential English Words Book 5');
INSERT INTO `ym_translations` VALUES ('347', '{{class_category_file_links}}', '37', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('348', '{{class_category_file_links}}', '38', 'title', 'en', '4000 Essential English Words Book 6');
INSERT INTO `ym_translations` VALUES ('352', '{{class_category_file_links}}', '39', 'title', 'en', 'DELTA\'s Key to the Next Generation TOEFL Test (PDF)');
INSERT INTO `ym_translations` VALUES ('353', '{{class_category_file_links}}', '39', 'summary', 'en', 'This book is a great source for you to acquire Reading and Listening Skills for TOEFL iBT. However, it is not enough whatsoever. You should also study other sources, which are mentioned in “TOEFL iBT Syllabus for All Skills” to master these skills.');
INSERT INTO `ym_translations` VALUES ('373', '{{class_category_file_links}}', '32', 'title', 'en', '4000 Essential English Words Book 1');
INSERT INTO `ym_translations` VALUES ('374', '{{class_category_file_links}}', '32', 'summary', 'en', 'This book which is from a 6-volume series is an invaluable source for learning vocabulary. All the words, their definition, and the examples are all read by an American native speaker, which lets you learn the words professionally. It has a story at the end of each chapter in which all the new words are used. ');
INSERT INTO `ym_translations` VALUES ('401', '{{teacher_details}}', '41', 'name', 'en', 'Hossein');
INSERT INTO `ym_translations` VALUES ('402', '{{teacher_details}}', '41', 'family', 'en', 'Khezerlou');
INSERT INTO `ym_translations` VALUES ('403', '{{teacher_details}}', '41', 'grade', 'en', 'M.A. in Applied Linguistics (TEFL)');
INSERT INTO `ym_translations` VALUES ('404', '{{teacher_details}}', '41', 'resume', 'en', '');
INSERT INTO `ym_translations` VALUES ('405', '{{teacher_details}}', '41', 'address', 'en', '');
INSERT INTO `ym_translations` VALUES ('414', '{{class_category_file_links}}', '45', 'title', 'en', '10- A GRE Argument Task Example (MP4)');
INSERT INTO `ym_translations` VALUES ('415', '{{class_category_file_links}}', '45', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('428', '{{class_category_file_links}}', '50', 'title', 'en', '7- An Introduction to the Argumnet Task (MP4)');
INSERT INTO `ym_translations` VALUES ('429', '{{class_category_file_links}}', '50', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('430', '{{class_category_file_links}}', '51', 'title', 'en', '8- GRE Logical Fallacies (MP4)');
INSERT INTO `ym_translations` VALUES ('431', '{{class_category_file_links}}', '51', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('432', '{{class_category_file_links}}', '52', 'title', 'en', '9- GRE Argument Task Brainstorming (MP4)');
INSERT INTO `ym_translations` VALUES ('433', '{{class_category_file_links}}', '52', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('440', '{{class_category_file_links}}', '54', 'title', 'en', 'GRE Argument Topics');
INSERT INTO `ym_translations` VALUES ('441', '{{class_category_file_links}}', '54', 'summary', 'en', 'This PDF file contains all the GRE Argument Topics, which should be studied before the GRE exam.');
INSERT INTO `ym_translations` VALUES ('442', '{{class_category_file_links}}', '55', 'title', 'en', 'GRE Issue Topics');
INSERT INTO `ym_translations` VALUES ('443', '{{class_category_file_links}}', '55', 'summary', 'en', 'This PDF file contains all the GRE Issue Topics, which should be studied before the GRE exam.');
INSERT INTO `ym_translations` VALUES ('519', '{{class_category_files}}', '11', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('548', '{{class_category_files}}', '32', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('550', '{{class_category_files}}', '34', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('552', '{{class_category_files}}', '35', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('944', '{{class_category_file_links}}', '56', 'title', 'en', 'Essential Words for the TOEFL');
INSERT INTO `ym_translations` VALUES ('945', '{{class_category_file_links}}', '56', 'summary', 'en', 'This book is only suitable for the PhD TOEFL that is held in Iran. However, for the TOEFL iBT, it is better for you to study the other books introduced in this site.');
INSERT INTO `ym_translations` VALUES ('1067', '{{class_category_file_links}}', '38', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1070', '{{class_categories}}', '24', 'title', 'en', 'About the TOEFL iBT Courses in Avaye Shahir');
INSERT INTO `ym_translations` VALUES ('1071', '{{class_categories}}', '24', 'summary', 'en', '<p dir=\"ltr\" style=\"text-align:justify\">The TOEFL iBT courses to be held in Avaye Shahir are quite different from those held in Sharif University of Technology. First, for these courses, some discount will be offered to university students, a part of which will be through Netbarg site and its mobile application, making the enrolment ideal for them. Second, unlike other institutes, two writing samples of each student in any course will be edited by the instructors, which has a great influence on their Writing TOEFL score. Third, at the end of any course, at the request of the students, a workshop will be held in which students&rsquo; writing samples will be discussed in detail, and final key points will be elaborated upon in the workshop. Through holding such courses, I hope we are able to make a small but positive contribution to society in general and our dear students in particular.</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Wish you all the best</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Manager of Avaye Shahir Institute: Amir Khadem</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1074', '{{class_categories}}', '26', 'title', 'en', 'Some Points about the TOEFL iBT Test');
INSERT INTO `ym_translations` VALUES ('1075', '{{class_categories}}', '26', 'summary', 'en', '<p dir=\"ltr\">Knowing these points is essential for all TOEFL iBT test takers.&nbsp;</p>\n');
INSERT INTO `ym_translations` VALUES ('1100', '{{class_category_file_links}}', '25', 'title', 'en', 'Familiarity with the Test Center Procedures');
INSERT INTO `ym_translations` VALUES ('1101', '{{class_category_file_links}}', '25', 'summary', 'en', 'This video from the ETS Site provides you with a general understanding of the Test Center Procedures, which is  quite useful for the test takers.');
INSERT INTO `ym_translations` VALUES ('1102', '{{class_category_file_links}}', '26', 'title', 'en', 'Why TOEFL iBT?');
INSERT INTO `ym_translations` VALUES ('1103', '{{class_category_file_links}}', '26', 'summary', 'en', 'This video from the ETS Site shows which countries accept TOEFL iBT.');
INSERT INTO `ym_translations` VALUES ('1400', '{{class_category_files}}', '22', 'title', 'en', 'How to Install Babylon');
INSERT INTO `ym_translations` VALUES ('1401', '{{class_category_files}}', '22', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1404', '{{class_category_files}}', '37', 'title', 'en', 'Pre-TOEFL Writing Pamphlet Compiled by Amir Khadem PDF');
INSERT INTO `ym_translations` VALUES ('1405', '{{class_category_files}}', '37', 'summary', 'en', 'This pamphlet and the other one \"TOEFL Writing Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass TOEFL, PhD TOEFL, IELTS, GRE, and GMAT. I hope you the next ones. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1406', '{{class_category_files}}', '38', 'title', 'en', 'TOEFL Writing Pamphlet Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1407', '{{class_category_files}}', '38', 'summary', 'en', 'This pamphlet and the other one \"Pre-TOEFL Writing Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass TOEFL, PhD TOEFL, IELTS, GRE, and GMAT. I hope you the next ones. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1410', '{{class_category_files}}', '50', 'title', 'en', 'The Most Beautiful Quotes of All Time');
INSERT INTO `ym_translations` VALUES ('1411', '{{class_category_files}}', '50', 'summary', 'en', 'Reading these proverbs provides you with creative ideas and guarantees your success in almost all English proficiency exams.');
INSERT INTO `ym_translations` VALUES ('1412', '{{class_category_files}}', '51', 'title', 'en', 'English Proverbs and their Translation in Persian');
INSERT INTO `ym_translations` VALUES ('1413', '{{class_category_files}}', '51', 'summary', 'en', 'Reading these proverbs is really enjoyable and improves your writing dramatically.');
INSERT INTO `ym_translations` VALUES ('1414', '{{class_category_files}}', '20', 'title', 'en', 'Babylon Setup');
INSERT INTO `ym_translations` VALUES ('1415', '{{class_category_files}}', '20', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1416', '{{class_category_files}}', '21', 'title', 'en', 'Babylon Crack');
INSERT INTO `ym_translations` VALUES ('1417', '{{class_category_files}}', '21', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1418', '{{class_category_files}}', '17', 'title', 'en', '29 Categories of Writing Topics');
INSERT INTO `ym_translations` VALUES ('1419', '{{class_category_files}}', '17', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1422', '{{class_categories}}', '27', 'title', 'en', 'TOEFL Course Syllabus Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1423', '{{class_categories}}', '27', 'summary', 'en', '<p dir=\"ltr\">Please follow this syllabus based on your level. You&nbsp;are not supposed to cover&nbsp;all the items.</p>\n');
INSERT INTO `ym_translations` VALUES ('1424', '{{class_category_files}}', '49', 'title', 'en', 'TOEFL Course Syllabus Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1425', '{{class_category_files}}', '49', 'summary', 'en', 'In this file, which is the essence of my experience from years of teaching in such universities as Sharif University of Technology and Amirkabir Polytechnique University, etc, I have elaborated on - explained in detail - the syllabus I have prepared for TOEFL iBT Test. If you carefully follow this syllabus, you will ace the TOEFL Test as many of my students, regardless of their levels, have done so far and received brilliant scores in the test. I hope you are the next one to get a high score.\r\nWish you luck.\r\nAmir Khadem');
INSERT INTO `ym_translations` VALUES ('1426', '{{class_category_files}}', '44', 'title', 'en', 'How to Receive the Free TOEFL iBT Test from ETS Site?');
INSERT INTO `ym_translations` VALUES ('1427', '{{class_category_files}}', '44', 'summary', 'en', 'Those who have enrolled in the TOEFL iBT Test receive the free TOEFL iBT test from ETS site');
INSERT INTO `ym_translations` VALUES ('1428', '{{class_category_files}}', '45', 'title', 'en', 'A Sample TOEFL iBT Report Card');
INSERT INTO `ym_translations` VALUES ('1429', '{{class_category_files}}', '45', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1430', '{{class_category_files}}', '19', 'title', 'en', 'How Your Writing Is Scored');
INSERT INTO `ym_translations` VALUES ('1431', '{{class_category_files}}', '19', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1434', '{{class_category_files}}', '36', 'title', 'en', 'Parts of the Book TOEFL Writing Success Written by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1435', '{{class_category_files}}', '36', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1436', '{{class_category_files}}', '12', 'title', 'en', 'Glossary for the Book TOEFL Writing Success 4th Edition by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1437', '{{class_category_files}}', '12', 'summary', 'en', 'Since the words used in the book TOEFL Writing Success 4th Edition are difficult but practical, it is strongly recommended that you use the glossary of the book for better understanding and correct usage of these words and phrases. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1438', '{{class_category_files}}', '14', 'title', 'en', 'Categorized Proverbs and Quotations');
INSERT INTO `ym_translations` VALUES ('1439', '{{class_category_files}}', '14', 'summary', 'en', 'Reading these proverbs is really enjoyable and improves your writing dramatically.');
INSERT INTO `ym_translations` VALUES ('1440', '{{class_category_files}}', '31', 'title', 'en', 'TOEFL WRITING SUCCESS  4th Edition by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1441', '{{class_category_files}}', '31', 'summary', 'en', 'TOEFL Writing Success 4th Edition is a book that provides proven techniques for a higher score in such tests as TOEFL, IELTS, GRE, and GMAT. The book contains 165 writing samples of my top students, corrected by the author, together with 4 writing samples by the author, all of which, I think, are of great help to IELTS, GMAT, and GRE test takers in general and TOEFL test takers in particular. It also contains punctuation and common errors of Iranian test takers, which are of great help to those who want to take part in the aforementioned tests. There are many new Integrated samples and exercises which are great to improve students\' abilities for TOEFL. This book has ample exercises on paraphrasing, note taking, and synthesizing, to name but a handful. It is worth mentioning that the book is particularly suitable for upper intermediate and advanced levels. \r\nAmir Khadem');
INSERT INTO `ym_translations` VALUES ('1442', '{{class_category_files}}', '16', 'title', 'en', 'The Most Recent Topics Offered in TOEFL iBT');
INSERT INTO `ym_translations` VALUES ('1443', '{{class_category_files}}', '16', 'summary', 'en', 'The book TOEFL Writing Success 4th Edition aimed at covering many new topics with great samples. Nevertheless, the topics in this file are quite new, so studying them is very necessary.');
INSERT INTO `ym_translations` VALUES ('1454', '{{class_category_file_links}}', '31', 'title', 'en', 'Rapid Typing Software');
INSERT INTO `ym_translations` VALUES ('1455', '{{class_category_file_links}}', '31', 'summary', 'en', 'This software, in a short period of time, helps you learn how to type fast.');
INSERT INTO `ym_translations` VALUES ('1456', '{{class_category_file_links}}', '21', 'title', 'en', 'ETS Video about Independent Writing Task');
INSERT INTO `ym_translations` VALUES ('1457', '{{class_category_file_links}}', '21', 'summary', 'en', 'This video is offered by ETS about Writing Task 2 (Independent), which familiarize you with this task. However, in order to master the task, read professional samples in the book TOEFL Writing Success.');
INSERT INTO `ym_translations` VALUES ('1458', '{{class_category_file_links}}', '20', 'title', 'en', 'ETS Video about Integrated Writing Task');
INSERT INTO `ym_translations` VALUES ('1459', '{{class_category_file_links}}', '20', 'summary', 'en', 'This is a video offered by ETS about Writing Task 1 (Integrated), which is good enough for being familiar with this task. However, in order to master the task, read professional samples in the book TOEFL Writing Success 4th Edition.');
INSERT INTO `ym_translations` VALUES ('1460', '{{class_category_file_links}}', '41', 'title', 'en', 'Audio Files of the Book TOEFL Writing Success 4th by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1461', '{{class_category_file_links}}', '41', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1510', '{{class_category_files}}', '42', 'title', 'en', 'Listening Scores from 0 to 30  Based on the Correct Responses');
INSERT INTO `ym_translations` VALUES ('1511', '{{class_category_files}}', '42', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1512', '{{class_category_files}}', '40', 'title', 'en', 'About the Listening Tracks Repeated in TOEFL');
INSERT INTO `ym_translations` VALUES ('1513', '{{class_category_files}}', '40', 'summary', 'en', 'The listening tracks that will follow are almost always repeated in TOEFL iBT Listening Module and has some score. Please do not listen to others if they say it carries no score in the test. Wish you all success. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1514', '{{class_category_files}}', '41', 'title', 'en', 'The Loss of a Student\'s ID Card Complete');
INSERT INTO `ym_translations` VALUES ('1515', '{{class_category_files}}', '41', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1516', '{{class_category_files}}', '27', 'title', 'en', 'Glial Cell Complete');
INSERT INTO `ym_translations` VALUES ('1517', '{{class_category_files}}', '27', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1518', '{{class_category_files}}', '26', 'title', 'en', 'Bird Migration Complete');
INSERT INTO `ym_translations` VALUES ('1519', '{{class_category_files}}', '26', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1520', '{{class_category_files}}', '30', 'title', 'en', 'William Wordsworth ');
INSERT INTO `ym_translations` VALUES ('1521', '{{class_category_files}}', '30', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1522', '{{class_category_files}}', '29', 'title', 'en', 'Ragtime Music');
INSERT INTO `ym_translations` VALUES ('1523', '{{class_category_files}}', '29', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1524', '{{class_category_files}}', '28', 'title', 'en', 'Rafflesia');
INSERT INTO `ym_translations` VALUES ('1525', '{{class_category_files}}', '28', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1526', '{{class_category_file_links}}', '40', 'title', 'en', 'DELTA\'s Key to the Next Generation TOEFL Test (PDF)');
INSERT INTO `ym_translations` VALUES ('1527', '{{class_category_file_links}}', '40', 'summary', 'en', 'This book is a great source for you to acquire Reading and Listening Skills for TOEFL iBT. However, it is not enough whatsoever. You should also study other sources, which are mentioned in “TOEFL iBT Syllabus for All Skills” to master these skills.');
INSERT INTO `ym_translations` VALUES ('1528', '{{class_category_file_links}}', '42', 'title', 'en', 'DELTA\'s Key to the Next Generation TOEFL Test (Audio Files)');
INSERT INTO `ym_translations` VALUES ('1529', '{{class_category_file_links}}', '42', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1530', '{{courses}}', '15', 'title', 'en', 'IELTS');
INSERT INTO `ym_translations` VALUES ('1531', '{{courses}}', '15', 'summary', 'en', '<p dir=\"ltr\" style=\"text-align:justify\">Similar to the TOEFL iBT courses to be held in Avaye Shahir Institute, IELTS course&nbsp;are supposed to be quite different from those held in other institutes. First, for these courses, some discount will be offered to university students, a part of which will be through Netbarg Site and its mobile application, making the enrolment ideal for the students. Second, unlike other institutes, two writing samples of each student in any course will be edited by the instructors, which has a great influence on their IELTS Writing score. Third, at the end of any course, at the request of the students, a workshop will be held in which students&rsquo; writing samples will be discussed in detail, and final key points will be elaborated upon in this&nbsp;workshop. Through holding such courses, I hope we will be able to make a small but positive contribution to society in general and our dear students in particular.</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Wish you all the best</p>\r\n\r\n<p dir=\"ltr\" style=\"text-align:justify\">Amir Khadem:&nbsp;Manager of Avaye Shahir Institute</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1554', '{{class_category_files}}', '60', 'title', 'en', 'General IELTS Writing Pamphlet Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1555', '{{class_category_files}}', '60', 'summary', 'en', 'This pamphlet and \"Pre-IELTS Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass TOEFL, PhD TOEFL, IELTS, GRE, and GMAT. I hope you the next ones. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1560', '{{class_category_files}}', '57', 'title', 'en', 'Pre-IELTS Writing Pamphlet Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1561', '{{class_category_files}}', '57', 'summary', 'en', 'This pamphlet and the other one \"General IELTS Writing Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass TOEFL, PhD TOEFL, IELTS, GRE, and GMAT. I hope you the next ones. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1570', '{{class_category_files}}', '59', 'title', 'en', 'Academic IELTS Writing Pamphlet');
INSERT INTO `ym_translations` VALUES ('1571', '{{class_category_files}}', '59', 'summary', 'en', 'This pamphlet and \"Academic Writing Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass TOEFL, PhD TOEFL, IELTS, GRE, and GMAT. I hope you the next ones. Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1572', '{{class_category_files}}', '53', 'title', 'en', 'Pre-IELTS Writing Pamphlet Compiled by Amir Khadem');
INSERT INTO `ym_translations` VALUES ('1573', '{{class_category_files}}', '53', 'summary', 'en', 'This pamphlet and \"IELTS Writing Pamphlet\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass such tests as IELTS, TOEFL, PhD TOEFL, GRE, and GMAT.  Amir Khadem.');
INSERT INTO `ym_translations` VALUES ('1576', '{{class_category_files}}', '55', 'title', 'en', 'Pre-TOEFL  Pamphlet Compiled by Amir Khadem PDF');
INSERT INTO `ym_translations` VALUES ('1577', '{{class_category_files}}', '55', 'summary', 'en', 'This pamphlet and the other one \"Grammar Pamphlet for PhD TOEFL\" have been taught by me, Amir Khadem, for almost 15 years in quite a few institutes and universities such as Sharif University of Technology, by the help of which many students have been able to successfully pass the PhD TOEFL that is held in Iran. ');
INSERT INTO `ym_translations` VALUES ('1584', '{{class_categories}}', '31', 'title', 'en', 'Grammar References for PhD TOEFL');
INSERT INTO `ym_translations` VALUES ('1585', '{{class_categories}}', '31', 'summary', 'en', '<p dir=\"ltr\" style=\"text-align: justify;\">If you read the grammar pamphlets provided here and do their exercises, you can receive a very good score in the PhD TOEFL that is held in Iran.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1586', '{{class_categories}}', '29', 'title', 'en', 'IELTS Academic');
INSERT INTO `ym_translations` VALUES ('1587', '{{class_categories}}', '29', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1588', '{{class_categories}}', '28', 'title', 'en', 'IELTS General');
INSERT INTO `ym_translations` VALUES ('1589', '{{class_categories}}', '28', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1590', '{{class_categories}}', '33', 'title', 'en', 'Vocabulary Sources for the PhD TOEFL Test');
INSERT INTO `ym_translations` VALUES ('1591', '{{class_categories}}', '33', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1634', '{{class_category_file_links}}', '49', 'title', 'en', '6- A GRE Issue Task Example (MP4)');
INSERT INTO `ym_translations` VALUES ('1635', '{{class_category_file_links}}', '49', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1636', '{{class_category_file_links}}', '48', 'title', 'en', '5- GRE Introduction to the Issue Task (MP4)');
INSERT INTO `ym_translations` VALUES ('1637', '{{class_category_file_links}}', '48', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1638', '{{class_category_file_links}}', '47', 'title', 'en', '4- GRE Time Management (MP4)');
INSERT INTO `ym_translations` VALUES ('1639', '{{class_category_file_links}}', '47', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1640', '{{class_category_file_links}}', '46', 'title', 'en', '3- GRE Writing Tips (MP4)');
INSERT INTO `ym_translations` VALUES ('1641', '{{class_category_file_links}}', '46', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1642', '{{class_category_file_links}}', '44', 'title', 'en', '2- GRE Essay Organization (MP4)');
INSERT INTO `ym_translations` VALUES ('1643', '{{class_category_file_links}}', '44', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1646', '{{class_category_file_links}}', '43', 'title', 'en', '1- An Introduction to GRE Analytical Writing (MP4)');
INSERT INTO `ym_translations` VALUES ('1647', '{{class_category_file_links}}', '43', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1648', '{{class_category_file_links}}', '53', 'title', 'en', 'An Introduction to GRE Analytical Writing (PDF)');
INSERT INTO `ym_translations` VALUES ('1649', '{{class_category_file_links}}', '53', 'summary', 'en', 'This 29-page PDF file explains the GRE Analytical Writing in a brief but practical way, the last 3 pages of which beautifully shows how these writing modules are scored.');
INSERT INTO `ym_translations` VALUES ('1650', '{{class_categories}}', '32', 'title', 'en', 'Video & PDF  Files about Different Modules  of the GRE Exam');
INSERT INTO `ym_translations` VALUES ('1651', '{{class_categories}}', '32', 'summary', 'en', '<p dir=\"ltr\">There are many references for different modules of GRE, but the ones introduced here are good enough for a decent score.&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Good Luck&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Amir Khadem: Manager of Avaye Shahir Institute.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1652', '{{class_category_file_links}}', '57', 'title', 'en', 'Mark Alan Stewart Gre Answers to the Real Essay Questions');
INSERT INTO `ym_translations` VALUES ('1653', '{{class_category_file_links}}', '57', 'summary', 'en', 'This book contains great samples for both the Argument Task and the Issue Task, which provide the test taker with innovative ideas as well as good words and phrases.');
INSERT INTO `ym_translations` VALUES ('1654', '{{class_category_file_links}}', '58', 'title', 'en', 'GRE Official Guide 2nd Edition by ETS');
INSERT INTO `ym_translations` VALUES ('1655', '{{class_category_file_links}}', '58', 'summary', 'en', 'This book whose new versions are also available is a great source for all GRE modules.');
INSERT INTO `ym_translations` VALUES ('1656', '{{class_category_file_links}}', '59', 'title', 'en', 'Barron\'s New GRE 19th Eddition');
INSERT INTO `ym_translations` VALUES ('1657', '{{class_category_file_links}}', '59', 'summary', 'en', 'This book, too,  is a great source for all GRE modules.');
INSERT INTO `ym_translations` VALUES ('1658', '{{class_category_file_links}}', '60', 'title', 'en', 'Verbal Advantage - 10 Easy Steps to a Powerful Vocabulary (Unabridged) (PDF)');
INSERT INTO `ym_translations` VALUES ('1659', '{{class_category_file_links}}', '60', 'summary', 'en', 'This book, which has a great audio file, is a wonderful source for improving GRE vocabulary.');
INSERT INTO `ym_translations` VALUES ('1660', '{{class_category_file_links}}', '61', 'title', 'en', 'Verbal Advantage - Audio Files');
INSERT INTO `ym_translations` VALUES ('1661', '{{class_category_file_links}}', '61', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1662', '{{class_category_file_links}}', '62', 'title', 'en', 'Essential English Idioms Elementary, Intermediate, and Advanced');
INSERT INTO `ym_translations` VALUES ('1663', '{{class_category_file_links}}', '62', 'summary', 'en', 'The book Essential English Idioms is a very important vocabulary source for all 4 skills of TOEFL iBT.');
INSERT INTO `ym_translations` VALUES ('1668', '{{class_categories}}', '34', 'title', 'en', 'Vocabulary Sources for the IELTS Academic');
INSERT INTO `ym_translations` VALUES ('1669', '{{class_categories}}', '34', 'summary', 'en', '<p dir=\"ltr\">In order for you to study the vocabulary sources in order, please refer to &quot;IELTS Academic&nbsp;Syllabus for All Skills&quot;.</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1670', '{{class_category_file_links}}', '64', 'title', 'en', 'Essential English Idioms Elementary, Intermediate, and Advanced');
INSERT INTO `ym_translations` VALUES ('1671', '{{class_category_file_links}}', '64', 'summary', 'en', 'This book is a great source for those who want to improve their Listening, Speaking, and Writing abilities.');
INSERT INTO `ym_translations` VALUES ('1672', '{{class_category_file_links}}', '65', 'title', 'en', 'American Accent Training Program (Pronunciation Workshop) (Video)');
INSERT INTO `ym_translations` VALUES ('1673', '{{class_category_file_links}}', '65', 'summary', 'en', 'These video files beautifully teach how to pronounce English words, which improves your Listening and Speaking skills for the exam.');
INSERT INTO `ym_translations` VALUES ('1674', '{{class_category_file_links}}', '66', 'title', 'en', 'American Accent Training 2 (PDF & Audio)');
INSERT INTO `ym_translations` VALUES ('1675', '{{class_category_file_links}}', '66', 'summary', 'en', 'This is one of the best sources of learning American accent and pronunciation on the word level and sentence level. It is strongly recommended that you read all the book, but in case you are short of time, listen to the audio files of chapter “reduced sounds: page 57 and repeat after it, which is very important for the Listening and Speaking skills.');
INSERT INTO `ym_translations` VALUES ('1676', '{{class_category_file_links}}', '67', 'title', 'en', 'Just Listening and Speaking');
INSERT INTO `ym_translations` VALUES ('1677', '{{class_category_file_links}}', '67', 'summary', 'en', 'This book teaches you the British accent, which is used a lot in the TOEFL iBT Test.');
INSERT INTO `ym_translations` VALUES ('1678', '{{class_category_file_links}}', '68', 'title', 'en', 'Toefl ESL Pod');
INSERT INTO `ym_translations` VALUES ('1679', '{{class_category_file_links}}', '68', 'summary', 'en', 'These audio files that are for pre-intermediate students elaborate on the TOEFL and its modules and teaches the words used in the audios. ');
INSERT INTO `ym_translations` VALUES ('1680', '{{class_category_file_links}}', '69', 'title', 'en', 'Babylon Glossaries');
INSERT INTO `ym_translations` VALUES ('1681', '{{class_category_file_links}}', '69', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1682', '{{classes}}', '2', 'title', 'en', 'Me');
INSERT INTO `ym_translations` VALUES ('1683', '{{classes}}', '2', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1684', '{{classes}}', '3', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('1685', '{{classes}}', '3', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1686', '{{classes}}', '4', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('1687', '{{classes}}', '4', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1690', '{{class_categories}}', '35', 'title', 'en', 'asdga');
INSERT INTO `ym_translations` VALUES ('1691', '{{class_categories}}', '35', 'summary', 'en', '<p>asdgasdg</p>\r\n');
INSERT INTO `ym_translations` VALUES ('1692', '{{class_categories}}', '36', 'title', 'en', 'asdgasdgasdg');
INSERT INTO `ym_translations` VALUES ('1693', '{{class_categories}}', '36', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1694', '{{class_categories}}', '37', 'title', 'en', 'sdgsdfg');
INSERT INTO `ym_translations` VALUES ('1695', '{{class_categories}}', '37', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1696', '{{class_categories}}', '38', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('1697', '{{class_categories}}', '38', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1700', '{{classes}}', '7', 'title', 'en', '');
INSERT INTO `ym_translations` VALUES ('1701', '{{classes}}', '7', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1702', '{{gallery}}', '1', 'title', 'en', 'Conference');
INSERT INTO `ym_translations` VALUES ('1703', '{{gallery}}', '1', 'desc', 'en', '');
INSERT INTO `ym_translations` VALUES ('1740', '{{gallery}}', '20', 'title', 'en', 'Conference');
INSERT INTO `ym_translations` VALUES ('1741', '{{gallery}}', '20', 'desc', 'en', 'Lorem ipsum dolor sit amet, vis posse tantas ea. Vix an amet vero probo. An per phaedrum inimicus eloquentiam, ea veniam causae honestatis eam, deseruisse constituam complectitur vix te. Ut animal voluptaria qui. At solum cetero sea, ex possim indoctum suscipiantur mei.\r\n\r\nHis ea posse dicat maiestatis, liber consetetur scriptorem eam no. Eu accusam blandit praesent est, ad his recusabo ocurreret voluptatibus, solum pertinax et his. Mei at modo nihil quodsi. Quo ad veri nihil detraxit. Duis comprehensam eos ad, an per ancillae tacimates theophrastus, putant mollis ea cum.\r\n');
INSERT INTO `ym_translations` VALUES ('1742', '{{gallery}}', '21', 'title', 'en', 'Base Construction');
INSERT INTO `ym_translations` VALUES ('1743', '{{gallery}}', '21', 'desc', 'en', 'Lorem ipsum dolor sit amet, vis posse tantas ea. Vix an amet vero probo. An per phaedrum inimicus eloquentiam, ea veniam causae honestatis eam, deseruisse constituam complectitur vix te. Ut animal voluptaria qui. At solum cetero sea, ex possim indoctum suscipiantur mei.\r\n\r\nHis ea posse dicat maiestatis, liber consetetur scriptorem eam no. Eu accusam blandit praesent est, ad his recusabo ocurreret voluptatibus, solum pertinax et his. Mei at modo nihil quodsi. Quo ad veri nihil detraxit. Duis comprehensam eos ad, an per ancillae tacimates theophrastus, putant mollis ea cum.\r\n');
INSERT INTO `ym_translations` VALUES ('1744', '{{user_details}}', '34', 'name', 'en', '');
INSERT INTO `ym_translations` VALUES ('1745', '{{user_details}}', '34', 'family', 'en', '');
INSERT INTO `ym_translations` VALUES ('1748', '{{teacher_details}}', '35', 'name', 'en', 'Ali');
INSERT INTO `ym_translations` VALUES ('1749', '{{teacher_details}}', '35', 'family', 'en', 'Qaffarian');
INSERT INTO `ym_translations` VALUES ('1750', '{{teacher_details}}', '35', 'grade', 'en', 'MBA');
INSERT INTO `ym_translations` VALUES ('1751', '{{teacher_details}}', '35', 'resume', 'en', '');
INSERT INTO `ym_translations` VALUES ('1752', '{{teacher_details}}', '35', 'address', 'en', '');
INSERT INTO `ym_translations` VALUES ('1753', '{{classes}}', '5', 'title', 'en', 'Even Term');
INSERT INTO `ym_translations` VALUES ('1754', '{{classes}}', '5', 'summary', 'en', '');
INSERT INTO `ym_translations` VALUES ('1755', '{{user_details}}', '36', 'name', 'en', '');
INSERT INTO `ym_translations` VALUES ('1756', '{{user_details}}', '36', 'family', 'en', '');
INSERT INTO `ym_translations` VALUES ('1757', '{{user_details}}', '37', 'name', 'en', '');
INSERT INTO `ym_translations` VALUES ('1758', '{{user_details}}', '37', 'family', 'en', '');
INSERT INTO `ym_translations` VALUES ('1759', '{{user_details}}', '38', 'name', 'en', '');
INSERT INTO `ym_translations` VALUES ('1760', '{{user_details}}', '38', 'family', 'en', '');
INSERT INTO `ym_translations` VALUES ('1761', '{{classes}}', '6', 'title', 'en', 'سشسیل');
INSERT INTO `ym_translations` VALUES ('1762', '{{classes}}', '6', 'summary', 'en', '');

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  `create_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('34', '', '$2a$12$SAxsWeA0yfz28s8ldX4.8OZpwkw2D8qhZaimkVzL0yQN.XC3xvmAW', 'yusef.mobasheri@gmail.com', '1', 'active', null, '0', null);
INSERT INTO `ym_users` VALUES ('35', '', '$2a$12$l3kDJVXy1CPRCtIKfPpSde5Y/11XAxk1zmgCUbrVIDfCvrPLU8Mgq', 'saeed@google.com', '2', 'active', null, '0', null);
INSERT INTO `ym_users` VALUES ('38', '', '$2a$12$gFPGhhW5NbCg1wN5QobrUOcVtGe2Rxlw6i/pGl7joUIxCqgsrDvzy', 'saeed@google.coms', '1', 'active', null, '0', '1464424540');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `family` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` longtext COLLATE utf8_persian_ci COMMENT 'نشانی دقیق پستی',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('34', 'یوسف', 'مبشری', null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('38', 'رضا', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
INSERT INTO `ym_user_roles` VALUES ('2', 'استاد', 'teacher');

-- ----------------------------
-- Table structure for ym_user_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_transactions`;
CREATE TABLE `ym_user_transactions` (
  `class_id` int(10) unsigned NOT NULL COMMENT 'شناسه',
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `amount` varchar(10) DEFAULT NULL COMMENT 'مقدار',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `status` enum('unpaid','paid') DEFAULT 'unpaid' COMMENT 'وضعیت',
  `token` varchar(50) DEFAULT NULL COMMENT 'کد رهگیری',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`class_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ym_user_transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_transactions_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `ym_classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('5', '34', '350000', '1464505749', 'paid', 'S6GB9sg97s77GS7D', 'پرداخت شهریه جهت ثبت نام در دوره تافل دکتری، کلاس ترم زوج');
INSERT INTO `ym_user_transactions` VALUES ('5', '38', '350000', '1464427313', 'paid', 'S6GB9sg97s77GS7G', 'پرداخت شهریه جهت ثبت نام در کلاس ترم زوج');
INSERT INTO `ym_user_transactions` VALUES ('6', '34', '500000', '1464427313', 'paid', 'S6GB9sg97s74GS7G', null);
