# API de BileMo



![bilemo](https://media.istockphoto.com/vectors/online-shopping-concept-with-characters-mobile-ecommerce-store-with-vector-id1047109030)



* Auteur du projet: François M. 	
* Contexte: Parcours Développeur d'application PHP / Symfony chez Openclassrooms  	
* Date: 26/11/2019

* Version: 0.2
* Etat du projet: En cours
* Site web du projet: A venir


-----------------

## Langages & librairies utilisées:

* Symfony 4.3.8

* Librairie: JMS Serialize



-----------------

## Résumé du projet:


Ce projet est une API Rest qui propose à ses clients d'avoir un accès à un catalogue de smartphones à des clients. Elle respecte 3 niveaux de maturité du modèle de Richardson.

## Fonctionnalités:

Cette API présente un catalogue de smartphone à ses clients qui ont des utilisateurs:

* Se connecter

* Lire la liste des smartphones proposés

* Créer des utilisateurs liés à un client
* Lire la liste des utilisateurs liés à un client
* Lire les détails d'un client
* Supprimer l'utilisateur d'un client


## Installation du projet:

/

## Fonctionnement de l'API:

/

## Ressources disponibles

![bilemo](https://i.goopics.net/XL0vp.jpg)


## Utilisation

### Connexion

Pour accéder aux services de l'API, il est nécessaire de réaliser deux actions. L'utilisateur doit d'abord s'authentifier, il recevra un token comme réponse. Il lui suffira d'ajouter le token à chacune de ses requêtes pour accéder à ses services.


##### Type de requête:

Adresse: 
 ```  /login  ```
 

Méthode: ``` POST ``` 

Il suffit d'envoyer ses données au format Json dans le body de la requête.
 

#### Exemple de requête:

Body:  ``` {
 "name" : "FakeName",
 "password" : "0000"
} ```

#### Exemple de réponse:

En cas de saisie correcte, vous recevez une réponse du type:

```
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiQmlsZU1vIiwicGFzc3dvcmQiOiIxMjM1In0.MPVbM_O6QLob7lqnfhzezpxieuNzpCuWKbTZlQZY-82E"
```

Sinon vous recevrez un message du type:

```
"User not found"
```

### Consulter le catalogue

L'API propose deux façons de consulter les smartphones:

#### Consulter l'ensemble des smartphones


Adresse: 
 ```  /products  ```
 

Méthode: ``` GET ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

#### Exemple:

Vous recevez une réponse du type:

```
  {
    "id": 5,
    "reference": "GalaxyFake10",
    "color": "Blackfake",
    "delay": 3,
    "picture": null,
    "price": 400,
    "storage": 16,
    "brand": {
      "id": 6,
      "name": "SamsungTest",
    },
    "stock": 100
  },
```



#### Rechercher un smartphone

Adresse: 
 ```  /products/{reference} ```
 

Méthode: ``` GET ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

#### Exemple:

Requête envoyée: ```  /products/GalaxyFake10 ```



Vous recevez une réponse du type:

```
  {
    "id": 5,
    "reference": "GalaxyFake10",
    "color": "Blackfake",
    "delay": 3,
    "picture": null,
    "price": 400,
    "storage": 16,
    "brand": {
      "id": 6,
      "name": "SamsungTest",
    },
    "stock": 100
  },
```

Si la référence n'est pas trouvée, vous recevrez une réponse du type:

```
{}
```

### Gérer les clients

#### Voir les clients


Adresse: 
 ```  /clients/ ```
 

Méthode: ``` POST ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

##### Exemple:

Body envoyée:

 ```  
 {
        "id": 50,
        "name": "specialGit3",
        "username": "userGit",
        "address": "14 rue de Beaune",
        "phoneNumber": "06 15 10 15 01",
        "user": "BileMo",
        "product": null
}
  ```



Vous recevez une réponse du type:

```
"Le client a été ajouté."
```

#### Voir un client


Adresse: 
 ```  /clients/ ```
 

Méthode: ``` POST ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

##### Exemple:

Body envoyée:

 ```  
 {
        "id": 50,
        "name": "specialGit3",
        "username": "userGit",
        "address": "14 rue de Beaune",
        "phoneNumber": "06 15 10 15 01",
        "user": "BileMo",
        "product": null
}
  ```



Vous recevez une réponse du type:

```
"Le client a été ajouté."
```

#### Ajouter un client


Adresse: 
 ```  /clients/ ```
 

Méthode: ``` POST ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

##### Exemple:

Body envoyée:

 ```  
 {
        "id": 50,
        "name": "specialGit3",
        "username": "userGit",
        "address": "14 rue de Beaune",
        "phoneNumber": "06 15 10 15 01",
        "user": "BileMo",
        "product": null
}
  ```



Vous recevez une réponse du type:

```
"Le client a été ajouté."
```

#### Supprimer un cllient

Adresse: 
 ```  /clients/ ```
 

Méthode: ``` DELETE ``` 


Commentaire: ``` Nécesssite d'être authentifié ```

##### Exemple:

Body envoyé:

 ```  
 {
        "id": 50,
        "name": "specialGit3",
        "username": "userGit",
        "address": "14 rue de Beaune",
        "phoneNumber": "06 15 10 15 01",
        "user": "BileMo",
        "product": null
}
  ```



Vous recevez une réponse du type:

```
""Le client a bien été supprimé."
```



-----------------

### Mises à jour:

- Création du projet: 25/11/19
- Installation des différents bundles + mise à jour du README: 26/11/19


