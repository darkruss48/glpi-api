<?php

require_once __DIR__ . '/setup.php';
require_once __DIR__ . '/func.php';




// use PDO;
// use Exception;
// use PDOException;

class Session
{

    public function start_session()
    {
        // Commence une session.

        // Définir l'URL pour créer une session
        $sessionUrl = BASE_URL_GLPI . '/initSession';

        // Création headers
        $sessionHeaders = [
            'Authorization: user_token ' . userToken,
            'App-Token: ' . appToken,    
            'Content-Type: application/json'
        ];

        // Envoyer la requête
        $sessionResponse = _get_request($sessionUrl, 'GET', null, $sessionHeaders);

        // Vérifier la réponse
        if (isset($sessionResponse['session_token'])) {
            return $sessionResponse['session_token'];
        } else {
            echo "La session n'a pas pu se créer !\n";
            return '';
        }
    }


    public function close_session($sessionToken)
    {
        // Ferme une session.

        // Définir l'URL pour fermer la session
        $sessionUrl = BASE_URL_GLPI . '/killSession';
        
        // Création headers
        $killSessionHeaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken
        ];

        // Envoyer la requête
        _post_request($sessionUrl, null, $killSessionHeaders);

        // Session fermée !
    }

    
    
    //                       TICKETS                       //



    public function getTicketByID($sessionToken, $ticket_id)
    {
        // Cherche un ticket en fonction de son ID.

        // Définir l'URL pour chercher ce ticket
        $ticketbyidurl = BASE_URL_GLPI . "/Ticket/$ticket_id";

        // Création headers
        $ticketbyidheaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken
        ];

        // Envoyer la requête
        $ticketbyidresponse = _get_request($ticketbyidurl, 'GET', null, $ticketbyidheaders);

        // Renvoyer la réponse
        return $ticketbyidresponse;
    }

    public function create_ticket($sessionToken, $data)
    {
        // Créé un ticket.

        // Définir l'URL pour ouvrir le ticket
        $createticketurl = BASE_URL_GLPI . '/Ticket';
        
        // Création headers
        $createticketheaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken,
            'Content-Type: application/json'
        ];

        // Envoyer la requête
        $ticket = _post_request($createticketurl, $data, $createticketheaders);

        // Ticket créé !
        return $ticket;
    }

    public function create_followup($sessionToken, $data)
    {
        // Créé un followup d'un ticket.

        // Définir l'URL pour ouvrir le followup
        $createfollowupurl = BASE_URL_GLPI . '/ITILFollowup'.'/';
        
        // Création headers
        $createfollowupheaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken,
            'Content-Type: application/json'
        ];

        // Envoyer la requête
        $followup = _post_request($createfollowupurl, $data, $createfollowupheaders);

        // Followup du ticket créé !
        return $followup;
    }

    public function link_ticket($sessionToken, $data)
    {
        // Lie deux tickets ensemble.

        // Définir l'URL pour lier les tickets
        $linkticketurl = BASE_URL_GLPI . '/Ticket_Ticket';
        
        // Création headers
        $linkticketheaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken,
            'Content-Type: application/json'
        ];

        // Envoyer la requête
        $link = _post_request($linkticketurl, $data, $linkticketheaders);

        // Ticket avec followup créé !
        return $link;
    }

    public function resolve_ticket($sessionToken, $ticketId, $content, $userid)
    {
        // Permet de résoudre un ticket.

        // Définir l'URL
        $resolveticketurl = BASE_URL_GLPI . '/ITILSolution' . '/';
        
        // Création headers
        $resolveticketheaders = [
            'Session-Token: ' . $sessionToken,
            'App-Token: ' . appToken,
            'Content-Type: application/json' 
        ];

        // Définition des data
        $data = [
            'input' => [[
                'items_id' => $ticketId,
                'solutiontypes_id' => 2, // voir glpi_solutiontypes
                'users_id' => $userid,
                'itemtype' => 'Ticket',
                'content' => $content
            ]]
        ];

        // Envoyer la requête, attention on met à jour donc c'est PATCH
        $resolve = _post_request($resolveticketurl, $data, $resolveticketheaders);

        // Ticket cloturé !
        return $resolve;
    }

    // public function update_status_ticket($sessionToken, $ticketId, $status)
    // {
    //     // Permet de changer le statut d'un ticket.
    //     // Rappel : 
    //     // 1 : Nouveau
    //     // 2 : En cours (Attribué)
    //     // 3 : En cours (Planifié)
    //     // 4 : En attente
    //     // 5 : Résolu
    //     // 6 : Clos

    //     // Définir l'URL pour changer le statut du ticket
    //     $updatestatusticketurl = BASE_URL_GLPI . '/Ticket' . '/' . $ticketId . '/';
        
    //     // Création headers
    //     $updatestatusticketheaders = [
    //         'Session-Token: ' . $sessionToken,
    //         'App-Token: ' . appToken,
    //         'Content-Type: application/json'
    //     ];

    //     // Définition des data
    //     // $data ='{ "input": {"tickets_id": ' . $ticketid . ' ,"status": "' . $status . '"}}';
    //     $data = [
    //         'input' => [[
    //             // 'tickets_id' => $ticketId,
    //             'status' => $status
    //         ]]
    //     ];

    //     // Envoyer la requête, attention on met à jour donc c'est PUT
    //     $update = _patch_request($updatestatusticketurl, $data, $updatestatusticketheaders);

    //     // Statut changé !
    //     return $update;
    // }
}





?>