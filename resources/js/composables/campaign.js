import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default function useCampaign() {
    const campaign = ref([])
    const campaignImages = ref([])
    const router = useRouter()

    const createCampaign = async (data) => {
        const token = localStorage.access_token
        let res = await axios.post('/api/campaign/store', data, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        })
        let id = res.data.data.id
        await router.push({ name: 'UploadImage', params: { id: id } })
    }

    const getCampaign = async () => {
        let response = await axios.get('/api/campaign')
        campaign.value = response.data.data
    }

    const getCampaignBySlug = async (slug) => {
        let response = await axios.get('/api/campaign/' + slug)
        campaign.value = response.data.data
    }

    const listCampaignImages = async (campaignId) => {
        const token = localStorage.access_token

        let res = await axios.get('/api/campaign/image/list/' + campaignId, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        });
        res.data.data.forEach((item) => {
            let name = item["file_name"].replace("images/campaign/", "")
            campaignImages.value.push({
                id: item["id"],
                url: "/storage/" + item["file_name"],
                name: name,
                primary: item["is_primary"]
            })
        })
    }

    const uploadImageCampaign = async (event, id) => {
        const token = localStorage.access_token

        let files = event.target.files
        for(let i=0; i < files.length; i++){
            let formData = new FormData
            let url = URL.createObjectURL(files[i])
            formData.set('image', files[i])
            formData.set('is_primary', false)

            let res = await axios.post('/api/campaign/image/upload/' + id, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                },
            })

            let name = res.data.data["file_name"].replace("images/campaign/", "")

            campaignImages.value.push({
                id: res.data.data["id"],
                url: url,
                name: name,
                primary: res.data.data["is_primary"],
                size: files[i].size,
                type: files[i].type
            })
        }
    }

    const deleteImageCampaign = async (id, index) => {
        const token = localStorage.access_token

        let res = await axios.delete('/api/campaign/image/destroy/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        })
        campaignImages.value.splice(index,1)
    }

    const setPrimaryImage = async (id, index) => {
        const token = localStorage.access_token

        let res = await axios.get('/api/campaign/image/primary/' + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
        })

        campaignImages.value = campaignImages.value.map((item, index) => {
            if(item.primary === 1) {
                campaignImages.value[index].primary = 0
            }
            return item
        })

        campaignImages.value[index].primary = 1
    }

    return {
        campaign,
        campaignImages,
        createCampaign,
        getCampaign,
        getCampaignBySlug,
        listCampaignImages,
        uploadImageCampaign,
        deleteImageCampaign,
        setPrimaryImage
    }
}
