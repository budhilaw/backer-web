<template>
    <router-view />
</template>

<script>
import { provide } from 'vue';
import userStore from '../composables/user';
import campaignStore from '../composables/campaign';

export default {
    setup() {
        provide('userStore', userStore)
        provide('campaignStore', campaignStore)
    }
};
</script>
