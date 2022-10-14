<script setup>
import { defineProps, ref, computed } from 'vue'
import beautify from 'js-beautify';
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
    hasQuery: {
        type: Boolean,
        default: false
    }
})

const responseData = ref('')
const responseStatus = ref(0);
const payload = ref('')
const queryParams = ref([{
    name: '',
    value: ''
}]);
const statusClass = computed(() => {
    return `status-${responseStatus.value}`
})
const query = computed(() => {
    return `?${queryParams.value.filter((el) => el.name !== '' && el.value !== '').map((el) => `${el.name}=${el.value}`).join('&')}`;
})
const apiCode = computed(() => {
    try {
        const p = JSON.parse(payload.value);
        return beautify(`${props.method}("https://api.uncnso.red${props.endpoint}${query.value}", ${JSON.stringify(p)})`);
    } catch (e) {
        return beautify(`${props.method}('https://api.uncnso.red${props.endpoint}${query.value}', {})`);
    }
});

const addQuery = () => {
    queryParams.value.push({
        name: '',
        value: ''
    })
}

const removeQuery = (index) => {
    queryParams.value.splice(index, 1);
    if (queryParams.value.length === 0) addQuery();
}

const request = () => {
    responseData.value = '';
    responseStatus.value = 0;
    let p = {};
    try {
        if (payload.value !== "") {
            p = JSON.parse(payload.value);
        }
    } catch (e) {
        responseStatus.value = 400;
        responseData.value = beautify('{ "status": 400, "status_msg": "bad payload" }');
        return;
    }
    
    axios({
        method: props.method,
        url: 'http://localhost:8084' + props.endpoint + query.value,
        data: {
            ...p
        }
    })
    .then((res) => {
        responseStatus.value = 200;
        const strippedData = Array.isArray(res.data) ? res.data.splice(0, 5) : res.data;
        responseData.value = beautify(JSON.stringify(strippedData));
    })
    .catch((e) => {
        responseStatus.value = e.response.status;
        responseData.value = beautify(JSON.stringify(e.response.data));
    });
}

</script>

<template>
    <div class="api-tester">
        <p class="apiCode">
            <div>
                <code v-text="apiCode" />
            </div>
            <button @click="request">Submit</button>
        </p>
        <template v-if="hasQuery">
            <h6>Query Params <a href="javascript:void(0)" @click="addQuery">Add</a></h6>
            <div v-for="(param, index) in queryParams" v-bind:key="index">
                <p style="display: flex; align-items: center;">
                    <input style="flex-grow: 1; flex-shrink: 1; min-width: 50px;" placeholder="name" v-model="param.name" type="text" :name="`text_${param.name}_name`" />
                    &nbsp;:&nbsp;
                    <input style="flex-grow: 1; flex-shrink: 1; min-width: 50px;" placeholder="value" v-model="param.value" type="text" :name="`text_${param.name}_value`" />
                    &nbsp;<a href="javascript:void(0)" @click="removeQuery(index)">Remove</a>
                </p>
            </div>
        </template>
        <template v-if="method === 'POST'">
            <h6>Body Payload</h6>
            <textarea v-model="payload"></textarea>
        </template>
        <h6>Result</h6>
        <highlightjs
            class="hljs-wrapper language-json ext-json"
            :class="statusClass"
            language="json"
            :code="responseData"
        />
    </div>
</template>

<script>
export default {
    name: 'api-tester'
}
</script>

<style lang="scss" scoped>
    textarea {
        width: 100%;
        height: 100px;
        font-family: var(--font-family-code);
        font-size: 0.85em;
        padding: 1.3rem 1.5rem;
        margin: 0.85rem 0;
        border-radius: 6px;
        box-sizing: border-box;
    }

    .apiCode {
        white-space: pre;
        width: 100%;
        background-color: var(--c-bg-lighter);
        padding: 1.3rem 1.5rem;
        padding-bottom: 3.4rem;
        box-sizing: border-box;
        border-radius: 6px;
        position: relative;

        div {
            overflow: auto;
        }

        button {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 0.25rem 1.6rem;
        }
    }

    .hljs-wrapper {
        max-height: 200px;
    }

    input {
        padding: 0.5rem;
        font-family: var(--font-family-code);
        font-size: 0.85em;
    }

    button {
        color: var(--c-bg);
        background-color: var(--c-brand);
        border-color: var(--c-brand);
        display: inline-block;
        font-size: 1.2rem;
        padding: 0.8rem 1.6rem;
        border-width: 2px;
        border-style: solid;
        border-radius: 4px;
        transition: background-color var(--t-color);
        box-sizing: border-box;
        cursor: pointer;

        &:hover {
            background-color: var(--c-brand-light);
            border-color: var(--c-brand-light);
        }
    }

    .status-200 {
        background: rgb(38, 68, 41);
    }

    .status-400, .status-401 {
        background: #442626;
    }
</style>