Что это такое? 
Класс позволяет склонять слова, имена и словосочетания на русском языке. 
В качестве источника склонений используется Яндекс.Склонятор (http://nano.yandex.ru/project/inflect/)

Класс сохраняет полученные результаты в базе данных и при повторной попытке просклонять слово берет результат уже из локальной базы

Установка
Создать таблицу в базе данных:

CREATE TABLE  `inflections`.`inflections` (
  `id` int(11) NOT NULL auto_increment,
  `case1` varchar(250) character set latin1 NOT NULL,
  `case2` varchar(250) character set latin1 NOT NULL,
  `case3` varchar(250) character set latin1 NOT NULL,
  `case4` varchar(250) character set latin1 NOT NULL,
  `case5` varchar(250) character set latin1 NOT NULL,
  `case6` varchar(250) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`,`case1`)
) DEFAULT CHARSET=utf8;

Подразумевается что подключение к базе данных уже было произведено выше по коду, поэтому никакого отдельного конфига для настроек
доступа к базе данных нет. В файле test.php для тестирования есть настройки базы и код для подключения к ней.

Желаю удачного применения