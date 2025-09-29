# SDBM Symfony – Beer Inventory Management
# SDBM Symfony – Gestion de Cave à Bières

A Symfony web application to manage a beer inventory system (Stock Database Management - SDBM).  
Developed as part of my training, it showcases my ability to build structured back-end applications with a modern PHP framework.

Une application web Symfony pour gérer un système d’inventaire de bières (Stock Database Management - SDBM).  
Développée dans le cadre de ma formation, elle démontre ma capacité à créer des applications back-end structurées avec un framework PHP moderne.

---

##  Features / Fonctionnalités
-  Manage beers, breweries, suppliers, and categories  
- Track stock levels and prices  
-  Search and filter database entries  
-  CRUD operations on all entities  
-  Simple and user-friendly interface  

-  Gérer les bières, brasseries, fournisseurs et catégories  
-  Suivre les niveaux de stock et les prix  
-  Rechercher et filtrer les entrées de la base de données  
-  Effectuer des opérations CRUD sur toutes les entités  
-  Interface simple et conviviale  

---
##  Tech Stack
- **Framework:** Symfony 6  
- **Language:** PHP 8  
- **Database:** MySQL  
- **Front-end:** Twig, Bootstrap  
- **Other:** Doctrine ORM  

---

##  Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/carmela0505/SDBM-Symfony.git
## Install dependencies 
composer install

## Configure your database .env and run 
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

## Start the server
symfony serve

## Author
Carmela Urbano
🌐 www.curbano.fr
📧 urbanocarmela56@gmail.com
