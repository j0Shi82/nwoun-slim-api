<script setup>
import { defineProps, ref } from 'vue'
import axios from 'axios';

const props = defineProps({
    endpoint: {
        type: String,
        required: true
    },
    method: {
        type: String,
        required: true
    },
})

const response = ref('')
const payload = ref('')

const request = () => {
    response.value = '';
    let p = {};
    try {
        p = JSON.parse(payload.value);
    } catch (e) {
        response.value = '{ "status": 400, "status_msg": "bad payload" }';
        return;
    }
    
    axios.post('http://localhost:8084/v1/auth/login', {
        ...p
    })
    .then((res) => {
        response.value = res.data;
    })
    .catch((e) => {
        response.value = e.response.data;
    });
}

</script>

<template>
    <div class="api-tester">
        <textarea v-model="payload"></textarea>
        <button @click="request">Submit</button>
        <Code>{{ response }}</Code>
    </div>
</template>

<script>
export default {
    name: 'api-tester'
}
</script>