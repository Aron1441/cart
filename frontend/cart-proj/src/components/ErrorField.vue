<script setup lang="ts">
import {
	toRef,
	toValue,
	ref,
	onMounted,
	watchEffect,
	onBeforeUpdate,
	computed,
} from "vue";
import type { Ref } from "vue";
import { useStore, mapGetters } from "vuex";
const store = useStore();

let isValid = computed(() => store.getters.getIsValid(props.name));

const props = defineProps<{
	name: string;
}>();
</script>

<template>
	<div
		:style="{ visibility: !isValid ? 'visible' : 'hidden' }"
		class="error"
		:class="[isValid ? 'valid' : 'invalid']"
	>
		ERROR
	</div>
</template>

<style scoped lang="scss">
.error {
	&::before,
	&::after {
		content: "";
		display: block;
		height: 20px;
		float: left;
		clear: both;
	}
}
.invalid {
	color: red;
}
</style>
