<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Learn vue js</title>
    </head>
    <body>

        <div id="app">

            <input type="text" v-model="newUser">
            <button v-on:click="addUser">Add</button>
        
            <ul>
                <li v-for="(user , index) in users">
                    <span>@{{ user.name }}</span>
                    <button v-on:click="updateUser(user)">edit</button>
                    <button v-on:click="removeUser(index, user)">delete</button>
                </li>
            </ul>
    
        </div>
    
        <script src="{{ url('/vue/vue-script.js') }}"></script>
        <script src="{{ url('/vue/vue-resource.js') }}"></script>
        <script>
            new Vue({
                el: "#app",
                data: {
                    newUser: '',
                    editUser: '',
                    users: [],
                },
                methods: {
                    addUser: function() {
                        let userInput = this.newUser.trim();
                        if(userInput)
                        {
                            this.$http.post('/api/user', {name: userInput}).then(response => {
                                this.users.unshift( { name : userInput});
                                this.newUser = '';
                            });
                        }
                    },
                    removeUser: function(index, user) {
                        this.$http.post('/api/user/delete/' + user.id).then(response => {
                            this.users.splice(index, 1);
                            return alert('yakin ingin hapus?');  
                        });
                    },
                    updateUser: function(user) {
                        this.$http.post('/api/user/update/' + user.id).then(response => {    
                            user.name = user.name;
                            console.log(user.name);
                        });
                    },
                },
                mounted: function() {
                    this.$http.get('/api/user').then(response => {
                        let result = response.body.data;
                        this.users = result;
                    });
                },
            });
        </script>
    
    </body>
</html>