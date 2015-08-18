<?php
	
	require_once __DIR__."/../vendor/autoload.php";
	require_once __DIR__."/../src/Animal.php";
	require_once __DIR__."/../src/Type.php";
	
	$app = new Silex\Application();
	$app['debug'] = true;
	
	$server = 'mysql:host=localhost;dbname=shelter';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);
	
	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
	
	$app->get("/", function() use ($app) {
		return $app['twig']->render('index.html.twig', array('types' => Type::getAll()));
	});
	
	// $app->get("/animals", function() use ($app) {
	// 	return $app['twig']->render('animals.html.twig', array('animals' => Animal::getAll()));
	// });
	
	$app->get("/types", function() use ($app) {
		return $app['twig']->render('types.html.twig', array('types' => Type::getAll()));
	});
	
	$app->get("/types/{id}", function($id) use ($app) {
		$type = Type::find($id);
		return $app['twig']->render('types.html.twig', array('types' => $type, 'animals' => $type->getAnimals()));
	});
	
	$app->post("/animals", function() use ($app) {
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$breed = $_POST['breed'];
		$age = $_POST['age'];
		$type_id = $_POST['type_id'];
		$animal = new Animal($name, $gender, $breed, $age, $type_id, $id = null);
		$animal->save();
		$type = Type::find($type_id);
		return $app['twig']->render('types.html.twig', array('types' => $type, 'animals' => Animal::getAll()));
	});
	
	$app->post("/types",function() use ($app) {
        $type = new Type($_POST['name']);
        $type->save();
        return $app['twig']->render('index.html.twig', array('types' => Type::getAll()));
    });
	
	$app->post("/delete_types", function() use ($app) {
		Animal::deleteAll();
		Type::deleteAll();
		return $app['twig']->render('index.html.twig', array('types' => Type::getAll()));
	});
	
	return $app;
?>
	