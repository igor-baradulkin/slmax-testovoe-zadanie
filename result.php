<?php
require_once 'PeoplesDB.php';
require_once 'PeoplesList.php';

// Создаём экземпляры класса PeoplesDB c помощью статического класса CreatePeoplesDB
$person1 = PeoplesDB::CreatePeoplesDB(1 , "Antonio", "Montana", '21.09.1995', 1, "Havana");
$person2 = PeoplesDB::CreatePeoplesDB(2 , "Brock", "Thompson", '14.06.1998', 1, "Bogota");
$person3 = PeoplesDB::CreatePeoplesDB(3 , "Christopher", "Johnson", '13.03.2002', 1, "Jakarta");
$person4 = PeoplesDB::CreatePeoplesDB(4 , "Verge", "Taylor", '11.10.2014', 1, "Innsbruck");
$person5 = PeoplesDB::CreatePeoplesDB(5 , "Antonio", "Foster", '12.11.1994', 1, "Casablanca");
$person6 = PeoplesDB::CreatePeoplesDB(6 , "Aubree", "Garcia", '12.11.1994', 0, "Leipzig");
$person7 = PeoplesDB::CreatePeoplesDB(7 , "Tina", "Cox", '19.02.2000', 0, "Madrid");

// Сохраняем людей в базу данных
$person1->savePeopleInDB();
$person2->savePeopleInDB();
$person3->savePeopleInDB();
$person4->savePeopleInDB();
$person5->savePeopleInDB();
$person6->savePeopleInDB();
$person7->savePeopleInDB();

// Создаём класс PeoplesList, в статическом методе которого указываем Id и одно из трёх выражений <, >, !=(по умолчанию стоит <)
$peoplesList1 = PeoplesList::CreatePeoplesList(10);

//Удаляем полученный список людей. В случае, если список окажется пустым, получим сообщение о том, что список людей по указанным параметрам отсутствует
$peoplesList1->deletePeoplesFromDB();