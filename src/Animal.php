<?php 
	class Animal
	{
		private $name;
		private $gender;
		private $breed;
		private $age;
		private $type_id;
		private $id;
		
		function __construct($name, $gender, $breed, $age, $type_id, $id = null) {
			$this->name = $name;
			$this->gender = $gender;
			$this->breed = $breed;
			$this->age = $age; 
			$this->type_id = $type_id;
			$this->id = $id;
		}
		
		function setName($name) {
			$this->name = $name;
		}
		
		function getName() {
			return $this->name;
		}
		
		function setGender($gender) {
			$this->gender = $gender;
		}
		
		function getGender() {
			return $this->gender;
		}
		
		function setBreed($breed) {
			$this->breed = $breed;
		}
		
		function getBreed() {
			return $this->breed;
		}
		
		function setAge($age) {
			$this->age = $age;
		}
		
		function getAge() {
			return $this->age;
		}
		
		function setTypeID($type_id) {
			$this->type_id = $type_id;
		}
		
		function getTypeID() {
			return $this->type_id;
		}
		
		function setID($id) {
			$this->id = $id;
		}
		
		function getID() {
			return $this->id;
		}
		
		function save() {
			$GLOBALS['DB']->exec("INSERT INTO animal (name, gender, breed, age, type_id) VALUES ('{$this->getName()}', '{$this->getGender()}', '{$this->getBreed()}', {$this->getAge()}, {$this->getTypeID()});"); 
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
		
		static function getAll() {
			$returned_animal = $GLOBALS['DB']->query("SELECT * FROM animal ORDER BY breed;");
			$animals = array();
			foreach($returned_animal as $animal) {
				$name = $animal['name'];
				$id = $animal['id'];
				$gender = $animal['gender'];
				$breed = $animal['breed'];
				$age = $animal['age'];
				$type_id = $animal['type_id'];
				$new_animal = new Animal($name, $gender, $breed, $age, $type_id, $id);
				array_push($animals, $new_animal);
			}
			return $animals;
		}
		
		static function deleteAll() {
			$GLOBALS['DB']->exec("DELETE FROM animal;");
		}
		
		static function find($search_id) {
			$found_animal = null;
			$animals = Animal::getAll;
			foreach($animals as $animal) {
				$animal_id = $animal->getID();
				if($animal_id == $search_id) {
					$found_animal = $animal;
				}
			}
			return $found_animal;
		}
	}
?>