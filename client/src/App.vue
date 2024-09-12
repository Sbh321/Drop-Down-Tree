<template>
  <main class="mx-auto max-w-custom">
    <header>
      <!-- <img src="./assets/pinia-logo.svg" alt="pinia logo" /> -->
      <div class="mt-4 mb-12 flex justify-center items-center gap-4">
        <h1 class="text-4xl">Tree DropDown</h1>
        <button
          class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 transition duration-300 ease-in-out"
        >
          Add a List
        </button>
      </div>
    </header>

    <div>
      <TreeCard :treeData="treeData" />
    </div>
  </main>
</template>

<script setup>
import { onMounted, ref } from "vue";
import TreeCard from "./components/TreeCard.vue";

const treeData = ref();

const data = ref([]);

function buildHierarchy(arr, parentId = null) {
  return arr
    .filter((item) => item.parent_id === parentId)
    .map((item) => {
      const children = buildHierarchy(arr, item.id);
      return { id: item.id, name: item.name, children };
    });
}

const fetchData = async () => {
  try {
    const res = await fetch("http://localhost:8000/api/linux/old");
    if (!res.ok) {
      throw new Error("Network response was not ok");
    }
    const parRes = await res.json();
    data.value = parRes.data;
    treeData.value = buildHierarchy(data.value);
    // console.log(buildHierarchy(data.value));
  } catch (error) {
    console.error("There was a problem with your fetch operation:", error);
  }
};
onMounted(() => {
  fetchData();
});
</script>

<style scoped>
.max-w-custom {
  max-width: calc(100% - 20%);
}
</style>
