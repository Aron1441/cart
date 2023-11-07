<script setup lang="ts">
import _ from "lodash";
import {
	toRef,
	toValue,
	ref,
	onMounted,
	watchEffect,
	reactive,
	toRefs,
} from "vue";
import { useStore } from "vuex";
import { ValidatorF } from "../components/validator";

export type propsType = typeof props;

const props = defineProps<{
	modelValue: string;
	type: typeValues;
	name: string;
	rules?: string;
}>();

const emit = defineEmits(["update:modelValue"]);

const store = useStore();
const propRefs = toRefs(props);
const isValid = ValidatorF(propRefs);

store.dispatch("updateIsValid", [props.name, isValid.value]);

watchEffect(() => {
	store.dispatch("updateIsValid", [props.name, isValid.value]);
});

const pattern = new RegExp("([A-Za-z]+(\\|)?)+");
const input = ref<HTMLInputElement>();

onMounted(() => {
	let res = pattern.test(props.rules || "undefined");

	if (!res) throw Error("Неверно задано правило");
});
</script>

<template>
	<div class="input">
		<label class="input__name" for="name"><slot></slot></label>
		<input
			ref="input"
			:class="[`input__inner ${props.error}`]"
			:value="props.modelValue"
			@input="emit('update:modelValue', $event.target.value)"
			id="name"
			type="text"
		/>
	</div>
</template>

<style scoped lang="scss">
@import url(../assets/styles/inputUI.scss);
</style>
