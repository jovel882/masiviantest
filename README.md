# Prueba de desarrollo árbol binario

_Prueba de desarrollo para Masivian._


### Pre-requisitos 📋

_Ambiente requerido_

- Php 7.2.0 con phpCli habilitado para la ejecución de comando.
- Mysql 5.7.19.
- Composer 

### Instalación 🔧

1. Clonar el repositorio en el folder del servidor web en uso, **este folder debe tener permisos para que php se pueda ejecutar por CLI y permisos de lectura y escritura para el archivo .env**.

```sh 
git clone https://github.com/jovel882/masiviantest.git 
```

2. Instalar paquetes ejecutando en la raíz del sitio.

```sh 
composer install
```
3. Crear BD con COLLATE 'utf8mb4_general_ci', ejemplo.

```sh 
`CREATE DATABASE masivian COLLATE 'utf8mb4_general_ci';`
```

4. Duplique el archivo `.env.example` incluido en uno `.env` y dentro de este ingrese los valores de las variables de entorno necesarias, las básicas serían las referentes a BD:
- `DB_HOST="value"` Variable de entorno para el host de BD.
- `DB_PORT="value"` Variable de entorno para el puerto de BD.
- `DB_DATABASE="value"` Variable de entorno para el nombre de BD.
- `DB_USERNAME="value"` Variable de entorno para el usuario de BD.
- `DB_PASSWORD="value"` Variable de entorno para la contraseña de BD.
5. En la raíz del sitio ejecutar.
- `php artisan key:generate && php artisan config:cache` Genera la llave para el cifrado de proyecto y refresca las configuraciones.
- `php artisan migrate` Crea la estructura de BD. 
- `php artisan db:seed` Carga los datos de ejemplo, en este caso el árbol inicial enviado en la prueba.
- `php artisan serve` Arranca el servidor web.

##### Nota: 
Si desea puede ejecutar todos los comandos anteriores juntos si ejecuta 
```sh
php artisan key:generate && php artisan config:cache && php artisan migrate && php artisan db:seed && php artisan serve
```
6. En la raíz del sitio usar este comando si se desea ejecutar las pruebas.
```sh 
vendor/bin/phpunit
```
## Descripción general de la API ⚙️

Método| URL| Nombre| Descripción| Parámetros
| ------ | ------ | ------ | ------ | ------ |
GET| api/tree| Buscar árbol.| Busca un árbol de acuerdo a los parámetros proporcionados.| __1. name__ (Requerido): Define el nombre a buscar del árbol.<br> __2. any__ (Requerido, 1 ó 0): Define si se realiza una búsqueda en cualquier parte de nombre o una exacta.
POST| api/tree| Crear árbol.| Crea un árbol.| __1. name__ (Requerido, no debe existir): Define el nombre para el árbol a crear.
GET| api/tree/all| Obtener todos los árboles.| Trae todos los arboles disponibles.| N/A
GET| api/tree/__{id}__| Obtener árbol.| Trae el árbol especificado en la url como parámetro, este debe ser numérico.| N/A
PUT| api/tree/__{id}__| Actualizar árbol.| Actualiza el árbol especificado en la url como parámetro, este debe ser numérico y de acuerdo a los parámetros proporcionados.| __1. name__ (Requerido, no debe existir): Define el nombre nuevo.
DELETE| api/tree/__{id}__| Eliminar árbol.| Elimina el árbol especificado en la url como parámetro, este debe ser numérico.| N/A
GET| api/tree/__{id}__/lowestCommonAncestor| Obtiene ancestro común más cercano.| Obtiene el ancestro común más cercano del árbol especificado en la url como parámetro, este debe ser numérico y de acuerdo con los parámetros enviados.| __1. first-node__ (Requerido, numérico): Primer nodo a buscar en el árbol. <br> __2. second-node__ (Requerido, numérico): Segundo nodo a buscar en el árbol."
POST| api/tree/__{id}__/node| Crear nodo raíz.| Crea el nodo raíz en el árbol especificado en la url como parámetro, este debe ser numérico y de acuerdo con los parámetros enviados.| __1. node__ (Requerido, numérico): Define el nodo a crear.
GET| api/tree/__{id}__/node/__{node}__| Obtener nodo.| Obtiene el nodo especificado en la url del árbol especificado en la url como parámetro, estos deben ser numéricos.| N/A
POST| api/tree/__{id}__/node/__{node}__| Crear nodo.| Crea el nodo como hijo del nodo especificado en la url del árbol especificado en la url como parámetro, estos deben ser numéricos y de acuerdo con los parámetros enviados.| __1. node__ (Requerido, numérico y no debe existir): Define el nodo a crear.
PUT| api/tree/__{id}__/node/__{node}__| Actualiza nodo.| Actualiza el nodo especificado en la url del árbol especificado en la url como parámetro, estos deben ser numéricos y de acuerdo con los parámetros enviados.| __1. node__ (Requerido, numérico y no debe existir): Define el nodo nuevo.
DELETE| api/tree/__{id}__/node/__{node}__| Eliminar nodo.| Elimina el nodo especificado en la url del árbol especificado en la url como parámetro, estos deben ser numéricos.| N/A

## 💻 Despliegue en Heroku
Se realizó un despliegue en Heroku bajo el siguiente End Point:
`https://masiviantest.herokuapp.com/`

Con este, por ejemplo, para realizar la búsqueda del ancestro común más cercano se puede consultar de la siguiente manera:
`https://masiviantest.herokuapp.com/api/tree/1/lowestCommonAncestor?first-node=44&second-node=85`

##### - Nota:
Al no tener costo este espacio en Heroku los tiempos de respuesta no son tan óptimos.

#### 🔗  [Url Postman](https://www.getpostman.com/collections/4f9ca96fb6fa080d7cbe):
En este [enlace](https://www.getpostman.com/collections/4f9ca96fb6fa080d7cbe) se encuentra un json con los request de ejemplo para ser usados en postman.

## Autor ✒️ 

* **John Fredy Velasco Bareño** [jovel882@gmail.com](mailto:jovel882@gmail.com)


------------------------