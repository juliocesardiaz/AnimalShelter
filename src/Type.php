<?php
	
	class Type {
		private $name;
		private $id;
		
		function __construct($name, $id=null) {
			$this->name  = $name;
			$this->id = $id;
		}
		
		function setName($new_name) {
			$this->name = (string) $new_name;
		}
		
		function getName() {
			return $this->name;
		}
		
		function getId() {
			return $this->id;
		}
		
		function save() {
			$GLOBALS['DB']->exec("INSERT INTO types (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
		
		static function getAll() {
			$returned_types = $GLOBALS['DB']->query("SELECT * FROM types;");
			$types = array();
			foreach($returned_types as $type) {
				$name = $type['name'];
				$id = $type['id'];
				$new_type = new Type($name, $id);
				array_push($types, $new_type);
			}
		return $types;
		}
		
		static function deleteAll() {
			$GLOBALS['DB']->exec("DELETE FROM types;");
		}
		
		static function find ($search_id) {
			$found_type = null;
			$types = Type::getAll();
			foreach($types as $type) {
				$type_id = $type->getId();
				if($type_id == $search_id) {
					$found_type = $type;
				}
			}
			return $found_type;
		}
		
		function getAnimals() {
			$animals = array();
			$returned_animals = $GLOBALS['DB']->query("SELECT * FROM animal WHERE type_id = {$this->getId()};");
			foreach($returned_animals as $animal) {
				$id = $animal['id'];
				$name = $animal['name'];
				$gender = $animal['gender'];
				$breed = $animal['breed'];
				$age = $animal['age'];
				$type_id = $animal['type_id'];
				$new_Animal = new Animal($name, $gender, $breed, $age, $type_id, $id);
				array_push($animals, $new_Animal);
			}
		return $animals;
		}
		
	}
	
?>