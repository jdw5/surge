<template>
    <div>
        <div :class="$attrs.class">
            <div v-if="!hideLabel">
                <FormLabel class="mb-1" :for="id" :class="{'sr-only' : srLabel}">
                    {{ label }}
                </FormLabel>
            </div>
            <slot :id="id" :errorId="ariaDescribedBy">
                <FormInput :id="id"
                    v-model="text" 
                    :aria-described-by="ariaDescribedBy"
                    v-bind="$attrs"
                />
            </slot>
        </div>
        <FormError v-if="!hideError" :id="ariaDescribedBy" :error="error" class="mt-0.5"/>
    </div>
</template>

<script setup>
import { computed } from "vue"
import FormInput from "./FormInput.vue"
import FormError from "./FormError.vue"
import FormLabel from "./FormLabel.vue"
import useId from "@/Lib//useId/useId"

const props = defineProps({
    label: {
        type: String,
        required: true
    },

    error: {
        type: [String],
        required: false
    },

    // Options
    hideError: {
        type: Boolean,
        default: false
    },

    hideLabel: {
        type: Boolean,
        default: false
    },

    srLabel: {
        type: Boolean,
        default: false
    }
})

const id = useId()
const text = defineModel()

const ariaDescribedBy = computed(() => id + '_error')

</script>