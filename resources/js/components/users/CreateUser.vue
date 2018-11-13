<template>
    <div>
        <form class="col s12" @submit.prevent="onCreateUser">
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" name="Name" id="name" v-model="user.name">
                    <label for="name">Name</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="lastname" id="lastname" v-model="user.lastname">
                    <label for="lastname">LastName</label>
                </div>
                <div class="input-field col s12">
                    <input type="email" name="email" id="email" v-model="user.email">
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                    <input type="tel" name="phone" id="phone" v-model="user.phone">
                    <label for="phone">Phone</label>
                </div>
                <div class="input-field col-s12">
                    <input type="password" placeholder="Password" name="password" v-model="user.password" id="user.password">
                    <label for="password">Password</label>
                </div>
                <div class="input-field col s12">
                    <v-select
                        
                        :options="rolesDropdown"
                        label="label"
                        value="value"
                        v-model="user.role"
                    ></v-select>
                    
                </div>
                
                <div class="input-field col s12">
                    <button  type="submit" class="btn">Add User <i class="fa fa-user-plus"></i></button>
                </div>
            </div>
            
        </form>
    </div>
    
</template>
<script>
import { User } from '../../models/user'
export default {
    data(){
        return {
            roles: [],
            user: new User('', 'test', 'test', 'test@mail.com', 'test', '', 'test')
        }
    },
    mounted(){
        this.getRoles()  
    },
    methods: {
        showToastWithText(text, color = '', icon=''){
            var toastHTML = `<span>${icon} ${text}</span>`
            M.toast({html: toastHTML, classes : color});
        },
        getRoles(){
            axios.get(`${base_url}/api/roles`)
            .then(response => {
                this.roles  = response.data
                console.log("roles", this.roles, response.data)
            })
            .catch(err => {
                console.log(err)
            })
        },
        onCreateUser(){
            this.user.role = this.user.role.id
            axios.post(`${base_url}/api/users`, this.user)
            .then(response => {
                if(response.data.success){
                    this.showToastWithText(response.data.message, 'green', '<i class="fa fa-check-circle"></i>')
                }
                else {
                    this.showToastWithText(response.data.message, 'red', '<i class="fa fa-exclamation-circle"></i>')
                }
            })
            .catch(err => {
                this.showToastWithText('An error was ocurred', 'red', '<i class="fa fa-exclamation-circle"></i>')
            })
        }
    },
    computed:{
        rolesDropdown(){
            return this.roles.map(role => {
                return {
                    label: role.name,
                    value: role.id
                }
            })
        }
    }
}
</script>
