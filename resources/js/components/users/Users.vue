<template>
    <div>
        <h2>Users</h2>
        <v-client-table
            :data="tableData"
            :columns="columns"
            :options="options"
        >
            <div slot="actions" slot-scope="props" >
                <button class="btn blue btn-small" ><i class="fa fa-edit"></i></button>
                <button class="btn red btn-small" @click="confirmDelete(props.row)"><i class="fa fa-trash"></i></button>
            </div>
        </v-client-table>    
        <v-dialog/>
        <add-user></add-user>
    </div>
    
</template>
<script>
export default {
    data(){
        return {
            columns: [
                'name',
                'lastname',
                'email',
                'phone',
                'role',
                'actions'
            ],
            tableData: [],
            options: {},
            editingUser: {},
            removingUser: {}
        }
    },
    created(){
        this.getUsers()
        
    },
    methods: {
        showToastWithText(text, color = '', icon=''){
            var toastHTML = `<span>${icon} ${text}</span>`
            M.toast({html: toastHTML, classes : color});
        },
        getUsers(){
            axios.get(`${base_url}/api/users`)
            .then(response => {
                const dataTable = response.data.map(user => {
                    return {
                        id: user.id,
                        name: user.name,
                        lastname: user.lastname,
                        phone: user.phone,
                        role: user.roles.length > 0 ? user.roles[0].name : '',
                        email: user.email
                    }
                })
                this.tableData = dataTable
            })
            .catch(err => {
                this.showToastWithText('Error fetching users' ,'red', '<i class="fa fa-exclamation-circle"></i>')
            })
            .finally(() => {
                console.log('requests finished')
            })
        },
        removeUser(id){
            axios.delete(`${base_url}/api/users/${id}`)
            .then(response => {
                let color_message = 'red'
                if(response.status === 200){
                    if(response.data.status){
                        color_message = 'green'
                    }
                    this.showToastWithText(response.data.message, color_message)
                }
                else {
                    this.showToastWithText('An error was ocurred', color_message)
                }
            })
            .catch(err => {
                console.log(err)
                this.showToastWithText('An error was ocurred', color_message)
            })
            .finally();
        },
        confirmDelete(user){
            this.removingUser = user
            this.$modal.show('dialog', {
                title: 'Confirmation!',
                text: 'Do you really want to remove to :' + this.removingUser.name,
                buttons: [
                    {
                        title: 'Continue',
                        handler: () => {this.removeUser(this.removingUser.id)}
                    },
                    {
                        title: '',       // Button title
                        default: true,    // Will be triggered by default if 'Enter' pressed.
                        handler: () => { this.removeUser(this.removingUser.id) } // Button click handler
                    },
                    {
                        title: 'Cancel'
                    }
                ]
            })
            console.log("remove")
        },
        cancelDelete(){
            this.removingUser = {}
            this.$modal.hide('confirm-delete')
        }
    },
    computed: {
        
    }
}
</script>
