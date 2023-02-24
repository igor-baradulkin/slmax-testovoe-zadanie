<?php
class PeoplesList{
    public $peoplesArr = [];

    private function __construct($id, $exp = '<'){
        $conn = new PDO();
        $sqlQuery = "SELECT Id, Name, Surname, BirthDate, Gender, CityBirth FROM peoples WHERE Id $exp $id";

        $result = $conn->query($sqlQuery)->fetchAll();

        foreach($result as $row){
            $person = PeoplesDB::CreatePeoplesDB((int)$row['Id'], $row['Name'], $row['Surname'], $row['BirthDate'], (int)$row['Gender'], $row['CityBirth']);
            
            $this->peoplesArr[] = $person;
        }

        $conn = NULL;
    }

    public static function CreatePeoplesList($id, $exp = '<'){
        if(class_exists('PeoplesDB')){
            return new PeoplesList($id, $exp);
        }
        else {
            echo "Класс PeoplesDB не объявлен. Дальнейшая работа невозможно";
            return NULL;
        }
    }

    public function deletePeoplesFromDB(){
        if($this->peoplesArr){
            $conn = new PDO();

            $idList = [];
            foreach($this->peoplesArr as $person){
                $idList[] = $person->id;
            }

            $strIdList = implode(',', $idList);
            $sqlQuery = "DELETE FROM peoples WHERE Id IN ($strIdList)";  
            $conn->query($sqlQuery);

            $conn = NULL;
        }
        else{
            echo "По заданным параметрам список людей отсутствует";
        }
    }

    public function setPeoplesArr(){
        return $this->$peoplesArr;
    }
}
