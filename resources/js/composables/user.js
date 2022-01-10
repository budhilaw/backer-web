import { reactive, readonly } from "vue";
import axios from "axios";
import router from '../router'

const state = reactive({
    campaigns: [],
    user: []
})

const methods = {
    login(data) {
        axios.post('/api/auth/login', data)
            .then((res) => {
                localStorage.setItem("access_token", res.data.access_token)
                void router.push({ name: 'Dashboard' })
            })
            .catch((err) => {
                console.log(err)
            })
    },

    getCampaigns() {
        const token = localStorage.access_token
        axios.get('/api/user/campaigns', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.campaigns = res.data.data
        })
    },

    removeCampaign(id) {
        const token = localStorage.access_token
        axios.delete('/api/campaign/destroy/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.campaigns = res.data.data
        })
    }
}

export default {
    state: readonly(state),
    methods
}

// export default function useUser() {
//     const user = ref([])
//     const router = useRouter()
//     const errors = ref([])
//
//     const storeUser = async (data) => {
//         await axios.post('/api/backer', data)
//         await router.push({name: 'user.dashboard'})
//     }
//
//     const register = async (data) => {
//         try {
//             await axios.post('/api/auth/register', data)
//             await router.push({name: 'Login'})
//         } catch (e) {
//             if(e.response.status === 422) {
//                 for(const key in e.response.data.errors) {
//                     errors.value[key] = e.response.data.errors[key][0]
//                 }
//             } else if(e.response.status === 401) {
//                 errors.value['general'] = e.response.data.error
//             }
//         }
//     }
//
//     const login = async (data) => {
//         try {
//             let res = await axios.post('/api/auth/login', data)
//             await localStorage.setItem("access_token", res.data.access_token)
//
//             await router.push({name: 'Home'})
//         } catch (e) {
//             if(e.response.status === 422) {
//                 for(const key in e.response.data.errors) {
//                     errors.value[key] = e.response.data.errors[key][0]
//                 }
//             } else if(e.response.status === 401) {
//                 errors.value['general'] = e.response.data.error
//             }
//         }
//     }
//
//     const getCampaigns = async () => {
//         const token = localStorage.access_token
//         let res = await axios.get('/api/user/campaigns', {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             }
//         })
//         state.campaigns = res.data.data
//     }
//
//     const removeCampaign = async (id) => {
//         const token = localStorage.access_token
//         let res = await axios.delete('/api/campaign/destroy/' + id, {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             }
//         })
//         state.campaigns = res.data.data
//     }
//
//     return {
//         user,
//         errors,
//         login,
//         register,
//         storeUser,
//         getCampaigns,
//         removeCampaign
//     }
// }
