<?php 
class PeoplesDB {
    public $id;
    public $name;
    public $surname;
    public $birthDate;
    public $gender;
    public $cityBirth;

    private function __construct($id, $name, $surname, $birthDate, $gender, $cityBirth){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->cityBirth = $cityBirth;
    }

    public static function CreatePeoplesDB($id, $name, $surname, $birthDate, $gender, $cityBirth){
        if(self::validateId($id) && self::validateName($name) && self::validateSurname($surname) && self::validateBirthDate($birthDate) && self::validateGender($gender) && self::validateCityBirth($cityBirth)){
            return new PeoplesDB($id, $name, $surname, $birthDate, $gender, $cityBirth);
        }
        else {
            return NULL;
        }
    }

    public function savePeopleInDB(){
        $conn = new PDO("mysql:host=localhost;dbname=organization", "root", "");
        $sqlQuery = "SELECT Id, Name, Surname, BirthDate, Gender, CityBirth FROM peoples WHERE Id = $this->id";
        $result = $conn->query($sqlQuery);

        if(!$result->fetch()){
            $sqlQuery = "INSERT INTO peoples (Id, Name, Surname, BirthDate, Gender, CityBirth) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sqlQuery);

            $stmt->execute(array($this->id, $this->name, $this->surname, $this->birthDate, $this->gender, $this->cityBirth));

            $conn = NULL;
        }

        $conn = NULL;
    }

    public function deletePeopleFromDB(){
        $conn = new PDO("mysql:host=localhost;dbname=organization", "root", "");
        $sqlQuery = "DELETE FROM peoples WHERE Id = ?";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute(array($this->id));
    }
    
    public function formatPeople(){
        $std = new stdClass();
        $std->id = $this->id;
        $std->name = $this->name;
        $std->surname = $this->surname;
        $std->birthDate = $this->birthDate;
        $std->gender = PeoplesDB::convertGender($this->gender);
        $std->cityBirth = $this->cityBirth;
        $std->age = PeoplesDB::convertDateInAge($this->birthDate);

        return $std;
    }

    public static function convertDateInAge($date){
        $explodeCurrentDate = explode('.', date('d.m.Y'));
        $explodePersonDate = explode('.', $date);

        $currentDay = $explodeCurrentDate[0];
        $curentMonth = $explodeCurrentDate[1];
        $currentYear = $explodeCurrentDate[2];

        $personDayBirth = $explodePersonDate[0];
        $personMonthBirth = $explodePersonDate[1];
        $personYearBirth = $explodePersonDate[2];

        return ($currentYear - $personYearBirth) - ($curentMonth >= $personMonthBirth && $currentDay >= $personDayBirth ? 0 : 1);
    }

    public static function convertGender($gender){
        return $gender === 0 ? "Female" : "Male";
    }

    public static function validateId($id){
        return is_int($id) && $id >= 0;
    }

    public static function validateName($name){
        return is_string($name) && strlen($name) <= 20 && ctype_alpha($name);
    }

    public static function validateSurname($surname){
        return is_string($surname) && strlen($surname) <= 20 && ctype_alpha($surname);
    }

    public static function validateBirthDate($birthDate){
        $explodeBirthDate = explode('.', $birthDate);

        if(count($explodeBirthDate) == 3 && strlen($explodeBirthDate[0]) === 2 && ctype_digit($explodeBirthDate[0]) && strlen($explodeBirthDate[1]) === 2 && ctype_digit($explodeBirthDate[1]) && strlen($explodeBirthDate[2]) === 4 && ctype_digit($explodeBirthDate[2])){
            $day = $explodeBirthDate[0][0] === '0' ? (int)substr($explodeBirthDate[0], 1) : (int)$explodeBirthDate[0];
            $month = $explodeBirthDate[1][0] === '0' ? (int)substr($explodeBirthDate[1], 1) : (int)$explodeBirthDate[1];
            $year = (int)$explodeBirthDate[2];

            return checkdate($month, $day, $year);
        }
        else {
            return false;
        }
    }

    public static function validateGender($gender){
        return is_int($gender) && in_array($gender, [0, 1]);
    }

    public static function validateCityBirth($city){
        return is_string($city) && strlen($city) <= 255 && ctype_alpha($city);
    }
}