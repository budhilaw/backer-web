import { ref } from "vue";
import axios from "axios";

export default function useCampaign() {
    const campaign = ref([])

    const getCampaign = async () => {
        let response = await axios.get('/api/campaign')
        campaign.value = response.data.data
    }

    const getCampaignBySlug = async (slug) => {
        let response = await axios.get('/api/campaign/' + slug)
        campaign.value = response.data.data
    }

    return {
        campaign,
        getCampaign,
        getCampaignBySlug
    }
}
