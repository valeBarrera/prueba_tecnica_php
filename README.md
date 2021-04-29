## Intrucciones
-   Cree una BDD para el proyecto.
-   Registre sus credenciales de la BDD en el archivo .env que se encuentra en el directorio raíz del proyecto.
-   Ejecute la intrucción `php artisan migrate:fresh`
-   Ejecute la instrucción para ejecutar el proyecto `php artisan serve`

## Funcionalidades
-   Creación de nuevos Usuarios.
-   Creación de nuevos Grupos.
-   Asignación de un usuario a un grupo.

## API REST
-   La url base para utilizar la API es la siguiente: http://127.0.0.1:8000/api/

API Funtion | Rout | Body request | HTTP protocol
------------ | ------------ | ------------- | ------------- 
Create user | /user | username, name, lastname, email | POST
Create group | /group | name, description | POST
Asignate user to group | /asign | user_id, group_id | POST

- Además se incluyeron las funcionalidades de update y destroy

API Funtion | Rout | Body request | HTTP protocol
------------ | ------------ | ------------- | ------------- 
Update user | /user | username, name, lastname, email | PUT/PATCH
Update group | /group | name, description | PUT/PATCH
Destroy user | /user | username, name, lastname, email | DELETE
Destroy group | /group | name, description | DELETE


