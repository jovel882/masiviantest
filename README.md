# Prueba de desarrollo arbol binario

_Prueba de desarrollo para Masivian._


### Pre-requisitos 📋

_Ambiente requerido_

- Php 7.2.0 con phpCli habilitado para la ejecucion de comando.
- Mysql 5.7.19.
- Composer 

### Instalación 🔧

1. Clonar el repositorio en el folder del servidor web en uso, **este folder debe terner permisos para que php se pueda ejecutar por CLI y permisos de lectura y escritura para el archivo .env**.

```sh 
git clone https://github.com/jovel882/masiviantest.git 
```

2. Instalar paquetes ejecutando en la raiz del sitio.

```sh 
composer install
```
3. Crear BD con COLLATE 'utf8mb4_general_ci', ejemplo.

```sh 
`CREATE DATABASE masivian COLLATE 'utf8mb4_general_ci';`
```

4. Duplique el archivo `.env.example` incluido en uno `.env` y dentro de este ingrese los valores de las variables de entorno necesarias, las basicas serian las referentes a BD:
- `DB_HOST="value"` Variable de entorno para el host de BD.
- `DB_PORT="value"` Variable de entorno para el puerto de BD.
- `DB_DATABASE="value"` Variable de entorno para el nombre de BD.
- `DB_USERNAME="value"` Variable de entorno para el usuario de BD.
- `DB_PASSWORD="value"` Variable de entorno para la contraseña de BD.
5. En la raiz del sitio ejecutar.
- `php artisan key:generate && php artisan config:cache` Genera la llave para la encripcion de proyecto y refresca las configuracions.
- `php artisan migrate` Crea la estructura de BD. 
- `php artisan db:seed` Carga los datos de ejemplo, en este caso el arbol inicial enviado en la prueba.
- `php artisan serve` Arranca el servidor web.

##### Nota: 
Si desea puede ejecutar todos los comandos anteriores juntos si ejecuta 
```sh
php artisan key:generate && php artisan config:cache && php artisan migrate && php artisan db:seed && php artisan serve
```
6. En la raiz del sitio usar este comando si se desea ejecutar las pruebas.
```sh 
vendor/bin/phpunit
```
## Funciones ⚙️


## Autor ✒️ 

* **John Fredy Velasco Bareño** [jovel882@gmail.com](mailto:jovel882@gmail.com)


------------------------