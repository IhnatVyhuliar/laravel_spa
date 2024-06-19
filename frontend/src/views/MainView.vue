<script setup>

    // const items = ref([{ message: 'Foo' }, { message: 'Bar' }])
    import { vMaska } from "maska/vue";
    import { computed, onMounted, reactive, ref} from "vue";
    import axios from "axios";
    import { useRouter } from "vue-router";

    const router = useRouter()

    // const credentials = reactive({
    //     phone:null
    // })

    
    // const waitingOnVerification = ref(false)

    onMounted(() => {
        if(localStorage.getItem('token')){
            router.push({
                name: 'main'
            })
        }
    })
 
</script>

<template>
    
</template>