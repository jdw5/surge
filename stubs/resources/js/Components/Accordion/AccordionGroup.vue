<template>
    <dl class="mt-10 space-y-6 divide-y divide-gray-900/10">
        <slot :openedIndex="openedIndex" :openAccordion="openAccordion"/>
    </dl>
</template>
<script setup>

const openedIndex = ref(null);

const openAccordion = (index) => {
    if (openedIndex.value === index) {
        openedIndex.value = null; 
    } else {
        openedIndex.value = index;
    }
};

</script>