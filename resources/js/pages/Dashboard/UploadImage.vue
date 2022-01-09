<template>
    <div class="project-page bg-purple-progress">
        <Navbar />
        <section class="container mx-auto pt-8 relative">
            <div class="flex justify-between items-center">
                <div class="w-full mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">Upload Images</h2>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="w-3/4 mr-6">
                    <h3 class="text-2xl text-white mb-4">Upload Campaign Images</h3>
                </div>
            </div>

            <div class="block mb-2">
                <div class="w-full lg:max-w-full lg:flex mb-4">
                    <div class="w-full border border-gray-400 bg-white rounded p-8 flex flex-col justify-between leading-normal">
                        <div class="elements-wraper">
                            <!--UPLOAD BUTTON-->
                            <div class="button-container image-margin">
                                <label for="images-upload" class="images-upload">
                                    <font-awesome-icon icon="plus-circle" class="custom-icon" />
                                </label>
                                <input @change="uploadImageCampaign($event, id)" id="images-upload" type="file" accept="image/*" multiple hidden>
                            </div>

                            <!--IMAGES PREVIEW-->
                            <div v-for="(image, index) in campaignImages" :key="index" class="image-container image-margin">
                                <div :class="{ 'border-red-500 border-2': image.primary }">
                                    <img :src="image.url" class="images-preview">
                                    <button @click="deleteImageCampaign(image.id, index)" class="close-btn" type="button">
                                        <font-awesome-icon icon="trash" />
                                    </button>

                                    <button @click="setPrimaryImage(image.id, index)" class="set-primary-btn" type="button">
                                        <font-awesome-icon icon="thumbtack" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="w-full px-3 ml-2">
                            <router-link :to="{ name: 'Dashboard' }"
                                         class="bg-green-button hover:bg-green-button text-white font-bold px-4 py-1 rounded inline-flex items-center">
                                Save
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";
import useCampaign from "../../composables/campaign";
import {onMounted} from "vue";

export default {
    name: "UploadImage",
    props: [ "id" ],
    components: { Navbar, Footer },
    setup(props) {
        const { listCampaignImages, uploadImageCampaign, deleteImageCampaign, setPrimaryImage, campaignImages } = useCampaign()

        onMounted(listCampaignImages(props.id))

        return {
            listCampaignImages,
            uploadImageCampaign,
            deleteImageCampaign,
            setPrimaryImage,
            campaignImages
        }
    },
}
</script>

<style scoped>
.image-wraper{
    min-height: 200px !important;

}

.gallery{
    background-color: #fbfbfb !important;
    border-radius: 5px !important;
    border-style: solid !important;
    border: 1px solid #bbbbbb !important;
    height: 85px !important;
    line-height: 1 !important;
    box-sizing: border-box !important;
    height: auto !important;
}

.images-upload {
    background-color: #ffffff !important;
    border-radius: 5px !important;
    border: 1px dashed #ccc !important;
    display: inline-block !important;
    cursor: pointer !important;
    width: 165px !important;
    height: 88px !important;
}

.images-upload:hover{
    background-color: #f1f1f1 !important;
}

.image-container{
    display: inline-table !important;
    height: 90px !important;
    width: 140px !important;
    display: flex !important;
}

.images-preview {
    border-radius: 5px !important;
    border: 1px solid #ccc !important;
    display: inline-block !important;
    width: 140px !important;
    height: 88px !important;
    padding-top: -14px !important;
    transition: filter 0.1s linear;

}

.images-preview:hover{
    filter: brightness(90%);
}

.button-container{
    display: inline-flex !important;
    height: 90px !important;
    width: 140px !important;
    margin-right: 0.25rem !important;
    margin-left: 0.25rem !important;
}

.set-primary-btn {
    background: none !important;
    color: whitesmoke !important;
    border: none !important;
    padding: 0px !important;
    margin:0px !important;
    font: inherit !important;
    cursor: pointer !important;
    outline: inherit !important;
    position: relative !important;
    left: -20px !important;
    top: -25px !important;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
    width: 0px !important;
}

.set-primary-btn svg:hover {
    color: green;
    box-shadow: green 0px 7px 29px 0px !important;
}

.close-btn{
    background: none !important;
    color: white !important;
    border: none !important;
    padding: 0px !important;
    margin:0px !important;
    font: inherit !important;
    cursor: pointer !important;
    outline: inherit !important;
    position: relative !important;
    left: -140px !important;
    top: -25px !important;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
    width: 0px !important;
}

.close-btn svg {
    margin-left: 10px;
    color: red;
}

.close-btn svg:hover {
    color: whitesmoke;
    box-shadow: red 0px 7px 29px 0px !important;
}

.custom-icon{
    color: #00afca !important;
    font-size: 3rem !important;
    margin-top: 18px !important;
    margin-left: 44px !important;

}

.custom-icon:hover{
    color: #29818f !important;
}

/* -------------------- */


.width-100 {
    width: 100% !important;
}

.red-border {
    border: 1px solid #dc3545 !important;
    border-color: #dc3545 !important;
}

.elements-wraper {
    padding: 1rem !important;
    display: flex !important;
    flex-wrap: wrap !important;

}

.align-center {
    text-align: center !important;
}

.m-top-1 {
    margin-top: 0.25rem !important;
}

.image-margin {
    margin-right: 0.25rem !important;
    margin-left: 0.25rem !important;
    margin-top: 0.25rem !important;
    margin-bottom: 0.25rem !important;
}

.red-text {
    color: #d82335;
}
</style>
