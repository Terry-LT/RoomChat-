<template>
<div>


<div class="container">
    <div class="border border-primary border-2 rounded mt-5">
        <form class="pt-3 pb-3 ps-3 pe-3">
            <legend class="text-center">Register</legend>
            <div class="mb-3">
                <label :class="{'form-label border-danger':error.name.message}" 
                class="form-label">Name</label>
                <input :class="{'form-control border-danger':error.name.message}" v-model="name" 
                name="name" class="form-control" type="text">
                <MessageAlert :message="error.name.message" />
            </div>
            <div class="mb-3">
                <label :class="{'form-label border-danger':error.surname.message}" 
                 class="form-label">Surname </label>
                <input :class="{'form-control border-danger':error.surname.message}"
                 v-model="surname" name="surname" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label :class="{'form-label border-danger':error.nickname.message}"  
                class="form-label">Nickname <span class="text-danger">*</span></label>
                <input :class="{'form-control border-danger':error.nickname.message}"
                 v-model="nickname" name="nickname" class="form-control" type="text">
                 <MessageAlert :message="error.nickname.message" />
            </div>
            <div class="mb-3">
                <label :class="{'form-label border-danger':error.email.message}"  
                 class="form-label">Email <span class="text-danger">*</span></label>
                <input :class="{'form-control border-danger':error.email.message}"
                  v-model="email" name="email" class="form-control" type="email">
                <MessageAlert :message="error.email.message" />
            </div>
            <div class="mb-3">
                <label :class="{'form-label border-danger':error.password.message}" 
                 class="form-label">Password <span class="text-danger">*</span></label>
                <input :class="{'form-control border-danger':error.password.message}"
                  v-model="password" name="password" class="form-control" type="password">
                   <MessageAlert :message="error.password.message" />
            </div>
            <div class="mb-3 form-check">
                <input name="remember_me" v-model="remember_me" type="checkbox" class="form-check-input">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            <div class="mb-3">
                <button @click="register" class="btn btn-primary" type="button">Register</button>
            </div>
        </form>
    </div>
</div>

</div>
</template>
<script>
//import NavBar from "../NavBar.vue"
import MessageAlert from "./MessageAlert.vue"
export default {
    data:function(){
        return {
            name:'',
            surname:'',
            nickname:'',
            email:'',
            password:'',
            remember_me:false,
            laravel:window.Laravel,

            error:{
                name:{
                    message:null
                },
                surname:{
                    message:null
                },
                nickname:{
                    message:null
                },
                email:{
                    message:null
                },
                password:{
                    message:null
                },
            }

        }
    },
    components:{
        MessageAlert,//NavBar
    },
    created(){
        //console.log(this.laravel.user);
        //console.log(this.laravel.isLoggedin);
        if (this.laravel.isLoggedin){
           this.$router.push({name:'home'});
        }
    },
    mounted(){

    },
    methods:{
        showError:function(errors){
            if (errors.name != null){
                this.error.name.message = errors.name[0];
            }
            if (errors.surname != null){
                this.error.surname.message = errors.surname[0];
            }
            if (errors.nickname != null){
                this.error.nickname.message = errors.nickname[0];
            }
            if (errors.email != null){
                this.error.email.message = errors.email[0];
            }
            if (errors.password != null){
                this.error.password.message = errors.password[0];
            }
        },
        closeErrors:function(){
            this.error.name.message = null;
            this.error.email.message = null;
            this.error.surname.message = null;
            this.error.nickname.message = null;
            this.error.password.message = null;
        },
        register:function(){
            this.closeErrors()
            let showError = this.showError;
            axios.get('/sanctum/csrf-cookie').then(response => {
            let data = {
                'name':this.name,
                'surname':this.surname,
                'nickname':this.nickname,
                'email':this.email,
                'password':this.password,
                'remember_me':this.remember_me,
            };
            //call api to register user
            axios.post("/api/register",data)
            .then(response => {
                if (response.data.success) {
                    this.$router.push("login");
                } 
                else{
                    alert(response.data.message);
                    console.log(response.data.message);
                }
            })
            .catch(function(error){
                console.log(error);
                console.log(error.response.data);
                if (error.response.status == 422){
                    console.log(error.response.data.errors);
                    showError(error.response.data.errors);
                }
               
            });
            });
        }
    }
}
</script>