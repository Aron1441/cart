<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import { onMounted, onBeforeUpdate, ref, watch, reactive } from "vue";
import axios from "axios";
import phone from "@/assets/products/phone1.webp";
import InputUI from "../UI/InputUI.vue";
import ErrorField from "../components/ErrorField.vue";
import Form from "../components/Form.vue";
import Popup from "../views/PopupView.vue";

const route = useRoute();
const products = ref<InstanceType<typeof Array<{}>>>([]);
let productName = ref(null);
let productPrice = ref(null);
const file = ref(null);
const fileContent = ref(null);

onMounted(() => {
	const server = "http://localhost:3000";
	axios.get(server + route.fullPath).then(function (response) {
		products.value = response.data || [];
		products.value.push({});
	});
});

const fileSelect = () => {
	const reader = new FileReader();

	reader.addEventListener(
		"load",
		() => {
			// this will then display a text file
			fileContent.value = reader.result;
		},
		false
	);
	debugger;
	reader.readAsText(file.value.files[0]);
};
const test = () => {
	console.log("catch");
};
</script>

<template>
	<main class="main">
		<section class="category">
			<div class="wrapper">
				<div class="category__wrapper">
					<a
						class="category__item"
						v-for="product in products"
						:key="product.id"
					>
						<div class="image-container" v-if="isAdmin(product.id)">
							<div class="image-container__likes"></div>
							<img class="image-container__img" :src="phone" alt="phone" />
						</div>
						<div class="category__items-name">{{ product.name }}</div>
						<div class="category__items-name">{{ product.price }}</div>
					</a>
				</div>
				<Popup>
					<template v-slot:content>
						<InputUI
							name="description"
							type="text"
							rules="required|minMax:3,120"
							v-model="productName"
							>Название</InputUI
						>
						<ErrorField name="description"></ErrorField>
						<InputUI
							name="unitPrice"
							type="price"
							v-model="productPrice"
							rules="required|minMax:3,120"
							>Цена</InputUI
						>
						<ErrorField name="unitPrice"></ErrorField>
					</template>
				</Popup>
			</div>
		</section>
	</main>
</template>

<style scoped lang="scss">
@import url(../assets/styles/catalogItem.scss);
</style>
