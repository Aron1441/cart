<script setup lang="ts">
import phone from "@/assets/products/phone1.webp";
const emit = defineEmits(['redirect-to'])
interface Props {
  products: { id: number, name: string, img: string }[] | []
}

const props = defineProps<Props>()

</script>

<template>
    <a class="catalog__items" v-for="category in props.products" :key="category.id" @click="emit('redirect-to', category.id)">
      <div class="catalog__items-name">{{ category.name }}</div>
      <img class="catalog__items-image" :src="phone" alt="phone">
    </a>
</template>

<style lang="scss" scoped>
.catalog {
  &__items {
    position: relative;
    display: block;
    width: calc(33%);
    border-radius: 5px;
    background: #2c3e50;
    cursor: pointer;
  }

  &__items-name {
    position: absolute;
    width: 100%;
    padding: 10px 118px 0 15px;
  }

  &__items-image {
    height: 100px;
    margin-left: auto;
  }
}
</style>