import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default function useUser() {
    const user = ref([])
    const router = useRouter()
    const errors = ref('')

    const storeUser = async (data) => {
        await axios.post('/api/backer', data)
        await router.push({name: 'user.dashboard'})
    }

    return {
        user,
        errors,
        storeUser
    }
}
