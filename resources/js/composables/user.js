import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default function useUser() {
    const user = ref([])
    const campaigns = ref([])
    const router = useRouter()
    const errors = ref([])

    const storeUser = async (data) => {
        await axios.post('/api/backer', data)
        await router.push({name: 'user.dashboard'})
    }

    const register = async (data) => {
        try {
            await axios.post('/api/auth/register', data)
            await router.push({name: 'Login'})
        } catch (e) {
            if(e.response.status === 422) {
                for(const key in e.response.data.errors) {
                    errors.value[key] = e.response.data.errors[key][0]
                }
            } else if(e.response.status === 401) {
                errors.value['general'] = e.response.data.error
            }
        }
    }

    const login = async (data) => {
        try {
            let res = await axios.post('/api/auth/login', data)
            await localStorage.setItem("access_token", res.data.access_token)

            await router.push({name: 'Home'})
        } catch (e) {
            if(e.response.status === 422) {
                for(const key in e.response.data.errors) {
                    errors.value[key] = e.response.data.errors[key][0]
                }
            } else if(e.response.status === 401) {
                errors.value['general'] = e.response.data.error
            }
        }
    }

    const getCampaigns = async () => {
        const token = localStorage.access_token
        try {
            let res = await axios.get('/api/user/campaigns', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            campaigns.value = res.data.user.campaigns
        } catch (e) {
            if(e.response.status === 422) {
                for(const key in e.response.data.errors) {
                    errors.value[key] = e.response.data.errors[key][0]
                }
            } else if(e.response.status === 401) {
                errors.value['general'] = e.response.data.error
            }
        }
    }

    return {
        user,
        errors,
        campaigns,
        login,
        register,
        storeUser,
        getCampaigns
    }
}
