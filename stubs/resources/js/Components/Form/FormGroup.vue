<template>
    <div>
        <div :class="$attrs.class">
            <div>
                <FormLabel class="mb-1" :for="id" :class="{'sr-only' : srLabel}">
                    {{ label }}
                </FormLabel>
            </div>
            <slot :id="id" :errorId="ariaDescribedBy">
                <FormInput :id="id"
                    v-model="text" 
                    :aria-describedby="ariaDescribedBy"
                    v-bind="$attrs"
                />
            </slot>
        </div>
        <FormError v-if="!hideErrors" :id="ariaDescribedBy" :message="error" class="mt-0.5"/>
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
    hideErrors: {
        type: Boolean,
        default: false
    },

    hideDescribedBy: {
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

const ariaDescribedBy = computed(() => !props.hideDescribedBy ? id + '_error' : null)

</script>