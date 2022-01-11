import { readonly } from "vue";
import axios from "axios";
import { reactive, computed } from "vue";
import router from "../router";
import userStore from "./user"

const state = reactive({
    campaign: [],
    campaigns: [],
    campaignImages: []
})

const formState = reactive({
    campaign: []
})

const campaign = computed(() => state.campaign)
const campaigns = computed(() => state.campaigns)
const campaignImages = computed(() => state.campaignImages)

const methods = {
    visitorCampaigns() {
        state.campaigns = []
        axios.get('/api/campaign').then((res) => {
            state.campaigns = res.data.data
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
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    getCampaignsBySlug(slug) {
        const token = localStorage.access_token
        state.campaign = []

        axios.get('/api/campaign/' + slug, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.campaign = res.data.data
            formState.campaign = res.data.data
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    getPerksOnly() {
        if(state.campaign.perks) {
            return state.campaign.perks.split(',')
        }
    },

    fundCampaign(data) {
        const token = localStorage.access_token
        state.campaign = []

        axios.post('/api/transaction/store', data, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            void router.push({ name: "Transactions" })
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    publishCampaign(id) {
        const token = localStorage.access_token
        state.campaigns = []

        axios.get('/api/admin/campaign/publish/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            this.getCampaigns()
            void router.push({ name: "Dashboard" })
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    createCampaign(data) {
        const token = localStorage.access_token
        axios.post('/api/campaign/store', data, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        }).then((res) => {
            let id = res.data.data.id
            void router.push({ name: 'UploadImage', params: { id: id } })
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    removeCampaign(id, index) {
        const token = localStorage.access_token
        axios.delete('/api/campaign/destroy/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            state.campaigns.splice(index, 1)
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    updateCampaign(id, data) {
        const token = localStorage.access_token
        axios.post('/api/campaign/update/' + id, data, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            formState.campaign = []
            state.campaign = []
            void router.push({ name: "Dashboard" })
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    listCampaignImages(campaignId) {
        const token = localStorage.access_token
        state.campaignImages = []
        axios.get('/api/campaign/image/list/' + campaignId, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }).then((res) => {
            res.data.data.forEach((item) => {
                let name = item["file_name"].replace("images/campaign/", "")
                state.campaignImages.push({
                    id: item["id"],
                    url: "/storage/" + item["file_name"],
                    name: name,
                    primary: item["is_primary"]
                })
            })
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    uploadCampaignImage(event, id) {
        const token = localStorage.access_token

        let files = event.target.files
        for(let i=0; i < files.length; i++){
            let formData = new FormData
            let url = URL.createObjectURL(files[i])
            formData.set('image', files[i])
            formData.set('is_primary', false)

            axios.post('/api/campaign/image/upload/' + id, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                },
            }).then((res) => {
                let name = res.data.data["file_name"].replace("images/campaign/", "")

                state.campaignImages.push({
                    id: res.data.data["id"],
                    url: url,
                    name: name,
                    primary: res.data.data["is_primary"],
                    size: files[i].size,
                    type: files[i].type
                })
            }).catch((err) => {
                userStore.methods.clearErrorMessage()
                if(err.response) {
                    void router.push({ name: "Login" })
                    userStore.methods.setErrorMessage("Please login first!")
                }
            })
        }
    },

    deleteCampaignImage(id, index) {
        const token = localStorage.access_token

        axios.delete('/api/campaign/image/destroy/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        }).then((res) => {
            state.campaignImages.splice(index,1)
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    setPrimaryImage(id, index) {
        const token = localStorage.access_token

        axios.get('/api/campaign/image/primary/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        }).then((res) => {
            state.campaignImages = state.campaignImages.map((item, index) => {
                if(item.primary === 1) {
                    state.campaignImages[index].primary = 0
                }
                return item
            })

            state.campaignImages[index].primary = 1
        }).catch((err) => {
            userStore.methods.clearErrorMessage()
            if(err.response) {
                void router.push({ name: "Login" })
                userStore.methods.setErrorMessage("Please login first!")
            }
        })
    },

    resetAll() {
        state.campaign = []
        state.campaigns = []
        state.campaignImages = []
    }
}

export default {
    state: readonly(state),
    formState,
    methods,
    campaigns,
    campaign
}

// export default function useCampaign() {
//     const campaign = ref([])
//     const campaignImages = ref([])
//     const router = useRouter()
//
//     const createCampaign = async (data) => {
//         const token = localStorage.access_token
//         let res = await axios.post('/api/campaign/store', data, {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             },
//         })
//         let id = res.data.data.id
//         await router.push({ name: 'UploadImage', params: { id: id } })
//     }
//
//     const getCampaign = async () => {
//         let response = await axios.get('/api/campaign')
//         campaign.value = response.data.data
//     }
//
//     const getCampaignBySlug = async (slug) => {
//         let response = await axios.get('/api/campaign/' + slug)
//         campaign.value = response.data.data
//     }
//
//     const listCampaignImages = async (campaignId) => {
//         const token = localStorage.access_token
//
//         let res = await axios.get('/api/campaign/image/list/' + campaignId, {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             },
//         });
//         res.data.data.forEach((item) => {
//             let name = item["file_name"].replace("images/campaign/", "")
//             campaignImages.value.push({
//                 id: item["id"],
//                 url: "/storage/" + item["file_name"],
//                 name: name,
//                 primary: item["is_primary"]
//             })
//         })
//     }
//
//     const uploadImageCampaign = async (event, id) => {
//         const token = localStorage.access_token
//
//         let files = event.target.files
//         for(let i=0; i < files.length; i++){
//             let formData = new FormData
//             let url = URL.createObjectURL(files[i])
//             formData.set('image', files[i])
//             formData.set('is_primary', false)
//
//             let res = await axios.post('/api/campaign/image/upload/' + id, formData, {
//                 headers: {
//                     'Authorization': `Bearer ${token}`
//                 },
//             })
//
//             let name = res.data.data["file_name"].replace("images/campaign/", "")
//
//             campaignImages.value.push({
//                 id: res.data.data["id"],
//                 url: url,
//                 name: name,
//                 primary: res.data.data["is_primary"],
//                 size: files[i].size,
//                 type: files[i].type
//             })
//         }
//     }
//
//     const deleteImageCampaign = async (id, index) => {
//         const token = localStorage.access_token
//
//         let res = await axios.delete('/api/campaign/image/destroy/' + id, {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             },
//         })
//         campaignImages.value.splice(index,1)
//     }
//
//     const setPrimaryImage = async (id, index) => {
//         const token = localStorage.access_token
//
//         let res = await axios.get('/api/campaign/image/primary/' + id, {
//             headers: {
//                 'Authorization': `Bearer ${token}`
//             },
//         })
//
//         campaignImages.value = campaignImages.value.map((item, index) => {
//             if(item.primary === 1) {
//                 campaignImages.value[index].primary = 0
//             }
//             return item
//         })
//
//         campaignImages.value[index].primary = 1
//     }
//
//     return {
//         campaign,
//         campaignImages,
//         createCampaign,
//         getCampaign,
//         getCampaignBySlug,
//         listCampaignImages,
//         uploadImageCampaign,
//         deleteImageCampaign,
//         setPrimaryImage
//     }
// }
