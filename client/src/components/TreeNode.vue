<template>
  <div
    class="relative pl-4 before:absolute before:top-0 before:bottom-0 before:left-0 before:w-[2px] before:bg-gray-300 before:rounded-full"
  >
    <li v-for="(node, index) in nodes" :key="index">
      <div
        class="flex items-center note hover:bg-gray-200 p-2 rounded-sm cursor-pointer"
        @click="toggleChildren(index)"
      >
        <span class="cursor-pointer select-none" @click.stop="">
          <span v-if="showEdit[index]">
            <form @submit.prevent="handleUpdate(node.id)" class="relative">
              <input
                type="text"
                name="name"
                v-model="node.name"
                class="rounded-[8px] p-1 border-black border-2 focus:border-blue-500 focus:outline-none"
              />
              <Cross
                @click="toggleShowEdit(index)"
                class="hover:bg-gray-300 rounded-[50%] ml-2 absolute right-1 top-[50%] transform -translate-y-1/2"
              />
            </form>
          </span>
          <span v-else @dblclick="toggleShowEdit(index)">{{ node.name }}</span>
        </span>
        <span class="hover:bg-gray-300 rounded-sm ml-2">
          <component :is="showChildren[index] ? UpArrow : DownArrow" class="" />
        </span>
        <span
          v-if="showChildren[index]"
          @click.stop="toggleAdd"
          class="hover:bg-gray-300 rounded-sm ml-2"
        >
          <span v-if="showAdd">
            <PlusDark />
          </span>
          <span v-else>
            <PlusLight />
          </span>
        </span>
        <span
          class="cursor-pointer ml-2 hidden trash hover:bg-gray-300 rounded-sm"
          @click.stop="handleDelete(node.id)"
        >
          <Trash />
        </span>
      </div>

      <!-- Render child nodes if `showChildren` is true -->
      <ul class="ml-8" v-if="showChildren[index]">
        <span v-if="showAdd" class="p-1">
          <form @submit.prevent="handleAdd(node, node.id)">
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
        <span v-if="hasChildren(node)">
          <TreeNode :nodes="node.children" />
        </span>
      </ul>
    </li>
  </div>
</template>

<script setup>
import { ref } from "vue";
import UpArrow from "./UpArrow.vue";
import DownArrow from "./DownArrow.vue";
import PlusDark from "./PlusDark.vue";
import PlusLight from "./PlusLight.vue";
import Trash from "./Trash.vue";
import Cross from "./Cross.vue";

// Accept an array of nodes as props
const props = defineProps({
  nodes: {
    type: Array,
    required: true,
  },
});

// Create a reactive elements
const showChildren = ref([]);
const showAdd = ref(false);
const textInput = ref("");
const showEdit = ref([]);
const name = ref("");

// Function to check if a node has children
function hasChildren(node) {
  return node.children && node.children.length > 0;
}

// Function to toggle the visibility of children for a specific node
function toggleChildren(index) {
  showChildren.value[index] = !showChildren.value[index];
}

function toggleAdd() {
  showAdd.value = !showAdd.value;
}

const toggleShowEdit = (index) => {
  showEdit.value[index] = !showEdit.value[index];
};

const handleAdd = async (node, pid) => {
  console.log(node, pid);

  if (!textInput.value) {
    console.log("Cannot be empty");
  } else if (!textInput.value.trim()) {
    console.log("Cannot be only spaces");
  }

  try {
    const res = await fetch("http://localhost:8000/api/linux", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: textInput.value,
        parent_id: pid,
      }),
    });

    if (!res.ok) {
      throw new Error("Network response was not ok");
    }

    const newNode = await res.json();

    node.children.push(newNode.data);

    textInput.value = "";

    toggleAdd();
  } catch (error) {
    console.error("There was a problem with your fetch operation:", error);
  }
};

const handleDelete = async (id) => {
  try {
    const res = await fetch(`http://localhost:8000/api/linux/cascade/${id}`, {
      method: "DELETE",
    });

    if (!res.ok) {
      throw new Error("Network response was not ok");
    }

    console.log("Item deleted");
  } catch (error) {
    console.log(error);
  }
};

const handleUpdate = async (id) => {
  try {
    const res = await fetch(`http://localhost:8000/api/linux/${id}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: name.value,
      }),
    });

    if (!res.ok) {
      throw new Error("Network response was not ok");
    }

    showEdit.value = false;
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped>
li {
  list-style-type: none;
}

.note:hover .trash {
  display: inline-block;
}
</style>
