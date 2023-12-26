<template>
    <div class="w-full max-w-md px-2 py-16 sm:px-0">
        <TabGroup>
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
                <Tab
                    v-for="heading in Object.keys(items)"
                    as="template"
                    :key="heading"
                    v-slot="{ selected }"
                >
                    <slot :heading="item" :selected="selected" />
                </Tab>
            </TabList>
            <TabPanels class="mt-2">
                <TabPanel
                    v-for="(content, idx) in Object.values(items)"
                    :key="idx"
                    :class="[
                        'rounded-xl bg-white p-3',
                        'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                    ]"
                >
                    <slot :content="content" />
                
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>

<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

defineProps({
    items: {
        type: Object,
        required: true,
    },
})
</script>
