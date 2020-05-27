<?php
require ("models/dbConnect/dbConnect.php");
session_start();

if (empty($_GET["page"])) {
    require "controllers/home/home.php";
} else {
    switch ($_GET["page"]){
        // ROUTAGE PARTIE VISITEURS
        case"home" : require "controllers/home/home.php";
        break;

        case"blog" : require "controllers/blog/blog.php";
        break;

        case"article" : require "controllers/article/article.php";
        break;

        case"connexion" : require "controllers/connexion/connexion.php";
        break;

        case"contact" : require "controllers/contact/contact.php";
        break;

        // ROUTAGE PARTIE ADMIN
        case"dashboardHome" : require "controllers/dashboard/dashboardHome/dashboardHome.php";
        break;

        case"category" : require "controllers/dashboard/category/category.php";
        break;

        case"restrictedList" : require "controllers/dashboard/restrictedList/restrictedList.php";
        break;

        case"articles" : require "controllers/dashboard/articles/articles.php";
        break;

        case"users" : require "controllers/dashboard/users/users.php";
        break;

        case"comments" : require "controllers/dashboard/comments/comments.php";
        break;

        // ROUTAGE TRAITEMENT ACTIONS ADMIN
        case"addCategory" : require "controllers/dashboard/addCategory/addCategory.php";
        break;

        case"addCardsRestrictedList" : require "controllers/dashboard/addCardsRestrictedList/addCardsRestrictedList.php";
        break;

        case"addArticles" : require "controllers/dashboard/addArticles/addArticles.php";
        break;

        case"addAuthors" : require "controllers/dashboard/addAuthors/addAuthors.php";
        break;

        case"updateComments" :require "controllers/dashboard/updateComments/updateComments.php";
        break;

        default: require "controllers/home/home.php";

    }
}