<?php


// URL de l'API GLPI
$apiUrl = 'http://path/to/glpi/apirest.php';


// Identifiants de connexion
$userToken = 'user token';
$appToken = 'app token';


require_once __DIR__ . '/glpi_api/setup.php';
require_once __DIR__ . '/glpi_api/session.php';


// Setup
setup(
    'localhost',            // Host (pour connexion MySQL)
    'read',                 // Username d'un compte pour lire la BDD
    'read_password',        // Mot de passe du compte pour lire la BDD
    'write',                // Username d'un compte pour écrire sur la BDD
    'write_password',       // Mot de passe du compte pour écrire sur la BDD
    $apiUrl,                // URL de l'API REST de GLPI
    $userToken,             // Le user-token du compte GLPI
    $appToken               // Le app-token de GLPI
);


// Créer une session
$session = new Session();

// Se connecter à GLPI
$token = $session->start_session();

if ($token !== '')
{
    echo "Session créé ! \$token = $token\n";
} else {
    echo "Session non créé ...\n";
};


// Rechercher un ticket par son ID
$id = 500;
$ticket = $session->getTicketByID($token, $id);


// Créer un ticket
// $data_create = [
//     'input' => [[
//         'name' => 'Incident explosion',             // Titre du ticket
//         'content' => 'bonjour mon pc a explosé',    // Description du ticket
//         'itilcategories_id' => 7,                   // ID de la catégorie du ticket
//         'type' => 1,                                // Type du ticket : incident->1 ; demande->2
//         'requesttypes_id' => 8,                     // Source du ticket (voir glpi_requesttypes, 'id')
//         '_users_id_requester' => 201,               // Identifiant du compte GLPI qui ouvre le ticket (voir glpi_users, 'id')
//         '_groups_id_assign' => 3                    // Groupe à qui le ticket est assigné (voir glpi_groups, 'id')
//     ]]
// ];

// $data_followup = [
//     'input' => [[
//         'itemtype' => "Ticket",
//         'items_id' => 500,
//         'users_id' => 201,
//         'content' => 'followup explosion',
//         'is_private' => 0,      
//         'requesttypes_id' => 8, 
//         'sourceitems_id' => 0,  
//         'sourceof_items_id' => 0
//     ]]
// ];

$data_link = [
    'input' => [[
        'tickets_id_1' => 500,
        'tickets_id_2' => 480,
    ]]
];

// $ticket = $session->create_ticket($token, $data_create);
// $ticket = $session->create_followup($token, $data_followup);
$ticket = $session->link_ticket($token, $data_link);
print_r($ticket);


// Fermer la session
$session->close_session($token);
echo "Session fermée !";

?>
