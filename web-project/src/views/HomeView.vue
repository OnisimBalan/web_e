<template>
  <div class="home">
    <Start />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Start from "@/components/Start.vue"; // @ is an alias to /src

@Options({
  components: {
    Start,
  },
})
export default class HomeView extends Vue {}
</script>
