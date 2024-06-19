
<template>
    <div class="pt-16 text-center">
        <h1 class="text-3xl font-semibold mb-4">Enter your email</h1>
        <form v-if="!waitingOnVerification" action="#" @submit.prevent="handleLogin">
            <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
                <div class="bg-white px-4 py-5 sm:p-6">
                    <div>
                        <input type="email"  v-model="credentials.email" name="email" placeholder="example@gmail.com"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm">

                    </div>
                </div>
                <div  class="bg-gray-50 px-4 py-3 text-right sm: px-6">
                    <button type="submit" @submit.prevent="handleLogin" class="inline-flex justify-center rounded-md border border-transparent
                    bg-black py-2 text-white">Login</button>

                </div>
            </div>
        </form>

        <form v-else action="#" @submit.prevent="handleVerification">
            <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
                <div class="bg-white px-4 py-5 sm:p-6">
                    <div>
                        <input type="text" v-maska data-maska="######" v-model="credentials.login_code" name="phone" placeholder="234334"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm">

                    </div>
                </div>
                <div  class="bg-gray-50 px-4 py-3 text-right sm: px-6">
                    <button type="submit" @submit.prevent="handleVerification" class="inline-flex justify-center rounded-md border border-transparent
                    bg-black py-2 text-white">Verify</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
   import { vMaska } from "maska/vue";
    import { computed, onMounted, reactive, ref} from "vue";
    import axios from "axios";
    import { useRouter } from "vue-router";

    const router = useRouter()

    const credentials = reactive({
        phone:null
    })

    
    const waitingOnVerification = ref(false)

    onMounted(() => {
        if(localStorage.getItem('token')){
            router.push({
                name: 'main'
            })
        }
    })

    const getformattedCredentials = () => {
        return {
            email: credentials.email,
            login_code: credentials.login_code
        } 
    }

    const handleLogin = () => {
        //alert(credentials.phone.replaceAll(' ', '').replace('(', '').replace(')', '').replace('-', ''));
        axios.post('http://127.0.0.1:8000/api/v1/login', getformattedCredentials())
        .then((response) => {
            console.log(response.data)
            waitingOnVerification.value = true
        })
        .catch((error)=> {
            console.error(error)
            alert(error.response.data.message)
        })
    }

    const handleVerification = () => {
        axios.post('http://127.0.0.1:8000/api/v1/login/authorise', getformattedCredentials())
            .then((response)=> {
                console.log(response.data) //token
                localStorage.setItem('token', response.data.token)
                router.push({
                    name: 'main'
                })
            })
            .catch((error)=> {
                console.error(error)
                alert(error.response.data.message)
            })
    }   
    
</script>
