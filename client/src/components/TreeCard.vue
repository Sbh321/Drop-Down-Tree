<template>
  <div class="grid gap-3 grid-cols-1 md:grid-cols-2">
    <div>
      <div class="shadow rounded-lg p-6 bg-white pl-2 overflow-auto h-auto">
        <div
          class="flex items-center cursor-pointer hover:bg-gray-200 p-2 rounded-sm"
          @click="toggleChildren()"
        >
          <h1 class="font-medium text-xl">Linux Distributions:</h1>
          <span class="hover:bg-gray-300 rounded-sm ml-2">
            <component :is="showChildren ? UpArrow : DownArrow" class="" />
          </span>
          <span
            @click.stop="toggleAdd"
            class="hover:bg-gray-300 rounded-sm ml-2 cursor-pointer"
          >
            <span v-if="showAdd">
              <PlusDark />
            </span>
            <span v-else>
              <PlusLight />
            </span>
          </span>
          <span
            class="cursor-pointer ml-2 trash hover:bg-gray-300 rounded-sm"
            @click.stop="handleDelete(node.id)"
          >
            <Trash />
          </span>
        </div>
        <ul class="ml-4" v-if="showChildren">
          <span v-if="showAdd" class="p-1">
            <form @submit.prevent="handleAdd()">
              <div class="relative inline-block">
                <input
                  type="text"
                  name="name"
                  v-model="textInput"
                  class="rounded-[8px] p-1 border-black border-2 focus:border-blue-500 focus:outline-none"
                />
                <Cross
                  @click="toggleAdd"
                  class="hover:bg-gray-300 rounded-[50%] ml-2 absolute right-1 top-[50%] transform -translate-y-1/2 cursor-pointer"
                />
              </div>
            </form>
          </span>
          <TreeNode :nodes="treeData" />
        </ul>
      </div>
    </div>
    <div>
      <div class="shadow rounded-lg p-6 bg-white pl-2 overflow-auto h-auto">
        <h1 class="font-medium text-xl">Linux List</h1>
        <ul class="ml-4">
          <TreeNode :nodes="treeData" />
        </ul>
      </div>
    </div>
    <div>
      <div class="shadow rounded-lg p-6 bg-white pl-2 overflow-auto h-auto">
        <h1 class="font-medium text-xl">Linux List</h1>
        <ul class="ml-4">
          <TreeNode :nodes="treeData" />
        </ul>
      </div>
    </div>
    <div>
      <div class="shadow rounded-lg p-6 bg-white pl-2 overflow-auto h-auto">
        <h1 class="font-medium text-xl">Linux List</h1>
        <ul class="ml-4">
          <TreeNode :nodes="treeData" />
        </ul>
      </div>
    </div>
    <div>
      <div class="shadow rounded-lg p-6 bg-white pl-2 overflow-auto h-auto">
        <h1 class="font-medium text-xl">Linux List</h1>
        <ul class="ml-4">
          <TreeNode :nodes="treeData" />
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import TreeNode from "./TreeNode.vue";
import PlusDark from "./PlusDark.vue";
import PlusLight from "./PlusLight.vue";
import Trash from "./Trash.vue";
import Cross from "./Cross.vue";
import UpArrow from "./UpArrow.vue";
import DownArrow from "./DownArrow.vue";

const props = defineProps(["treeData"]);

const showAdd = ref(false);
const textInput = ref("");
const showChildren = ref(false);

function toggleAdd() {
  if (!showChildren.value) {
    showChildren.value = true;
  }
  showAdd.value = !showAdd.value;
}

function toggleChildren(index) {
  showChildren.value = !showChildren.value;
}

function handleDelete(id) {
  console.log("Deletion for id: ", id);
}

const handleAdd = async () => {
  try {
    const res = await fetch("http://localhost:8000/api/linux", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: textInput.value,
        parent_id: null,
      }),
    });

    if (!res.ok) {
      throw new Error("Network response was not ok");
    }
    const result = await res.json();

    treeData.value.push(result.data);

    textInput.value = "";

    toggleAdd();
  } catch (error) {
    console.error("There was a problem with your fetch operation:", error);
  }
};
</script>
