import { reactive, readonly } from "vue";
import axios from "axios";
import router from '../router'

const state = reactive({
    campaigns: [],
    users: [],
    transactions: [],
    userProfile: [],
    error: []
})

const formState = reactive({
    user: []
})

const methods = {
    getMyProfile() {
        const token = localStorage.access_token
        axios.get('/api/user/', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.userProfile = res.data
            formState.user = res.data
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                this.setErrorMessage("Please login first!")
            }
        })
    },

    login(data) {
        axios.post('/api/auth/login', data, )
            .then((res) => {
                localStorage.setItem("access_token", res.data.access_token)
                void router.push({ name: 'Dashboard' })
            })
            .catch((err) => {
                this.clearErrorMessage()
                if(err.response) {
                    if(err.response.data.errors) {
                        state.error.push(err.response.data.errors)
                        setTimeout(this.clearErrorMessage, 5000)
                        return
                    }
                    void router.push({ name: "Login" })
                    this.setErrorMessage("Your E-mail / Password is incorrect!")
                }
            })
    },

    register(data) {
        axios.post('/api/auth/register', data).then((res) => {
            this.clearErrorMessage()
            let id = res.data.user.id
            localStorage.setItem("access_token", res.data.access_token)
            void router.push({ name: 'UploadPhoto', params: { id: id } })
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                if(err.response.data.errors) {
                    state.error.push(err.response.data.errors)
                    setTimeout(this.clearErrorMessage, 5000)
                    return
                }
                this.setErrorMessage("Something went wrong!")
            }
        })
    },

    updateProfile(id, data) {
        const token = localStorage.access_token
        axios.put('/api/user/edit/' + id, data, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).
        then((res) => {
            this.clearErrorMessage()
            this.getMyProfile()
            void router.push({ name: 'Dashboard' })
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                if(err.response.data.errors) {
                    state.error.push(err.response.data.errors)
                    setTimeout(this.clearErrorMessage, 5000)
                    return
                }
                this.setErrorMessage("Something went wrong!")
            }
        })
    },

    uploadAvatar(event, id) {
        const token = localStorage.access_token
        let files = event.target.files
        for(let i=0; i < files.length; i++) {
            let formData = new FormData
            formData.set('image', files[i])

            axios.post('/api/user/edit/avatar/' + id, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }).then((res) => {
                state.userProfile = res.data
            }).catch((err) => {
                    this.clearErrorMessage()
                    if(err.response) {
                        void router.push({ name: "Login" })
                        this.setErrorMessage("Please login first!")
                    }
            })
        }
    },

    getCampaigns() {
        const token = localStorage.access_token
        axios.get('/api/user/campaigns', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.campaigns = res.data.data
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                this.setErrorMessage("Please login first!")
            }
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
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                this.setErrorMessage("Please login first!")
            }
        })
    },

    getTransactions() {
        const token = localStorage.access_token
        axios.get('/api/transaction', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.transactions = res.data.data
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                this.setErrorMessage("Please login first!")
            }
        })
    },

    verifyTransactions(id) {
        if(state.userProfile?.role !== 1) {
            void router.push({ name: "Dashboard" })
            return
        }

        const token = localStorage.access_token
        axios.get('/api/admin/transaction/verify/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then(() => {
            this.getTransactions()
            void router.push({ name: "Transactions" })
        }).catch((err) => {
            this.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                this.setErrorMessage("Please login first!")
            }
        })
    },

    setErrorMessage(errMsg) {
        state.error.push({
            "general": errMsg
        })
        setTimeout(this.clearErrorMessage, 5000)
    },

    clearErrorMessage() {
        state.error = []
    },

    resetAll() {
        state.campaigns = []
        state.users = []
        state.transactions = []
        state.userProfile = []
        state.error = []
    }
}

export default {
    state: readonly(state),
    methods,
    formState
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
