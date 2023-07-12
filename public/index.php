<?php 

require __DIR__.'/../vendor/autoload.php';

// On crée un objet $router avec AltoRouter
$router = new AltoRouter();
// La clé BASE_URI a été créée via le .htaccess
$router->setBasePath($_SERVER['BASE_URI']);
// On utilise cet objet pour mapper les routes et les associer à nos contrôleurs
// Pour indiquer le nom du contrôleur et celui de la méthode associée à la route,
// on utilise ici une chaîne de caractères et un séparateur '#' :
// MainController#home => Controller#method
// 'home' => nom de la route

$router->map('GET','/', 'MainController#list', 'home');
$router->map('GET','/detail/[i:numero]', 'MainController#detail', 'detail');
$router->map('GET','/types', 'MainController#types', 'types');
$router->map('GET','/type/[i:type]', 'MainController#type', 'type');

/* Match the current request */
$match = $router->match();

if($match !== false) {
    // Je sépare les 2 parties se trouvant dans "target" ('MainController#home')
    $controllerAndMethod = explode('#', $match['target']);
    //dump($controllerAndMethod); // debug
    // Je stocke les noms dans des variables en concaténant le namespace au nom du controller (pour éviter de le réécrire dans chaque route)
    $controllerName = 'Pokedex\\Controllers\\' . $controllerAndMethod[0];
    //echo '<br>$controllerName='.$controllerName.'<br>';
    $methodName = $controllerAndMethod[1];
    // J'instancie le controller
    // PHP va remplacer la variable $controllerName par sa valeur
    // puis va instancier la bonne classe "new MainController()" par exemple
    $controller = new $controllerName();
    // J'appelle la méthode correspond à la route
    // PHP va remplacer la variable $methodName par sa valeur
    // puis va appeler la bonne méthode "->home()" par exemple
    // On passe en argument le tableau des paramètres dynamiques de la route matchée
    $controller->$methodName($match['params']);
} else {
    // Si aucun match n'a été trouvé par AltoRouter,
    // On envoie la page 404
    $controller = new Pokedex\Controllers\MainController();
    $controller->notFound();
}
