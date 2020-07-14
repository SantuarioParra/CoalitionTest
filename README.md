
## About Coalition test

This test was made using: 
- **[Vue](https://vuejs.org/)**
- **[Vuex](https://vuex.vuejs.org/)**
- **[Vuetify](https://vuetifyjs.com/)**
- **[VueDraggable](https://github.com/SortableJS/Vue.Draggable)**
- **[Vuelidate](https://vuelidate.js.org)**

All the source code for task and project is my own, except the dependencies and base libraries.

## Installation and usage

- Extract the zip file or clone from : **[Github](https://github.com/SantuarioParra/CoalitionTest)**
- Copy the .env file and add the database to use ,user and password
    * >cp .env.example .env
    * 	~~~~
                DB_HOST=localhost
                DB_DATABASE=your_data_base
                DB_USERNAME=your_username
                DB_PASSWORD=your_password
- Generate a new key for the project
    * >  php artisan key:generate
- Install Composer
    * >composer install 
- Run npm for NodeJs dependencies and recompile app.js
    * >npm install
    * >npm run dev or npm run build
- Make the migrations
    * >php artisan migrate
- If you want to run the unit test go to php.ini and uncomment 
    * >  ;extension=sqlite.so to extension=sqlite.so
    * and finally use in the console to run the tests
        * > vendor\bin\phpunit.bat
- Create a virtual host or use the local host to see the Task manager
