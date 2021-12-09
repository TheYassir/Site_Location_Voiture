<?php 
function connect()
{
    if(!isset($_SESSION['user']))
        return false;
    else 
        return true;
}
function adminConnect()
{
    //  Si l'indice 'user' EST DEFINIT dans la session et que l'indice 'statut' a pour valeur 'admin', alors on entre dans le IF
    if(connect() && $_SESSION['user']['statut'] == 'admin')
        return true;
    else 
        return false;
}