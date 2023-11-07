<script setup lang="ts">
import CategoryItems from "@/components/CategoryItems.vue";
import phone from '@/assets/products/phone1.webp'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

const products = ref<InstanceType<any>>([]);

onMounted(() => {
  const server = "http://localhost:3000"
  axios.get(server + route.fullPath).then(function(response) {

    products.value = response.data || [];
  })
})

const handler = (itemId: number) => {
  console.log(itemId)
  router.push({ name: 'category', params: { id: itemId } })
}

/**
 * @document Permutations.ts
 *
 * I wanted to figure out, just for the challenge of it, whether I could, given an array type `A`, produce a type that
 * matches any array with every element of `A` exactly once in any order.  I *love* abusing the TS typing engine.  It
 * insulted my mother once.
 */

/**
 * Returns an array type that includes every element of `T` exactly once in any order.
 *
 * Obviously this produces an `n!` number of matching arrays.  My computer took a few minutes to verify 9-length arrays.
 */
type Permutations<T extends readonly unknown[]> =
    T['length'] extends 0 | 1
        ? T // if T is empty or only has one permutation, just return it
        : {
          // put each member of T first in an array, and concatenate the permutations of T without that member
          [K in keyof T]: [T[K], ...Permutations<ExcludeElement<T, T[K]>>]
        }[keyof T & number]; // get the union of all permutations starting with each element of T

/** Removes the first instance of `T` from `A`. */
type ExcludeElement<A extends readonly any[], T extends any> =
    A extends [infer H, ...infer R]
        ? H extends T ? T extends H
            ? R // we've found T; just return what's left
            : [H, ...ExcludeElement<R, T>] : [H, ...ExcludeElement<R, T>] // H is not our T
        : A;

type A = [1, 2, 3];
type X = Permutations<A>;
const x: X = [5, 1, 4, 2, 3, 6, 7, 9, 8];
</script>

<template>
  <main class="main">
    <section class="catalog">
      <div class="wrapper">
        <div class="catalog__content">
          <CategoryItems @redirectTo="handler" :products="products"></CategoryItems>
        </div>
      </div>
    </section>
  </main>
</template>

<style lang="scss" scoped>
.catalog {
  & .wrapper {
    margin: 0 auto;
  }

  &__content {
    display: flex;
    gap: 15px;
  }
}
</style>