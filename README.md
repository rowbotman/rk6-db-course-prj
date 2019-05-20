# Разработка информационной системы «Бонусная программа»
## Описание задачи  
Авиакомпания ведет бонусную программу.
Каждый пассажир, купивший хотя бы один билет на рейсы авиакомпании имеет право вступить в эту программу.
Сведения о пассажирах, вступивших в бонусную программу, сохраняются в БД авиакомпании.
В соответствии с правилами‚ участники бонусной программы получают бонусы за
каждый купленный и использованный для полета авиабилет. Количество бонусов,
начисляемых за билет, зависит от рейса и даты его вылета, и определяется по
специальной шкале.

Все бонусы, накопленные участниками программы, сохраняются в БД, и в дальнейшем
могут быть использованы для покупки новых билетов.

## Разработка  
1. Выделение сущностей:
     * Пассажир (уникальный номер пользователя, фамилия, имя, количество бонусов)  
     * Рейс (уникальный номер рейса, аэропорт отбытия, аэропорт назначения, дата отправления)  
     * Билет (уникальный номер билета,  номер рейса, стоимость, класс билета, номер пользователя)  
     * Детализация полета пассажира (ID пользователя,
     ID билета, текущее кол-во бонусов на счете, дата начисления бонусов)  

    ![Схема БД](https://i.ibb.co/fMmrrHx/data-base-interface-Page-2.png)  
2. Разработка оперативных запросов:  
    + Создать отчет о зачислении бонусных миль по форме: номер рейса, дата вылета, общее кол-во бонусных миль
    ```sql
       SELECT t.flight_id, t.departure, SUM(d.cur_value) FROM detail d
       JOIN ticket t ON (t.uid = d.ticket_id) 
       GROUP BY t.flight_id, t.departure;
    ```   
    + Создать отчет о продаже билетов за 2017 год по форме: номер рейса, месяц вылета, класс билета, число проданных билетов
    ```sql   
       SELECT f.dep_airport, t.departure, t.class, COUNT(*) FROM ticket t
       JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(t.departure) = 2017
       GROUP BY f.dep_airport, t.departure, t.class;
    ```   
    + Получить сведения о пассажирах, покупавших самые дорогие билеты на рейс ХХХ
    ```sql   
       SELECT * FROM profile p 
       JOIN ticket t ON (p.uid = t.user_id)
       WHERE t.price = (
         SELECT MAX(price) FROM ticket WHERE flight_id = 79
       ) AND t.flight_id = XXX;
    ```   
    + Показать сведения о пассажирах, которые зарегистрированные в бд, но не купили ни одного билета
    ```sql  
       SELECT * FROM profile p LEFT JOIN ticket t ON (t.user_id = p.uid) WHERE t.user_id IS NULL;
    ```   
    + Показать сведения о пассажирах, непокупавших билет в марте 2014
    ```sql   
       SELECT distinct p.uid, p.firstName, p.lastName, p.votes 
       FROM profile p JOIN ticket t ON (p.uid = t.user_id)
       WHERE YEAR(t.departure) <> 2014 AND MONTH(t.departure) <> 3;
    ```   
    + Показать сведения о пассажирах, чаще всего покупавших билет в марте-апреле 2013 (используя view);
    ```sql   
       CREATE OR REPLACE VIEW spring_flight AS  
       (  
           SELECT MAX(num) FROM (  
               SELECT COUNT(*) AS num FROM ticket t  
               JOIN flight f ON (f.uid = t.flight_id)  
               WHERE YEAR(f.dep_date) = 2013   
               AND MONTH(f.dep_date) BETWEEN 3 AND 4  
               GROUP BY t.user_id  
           ) subquery  
       );  
       
       SELECT p.* FROM profile p JOIN ticket t ON (t.user_id = p.uid)  
       JOIN flight f ON (f.uid = t.flight_id)    
       WHERE YEAR(f.dep_date) = 2013 AND MONTH(f.dep_date) BETWEEN 3 AND 4   
       GROUP BY p.uid HAVING COUNT(*) = (SELECT * FROM spring_flight);  
     ```  
3. Реализация веб-приложения:  
    Приложение реализовано в соответствии с паттерном MVC (Model, View, Controller), поэтому переходы на различные странцы, получение и отправка данных по принципу работы одинаковы (Отрисовкой занимаются view, получением данных от пользователя и контролем над логикой работы view и модели занимаются контроллеры, а в моделях происходит получение данных для базовой работы приложения. Приведем пример работы стартовой страницы.  
    Для запуска приложения загружается скрипт index.php, который подключает необходимые модули и запускает роутер. В роутере, в зависимости от введенного url пользователем, происходит создание соответствующего контроллера, а в нем соответствующего view и, если это необходимо, соответсвующей модели.
    ![application schemas](https://i.ibb.co/kx0nYGy/data-base-interface.png>)  
    
## Используемые ресурсы
1. [Хабр](https://habr.com/ru/post/150267) — Реализация MVC паттерна
2. [PHP](https://www.php.net/) — документация по языку программирования php
3. [MySQL](http://www.mysql.ru/) — документация по mysql-серверу
