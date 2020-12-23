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

            <form>
                <input type="text" v-model="form.name">
                <button @click.prevent="add" v-show="!updateSubmit">Add</button>
                <button @click.prevent="update" v-show="updateSubmit">Update</button>
            </form>
        
            <ul>
                <li v-for="(user , index) in users">
                    <span>@{{ user.name }}</span>
                    <button v-on:click="edit(user, index)">edit</button>
                    <button>delete</button>
                </li>
            </ul>
    
        </div>
    
        <script src="{{ url('/vue/vue-script.js') }}"></script>
        <script src="{{ url('/vue/vue-resource.js') }}"></script>
        <script>
            var app = new Vue({
                el: "#app",
                data: {
                    users: [],
                    updateSubmit: false,
                    form: {
                        'name': '',
                    },
                    selectedUserId: null,
                },
                methods: {
                    add() {
                        let userInput = this.form.name.trim();
                        if(userInput){
                            this.$http.post('/api/user', {name: userInput}).then(response => {
                                this.users.unshift({ name : userInput })
                                this.form = {}
                            });
                        }
                    },
                    edit(user , index) {
                        this.$http.post('/api/user/update/' + user.id).then(response => {
                            this.selectedUserId = this.index
                            this.updateSubmit = true
                            this.form.name = user.name    
                        });
                    },
                    update() {
                        this.users[this.selectedUserId].name = this.form.name
                        this.form = {}
                        this.updateSubmit = false
                        this.selectedUserId = null 
                    },
                },
                mounted: function() {
                    this.$http.get('/api/user').then(response => {
                        let result = response.body.data
                        this.users = result
                    })
                },
            });
        </script>
    
    </body>
</html>