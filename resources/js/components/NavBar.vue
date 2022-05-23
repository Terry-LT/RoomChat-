<template>
    <!--https://colorhunt.co/palette/9adcfffff89affb2a6ff8aae-->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #9ADCFF;">
        <div class="container-fluid">
          <router-link class="navbar-brand" :to="{name:'home'}">Room Chat</router-link>
          
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" v-if="!laravel.isLoggedin">
                <li class="nav-item">
                  <router-link class="nav-link" :to="{name:'login'}">Login</router-link>
                 
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" :to="{name:'register'}">Register</router-link>
                 
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" v-else>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="#">{{laravel.user.nickname}}</a>
                </li>
                <li class="nav-item">
                   <Logout v-bind:laravel="laravel" />
                </li>
            </ul>
          </div>
        </div>
      </nav>
</template>
<script>
import Logout from "../components/auth/Logout.vue"
export default {
    data:function(){
        return {
            laravel:window.Laravel,
        }
    },
    components:{
        Logout
    },
    created(){
      //if user did not login/register
      if (this.laravel.user == null){
        //redirect to home page
        this.$router.push({name:'home'});
      }
    }
}
</script>